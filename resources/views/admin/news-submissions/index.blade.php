<x-admin-layout :page-title="'Pengajuan Berita'" :page-subtitle="'Usulan berita &amp; laporan yang dikirim pembaca lewat formulir Ajukan Berita'">

  <div class="filter-bar">
    <form method="GET" action="{{ route('admin.news-submissions.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach(\App\Models\NewsSubmission::STATUSES as $key => $label)
          <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
        @endforeach
      </select>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, nama, atau email…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      @if(request()->anyFilled(['status','q']))
        <a href="{{ route('admin.news-submissions.index') }}" class="btn btn-ghost btn-sm">Reset</a>
      @endif
    </form>
    @if($pendingCount > 0)
      <span class="badge badge-red">{{ $pendingCount }} menunggu ditinjau</span>
    @endif
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Tiket</th>
            <th>Judul Usulan</th>
            <th>Pengirim</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($submissions as $submission)
            <tr>
              <td class="sub">#{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</td>
              <td class="title-cell">
                <a href="{{ route('admin.news-submissions.show', $submission) }}">{{ $submission->title }}</a>
                @if($submission->image_path)<div class="sub">📎 dengan lampiran foto</div>@endif
              </td>
              <td>
                {{ $submission->name }}
                <div class="sub">{{ $submission->email }}</div>
                @if($submission->phone)<div class="sub">{{ $submission->phone }}</div>@endif
              </td>
              <td>
                @php
                  $badgeClass = match($submission->status) {
                    'approved' => 'badge-green',
                    'rejected' => 'badge-red',
                    'reviewed' => 'badge-gold',
                    default => 'badge-gray',
                  };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $submission->status_label }}</span>
              </td>
              <td>{{ $submission->created_at->translatedFormat('d M Y, H:i') }}</td>
              <td>
                <div class="row-actions">
                  <a href="{{ route('admin.news-submissions.show', $submission) }}" class="btn btn-ghost btn-sm">Lihat</a>
                  <form method="POST" action="{{ route('admin.news-submissions.destroy', $submission) }}" data-confirm="Hapus pengajuan berita &quot;{{ $submission->title }}&quot;? Tindakan ini tidak bisa dibatalkan.">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6"><div class="empty-state"><h3>Belum ada pengajuan berita</h3><p>Usulan berita yang dikirim pembaca lewat formulir "Ajukan Berita" akan muncul di sini.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap">{{ $submissions->links() }}</div>

</x-admin-layout>