<x-admin-layout :page-title="'Kategori'" :page-subtitle="'Kelola rubrik/kategori tempat berita dikelompokkan'">

  <div class="form-grid">
    <div>
      <div class="panel">
        <div class="panel-head"><h2>Daftar Kategori</h2></div>
        <div class="table-wrap">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Slug</th>
                <th>Jumlah Berita</th>
                <th>Urutan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $cat)
                {{-- Form update & delete didefinisikan terpisah dari <tr>, lalu inputnya
                     dihubungkan lewat atribut form="..." — supaya HTML tabel tetap valid
                     (elemen <form> tidak boleh membungkus <td> langsung di dalam <tr>). --}}
                <form id="cat-update-{{ $cat->id }}" method="POST" action="{{ route('admin.categories.update', $cat) }}"></form>
                <form id="cat-delete-{{ $cat->id }}" method="POST" action="{{ route('admin.categories.destroy', $cat) }}" data-confirm="Hapus kategori &quot;{{ $cat->name }}&quot;?"></form>
                <tr>
                  <td>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="cat-update-{{ $cat->id }}">
                    <input type="hidden" name="_method" value="PUT" form="cat-update-{{ $cat->id }}">
                    <input type="text" name="name" value="{{ $cat->name }}" form="cat-update-{{ $cat->id }}" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:150px;">
                  </td>
                  <td><input type="text" name="slug" value="{{ $cat->slug }}" form="cat-update-{{ $cat->id }}" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:130px;"></td>
                  <td>{{ $cat->articles_count }}</td>
                  <td><input type="number" name="sort_order" value="{{ $cat->sort_order }}" form="cat-update-{{ $cat->id }}" style="border:1px solid var(--paper-line); border-radius:6px; padding:6px 9px; width:64px;"></td>
                  <td>
                    <div class="row-actions">
                      <button type="submit" form="cat-update-{{ $cat->id }}" class="btn btn-ghost btn-sm">Simpan</button>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" form="cat-delete-{{ $cat->id }}">
                      <input type="hidden" name="_method" value="DELETE" form="cat-delete-{{ $cat->id }}">
                      <button type="submit" form="cat-delete-{{ $cat->id }}" class="btn btn-danger btn-sm" @disabled($cat->articles_count > 0) title="{{ $cat->articles_count > 0 ? 'Pindahkan/hapus dulu beritanya' : 'Hapus kategori' }}">Hapus</button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="5"><div class="empty-state"><h3>Belum ada kategori</h3></div></td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="sticky-side">
      <div class="form-card">
        <h3>Tambah Kategori Baru</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}">
          @csrf
          <div class="field">
            <label for="newCatName">Nama Kategori</label>
            <input type="text" id="newCatName" name="name" required maxlength="100" placeholder="mis. Kesehatan">
          </div>
          <div class="field">
            <label for="newCatSlug">Slug <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <input type="text" id="newCatSlug" name="slug" maxlength="100" placeholder="kesehatan">
          </div>
          <div class="field">
            <label for="newCatSort">Urutan Tampil</label>
            <input type="number" id="newCatSort" name="sort_order" min="0" placeholder="11">
          </div>
          <button type="submit" class="btn btn-accent btn-block">+ Tambah Kategori</button>
        </form>
      </div>
    </div>
  </div>

</x-admin-layout>
