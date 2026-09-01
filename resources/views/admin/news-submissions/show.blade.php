@php
    $badgeClass = match($submission->status) {
        'approved' => 'badge-green',
        'rejected' => 'badge-red',
        'reviewed' => 'badge-gold',
        default => 'badge-gray',
    };
@endphp

<x-admin-layout :page-title="'Detail Pengajuan Berita'" :page-subtitle="$submission->title">

  <div style="margin-bottom:18px;">
    <a href="{{ route('admin.news-submissions.index') }}" class="btn btn-ghost btn-sm">&larr; Kembali ke Daftar Pengajuan</a>
  </div>

  <div class="form-grid">
    <div>
      <div class="form-card">
        <h3>{{ $submission->title }}</h3>

        <div style="display:flex; gap:10px; align-items:center; margin:4px 0 20px;">
          <span class="badge {{ $badgeClass }}">{{ $submission->status_label }}</span>
          <span class="sub" style="font-size:12.5px; color:var(--muted-2);">Dikirim {{ $submission->created_at->translatedFormat('d F Y, H:i') }}</span>
        </div>

        @if($submission->image_url)
          <div class="field">
            <label>Lampiran Foto</label>
            <img src="{{ $submission->image_url }}" alt="Lampiran dari {{ $submission->name }}" style="max-width:100%; border-radius:8px; border:1px solid var(--paper-line);">
          </div>
        @endif

        <div class="field">
          <label>Isi / Ringkasan Berita</label>
          <p style="white-space:pre-line; line-height:1.7; font-size:14.5px;">{{ $submission->content }}</p>
        </div>
      </div>
    </div>

    <div class="sticky-side">
      <div class="form-card">
        <h3>Pengirim</h3>
        <div class="field">
          <label>Nama</label>
          <p>{{ $submission->name }}</p>
        </div>
        <div class="field">
          <label>Email</label>
          <p><a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></p>
        </div>
      </div>

      <div class="form-card">
        <h3>Tinjau Pengajuan</h3>
        <form method="POST" action="{{ route('admin.news-submissions.update-status', $submission) }}">
          @csrf
          @method('PATCH')

          <div class="field">
            <label for="statusSelect">Status</label>
            <select id="statusSelect" name="status" required>
              @foreach(\App\Models\NewsSubmission::STATUSES as $key => $label)
                <option value="{{ $key }}" @selected(old('status', $submission->status) === $key)>{{ $label }}</option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label for="adminNote">Catatan Internal <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <textarea id="adminNote" name="admin_note" style="min-height:100px;" placeholder="Catatan untuk tim redaksi, mis. alasan penolakan atau tindak lanjut…">{{ old('admin_note', $submission->admin_note) }}</textarea>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-accent">Simpan Status</button>
          </div>
        </form>
      </div>

      <div class="form-card">
        <form method="POST" action="{{ route('admin.news-submissions.destroy', $submission) }}" data-confirm="Hapus pengajuan berita ini? Tindakan ini tidak bisa dibatalkan.">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger btn-block">Hapus Pengajuan Ini</button>
        </form>
      </div>
    </div>
  </div>

</x-admin-layout>
