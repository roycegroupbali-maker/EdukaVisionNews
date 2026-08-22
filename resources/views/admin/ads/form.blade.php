@php
    $isEdit = $isEdit ?? false;
    $action = $isEdit ? route('admin.ads.update', $ad) : route('admin.ads.store');
@endphp

<x-admin-layout :page-title="$isEdit ? 'Edit Iklan' : 'Upload Iklan Baru'" :page-subtitle="'Materi iklan akan tayang otomatis di slot yang dipilih'">

  <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="form-grid">
      <div>
        <div class="form-card">
          <h3>Materi Iklan</h3>

          <div class="field">
            <label for="adImageInput">Gambar Iklan</label>
            @if($isEdit && $ad->image_path)
              <img id="adImagePreview" src="{{ $ad->image_url }}" alt="{{ $ad->title }}" class="ad-image-preview">
            @else
              <img id="adImagePreview" src="" alt="" class="ad-image-preview" style="display:none;">
            @endif
            <input type="file" id="adImageInput" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
            <div class="field-hint">Format JPG/PNG/WEBP/GIF, maksimal 4MB. {{ $isEdit ? 'Kosongkan jika tidak ingin mengganti gambar.' : '' }} Rasio disarankan mengikuti ukuran slot yang dipilih.</div>
            @error('image')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="adTitleInput">Judul / Nama Iklan</label>
            <input type="text" id="adTitleInput" name="title" value="{{ old('title', $ad->title) }}" required maxlength="150" placeholder="mis. Promo Akhir Tahun Bank ABC">
            @error('title')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="form-row">
            <div class="field">
              <label for="adAdvertiser">Nama Pengiklan</label>
              <input type="text" id="adAdvertiser" name="advertiser" value="{{ old('advertiser', $ad->advertiser) }}" maxlength="150" placeholder="mis. Bank ABC">
            </div>
            <div class="field">
              <label for="adCta">Teks Tombol (CTA)</label>
              <input type="text" id="adCta" name="cta_text" value="{{ old('cta_text', $ad->cta_text) }}" maxlength="50" placeholder="Pelajari Selengkapnya">
            </div>
          </div>

          <div class="field">
            <label for="adTargetUrl">Tautan Tujuan</label>
            <input type="url" id="adTargetUrl" name="target_url" value="{{ old('target_url', $ad->target_url) }}" maxlength="255" placeholder="https://pengiklan.com/promo">
            @error('target_url')<div class="field-error">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>

      <div class="sticky-side">
        <div class="form-card">
          <h3>Penempatan</h3>

          <div class="field">
            <label for="adSlot">Slot Iklan</label>
            <select id="adSlot" name="slot" required>
              @foreach($slots as $key => $label)
                <option value="{{ $key }}" @selected(old('slot', $ad->slot) === $key)>{{ $label }}</option>
              @endforeach
            </select>
            @error('slot')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field checkbox-field">
            <input type="checkbox" id="adIsActive" name="is_active" value="1" @checked(old('is_active', $ad->exists ? $ad->is_active : true))>
            <label for="adIsActive" style="margin:0;">Aktifkan iklan ini</label>
          </div>

          <div class="field">
            <label for="adSortOrder">Prioritas Urutan</label>
            <input type="number" id="adSortOrder" name="sort_order" min="0" value="{{ old('sort_order', $ad->sort_order) }}">
            <div class="field-hint">Angka lebih kecil tampil lebih dulu jika ada beberapa iklan aktif di slot yang sama.</div>
          </div>
        </div>

        <div class="form-card">
          <h3>Jadwal Tayang <span style="font-weight:400; font-size:12px; color:var(--muted-2);">(opsional)</span></h3>
          <div class="field">
            <label for="adStartsAt">Mulai Tayang</label>
            <input type="datetime-local" id="adStartsAt" name="starts_at" value="{{ old('starts_at', optional($ad->starts_at)->format('Y-m-d\TH:i')) }}">
          </div>
          <div class="field">
            <label for="adEndsAt">Berakhir</label>
            <input type="datetime-local" id="adEndsAt" name="ends_at" value="{{ old('ends_at', optional($ad->ends_at)->format('Y-m-d\TH:i')) }}">
            @error('ends_at')<div class="field-error">{{ $message }}</div>@enderror
          </div>
          <div class="field-hint">Kosongkan kedua kolom untuk tayang terus-menerus selama status Aktif.</div>
        </div>

        <div class="form-actions">
          <a href="{{ route('admin.ads.index') }}" class="btn btn-ghost">Batal</a>
          <button type="submit" class="btn btn-accent">{{ $isEdit ? 'Simpan Perubahan' : 'Upload Iklan' }}</button>
        </div>
      </div>
    </div>
  </form>

</x-admin-layout>
