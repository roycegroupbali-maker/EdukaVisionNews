<x-admin-layout :page-title="'Running Text'" :page-subtitle="'Kelola teks berjalan (ticker \'TERKINI\') yang tampil di header situs'">

  <div class="form-grid">
    <div>
      <div class="panel">
        <div class="panel-head"><h2>Daftar Running Text</h2></div>
        <div class="table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Teks</th>
                <th>Tautan (URL)</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($runningTexts as $rt)
                {{-- Form update & delete didefinisikan terpisah dari <tr>, lalu inputnya
                     dihubungkan lewat atribut form="..." — supaya HTML tabel tetap valid. --}}
                <form id="rt-update-{{ $rt->id }}" method="POST" action="{{ route('admin.running-texts.update', $rt) }}"></form>
                <form id="rt-delete-{{ $rt->id }}" method="POST" action="{{ route('admin.running-texts.destroy', $rt) }}" data-confirm="Hapus running text ini?"></form>
                <tr>
                  <td>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="rt-update-{{ $rt->id }}">
                    <input type="hidden" name="_method" value="PUT" form="rt-update-{{ $rt->id }}">
                    <input type="text" name="text" value="{{ $rt->text }}" required maxlength="255" form="rt-update-{{ $rt->id }}" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:320px;">
                  </td>
                  <td><input type="url" name="url" value="{{ $rt->url }}" placeholder="https://…" form="rt-update-{{ $rt->id }}" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:180px;"></td>
                  <td><input type="number" name="sort_order" value="{{ $rt->sort_order }}" min="0" form="rt-update-{{ $rt->id }}" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:64px;"></td>
                  <td>
                    <label style="display:flex; align-items:center; gap:6px; font-size:13px;">
                      <input type="checkbox" name="is_active" value="1" @checked($rt->is_active) form="rt-update-{{ $rt->id }}">
                      {{ $rt->is_active ? 'Aktif' : 'Nonaktif' }}
                    </label>
                  </td>
                  <td>
                    <div class="row-actions">
                      <button type="submit" form="rt-update-{{ $rt->id }}" class="btn btn-ghost btn-sm">Simpan</button>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" form="rt-delete-{{ $rt->id }}">
                      <input type="hidden" name="_method" value="DELETE" form="rt-delete-{{ $rt->id }}">
                      <button type="submit" form="rt-delete-{{ $rt->id }}" class="btn btn-danger btn-sm">Hapus</button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5"><div class="empty-state"><h3>Belum ada running text</h3><p>Tambahkan lewat form di samping. Selama belum ada yang aktif, ticker akan otomatis memakai 5 berita terbaru seperti biasa.</p></div></td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="sticky-side">
      <div class="form-card">
        <h3>Tambah Running Text Baru</h3>
        <form method="POST" action="{{ route('admin.running-texts.store') }}">
          @csrf
          <div class="field">
            <label for="newRtText">Teks</label>
            <textarea id="newRtText" name="text" required maxlength="255" rows="3" placeholder="mis. Pendaftaran PPDB 2026/2027 resmi dibuka mulai hari ini"></textarea>
          </div>
          <div class="field">
            <label for="newRtUrl">Tautan <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <input type="url" id="newRtUrl" name="url" maxlength="255" placeholder="https://…">
          </div>
          <div class="field">
            <label for="newRtSort">Urutan Tampil</label>
            <input type="number" id="newRtSort" name="sort_order" min="0" placeholder="0">
          </div>
          <div class="field" style="display:flex; align-items:center; gap:8px; flex-direction:row;">
            <input type="checkbox" id="newRtActive" name="is_active" value="1" checked style="width:auto;">
            <label for="newRtActive" style="margin:0;">Aktifkan langsung</label>
          </div>
          <button type="submit" class="btn btn-accent btn-block">+ Tambah Running Text</button>
        </form>
        <p style="font-size:12.5px; color:var(--muted-2); margin-top:14px; line-height:1.5;">
          Kalau minimal ada satu Running Text yang <strong>Aktif</strong>, ticker "TERKINI" di header situs akan menampilkan daftar ini sesuai urutan, menggantikan daftar berita terbaru otomatis.
        </p>
      </div>
    </div>
  </div>

</x-admin-layout>
