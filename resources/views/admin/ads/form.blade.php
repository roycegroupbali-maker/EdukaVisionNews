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
            <input type="file" id="adImageInput" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
            <div class="field-hint">Format JPG/PNG/WEBP/GIF, maksimal 20MB. {{ $isEdit ? 'Kosongkan jika tidak ingin mengganti gambar.' : '' }}</div>
            @error('image')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          {{-- Editor posisi gambar: bingkai pratinjau memakai rasio slot yang sama dengan halaman publik. --}}
          @php
            $fitVal = old('fit', $ad->fit ?: 'cover');
            $xVal = (int) old('pos_x', $ad->pos_x ?? 50);
            $yVal = (int) old('pos_y', $ad->pos_y ?? 50);
            $zVal = (int) old('zoom', $ad->zoom ?? 100);
          @endphp
          <div class="field">
            <label>Atur Tampilan Gambar</label>
            <div class="ad-editor" id="adEditor" data-ratios='@json(\App\Models\Ad::SLOT_RATIOS)'>
              <div class="ad-editor-frame" id="adEditorFrame" style="--ad-ratio: 970 / 90;">
                <img id="adImagePreview" src="{{ $isEdit && $ad->image_path ? $ad->image_url : '' }}" alt="{{ $ad->title }}" draggable="false" style="{{ $isEdit && $ad->image_path ? '' : 'display:none;' }}">
                <span class="ad-editor-empty" id="adEditorEmpty" @if($isEdit && $ad->image_path) style="display:none;" @endif>Pilih gambar untuk melihat pratinjau</span>
              </div>
              <div class="field-hint">Tarik (drag) gambar di dalam bingkai untuk menggeser posisinya. Bingkai mengikuti ukuran slot yang dipilih.</div>

              <div class="ad-editor-controls">
                <div class="field">
                  <label for="adFit">Cara gambar mengisi bingkai</label>
                  <select id="adFit" name="fit">
                    @foreach(\App\Models\Ad::FITS as $k => $label)
                      <option value="{{ $k }}" @selected($fitVal === $k)>{{ $label }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="field">
                  <label for="adZoom">Zoom: <span id="adZoomVal">{{ $zVal }}</span>%</label>
                  <input type="range" id="adZoom" name="zoom" min="100" max="300" step="5" value="{{ $zVal }}">
                </div>
                <div class="field">
                  <label for="adPosX">Posisi kiri–kanan: <span id="adPosXVal">{{ $xVal }}</span>%</label>
                  <input type="range" id="adPosX" name="pos_x" min="0" max="100" value="{{ $xVal }}">
                </div>
                <div class="field">
                  <label for="adPosY">Posisi atas–bawah: <span id="adPosYVal">{{ $yVal }}</span>%</label>
                  <input type="range" id="adPosY" name="pos_y" min="0" max="100" value="{{ $yVal }}">
                </div>
              </div>
              <button type="button" class="btn btn-ghost" id="adEditorReset">Reset ke tengah</button>
            </div>
            @error('fit')<div class="field-error">{{ $message }}</div>@enderror
            @error('zoom')<div class="field-error">{{ $message }}</div>@enderror
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

  <script>
  (function () {
    var editor = document.getElementById('adEditor');
    if (!editor) return;
    var ratios = JSON.parse(editor.getAttribute('data-ratios'));
    var frame = document.getElementById('adEditorFrame');
    var img = document.getElementById('adImagePreview');
    var empty = document.getElementById('adEditorEmpty');
    var slot = document.getElementById('adSlot');
    var fit = document.getElementById('adFit');
    var zoom = document.getElementById('adZoom');
    var px = document.getElementById('adPosX');
    var py = document.getElementById('adPosY');
    var labels = { zoom: document.getElementById('adZoomVal'), x: document.getElementById('adPosXVal'), y: document.getElementById('adPosYVal') };

    function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }

    function apply() {
      var x = +px.value, y = +py.value, z = +zoom.value / 100;
      img.style.objectFit = fit.value;
      img.style.objectPosition = x + '% ' + y + '%';
      img.style.transformOrigin = x + '% ' + y + '%';
      img.style.transform = 'scale(' + z + ')';
      labels.zoom.textContent = zoom.value;
      labels.x.textContent = x;
      labels.y.textContent = y;
      var has = img.getAttribute('src');
      empty.style.display = has ? 'none' : '';
    }

    function applyRatio() {
      var r = ratios[slot.value] || ratios.leaderboard;
      frame.style.setProperty('--ad-ratio', r.desktop);
    }

    [fit, zoom, px, py].forEach(function (el) { el.addEventListener('input', apply); });
    slot.addEventListener('change', applyRatio);
    document.getElementById('adImageInput').addEventListener('change', function () { setTimeout(apply, 50); });

    document.getElementById('adEditorReset').addEventListener('click', function () {
      px.value = 50; py.value = 50; zoom.value = 100; fit.value = 'cover'; apply();
    });

    // Tarik gambar untuk menggeser titik fokus
    var drag = null;
    frame.addEventListener('pointerdown', function (e) {
      if (!img.getAttribute('src')) return;
      drag = { x: e.clientX, y: e.clientY, px: +px.value, py: +py.value };
      frame.setPointerCapture(e.pointerId);
      frame.classList.add('dragging');
    });
    frame.addEventListener('pointermove', function (e) {
      if (!drag) return;
      var rect = frame.getBoundingClientRect();
      // Tarik ke kanan = bagian kiri gambar terlihat (nilai % turun), seperti menggeser kertas.
      px.value = clamp(Math.round(drag.px - (e.clientX - drag.x) / rect.width * 100), 0, 100);
      py.value = clamp(Math.round(drag.py - (e.clientY - drag.y) / rect.height * 100), 0, 100);
      apply();
    });
    function end() { drag = null; frame.classList.remove('dragging'); }
    frame.addEventListener('pointerup', end);
    frame.addEventListener('pointercancel', end);

    applyRatio();
    apply();
  })();
  </script>

</x-admin-layout>
