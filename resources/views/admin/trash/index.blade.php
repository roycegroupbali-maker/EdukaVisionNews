<x-admin-layout :page-title="'Tempat Sampah Berita'" :page-subtitle="'Cadangan berita yang dihapus — hanya terlihat oleh Super Admin'">

  <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
    Berita di sini <strong>sudah tidak tampil di web</strong> dan tidak terlihat oleh editor/wartawan.
    Pulihkan untuk menayangkannya kembali dengan status semula, atau hapus permanen (tidak bisa dibatalkan).
  </div>

  <div class="filter-bar">
    <form method="GET" action="{{ route('admin.trash.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita terhapus…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      @if(request()->filled('q'))
        <a href="{{ route('admin.trash.index') }}" class="btn btn-ghost btn-sm">Reset</a>
      @endif
    </form>
  </div>

  <div id="bulkBar" style="display:none; align-items:center; gap:12px; flex-wrap:wrap; padding:10px 14px; margin-bottom:12px; border-radius:8px; background:rgba(27,75,67,0.08); border:1px solid rgba(27,75,67,0.25);">
    <span><strong id="bulkCount">0</strong> berita dipilih</span>
    <button type="button" id="bulkRestoreBtn" class="btn btn-accent btn-sm">Pulihkan Terpilih</button>
    <button type="button" id="bulkForceBtn" class="btn btn-danger btn-sm">Hapus Permanen</button>
    <button type="button" id="bulkCancelBtn" class="btn btn-ghost btn-sm">Batal</button>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width:36px;"><input type="checkbox" id="checkAll" title="Pilih semua di halaman ini"></th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status Terakhir</th>
            <th>Dihapus</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($articles as $article)
            <tr>
              <td><input type="checkbox" class="row-check" value="{{ $article->id }}"></td>
              <td class="title-cell">
                {{ $article->title }}
                <div class="sub">oleh {{ $article->authorUser->name ?? $article->author }}</div>
              </td>
              <td>{{ $article->category->name ?? '—' }}</td>
              <td><span class="badge {{ $article->status_badge_class }}">{{ $article->status_label }}</span></td>
              <td>
                {{ $article->deleted_at->translatedFormat('d M Y H:i') }}
                <div class="sub">oleh {{ $article->deletedByUser->name ?? '—' }}</div>
              </td>
              <td>
                <div class="row-actions">
                  <form method="POST" action="{{ route('admin.trash.restore') }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="ids[]" value="{{ $article->id }}">
                    <button type="submit" class="btn btn-accent btn-sm">Pulihkan</button>
                  </form>
                  <form method="POST" action="{{ route('admin.trash.force-delete') }}" data-confirm="Hapus PERMANEN &quot;{{ $article->title }}&quot;? Tidak bisa dipulihkan lagi.">
                    @csrf @method('DELETE')
                    <input type="hidden" name="ids[]" value="{{ $article->id }}">
                    <button type="submit" class="btn btn-danger btn-sm">Hapus Permanen</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6"><div class="empty-state"><h3>Tempat sampah kosong</h3><p>Berita yang dihapus akan muncul di sini.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap">{{ $articles->links() }}</div>

  <form method="POST" id="bulkRestoreForm" action="{{ route('admin.trash.restore') }}" style="display:none;">@csrf @method('PATCH')</form>
  <form method="POST" id="bulkForceForm" action="{{ route('admin.trash.force-delete') }}" style="display:none;">@csrf @method('DELETE')</form>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var checkAll = document.getElementById('checkAll');
      var bar = document.getElementById('bulkBar');
      var countEl = document.getElementById('bulkCount');
      var rows = Array.prototype.slice.call(document.querySelectorAll('.row-check'));

      function selected() { return rows.filter(function (c) { return c.checked; }); }

      function refresh() {
        var n = selected().length;
        countEl.textContent = n;
        bar.style.display = n > 0 ? 'flex' : 'none';
        checkAll.checked = n > 0 && n === rows.length;
        checkAll.indeterminate = n > 0 && n < rows.length;
      }

      function submitWith(formId, confirmMsg) {
        var sel = selected();
        if (!sel.length) return;
        if (confirmMsg && !window.confirm(confirmMsg.replace('{n}', sel.length))) return;
        var form = document.getElementById(formId);
        sel.forEach(function (c) {
          var input = document.createElement('input');
          input.type = 'hidden'; input.name = 'ids[]'; input.value = c.value;
          form.appendChild(input);
        });
        form.submit();
      }

      checkAll.addEventListener('change', function () {
        rows.forEach(function (c) { c.checked = checkAll.checked; });
        refresh();
      });
      rows.forEach(function (c) { c.addEventListener('change', refresh); });

      document.getElementById('bulkCancelBtn').addEventListener('click', function () {
        rows.forEach(function (c) { c.checked = false; });
        refresh();
      });
      document.getElementById('bulkRestoreBtn').addEventListener('click', function () {
        submitWith('bulkRestoreForm', 'Pulihkan {n} berita terpilih?');
      });
      document.getElementById('bulkForceBtn').addEventListener('click', function () {
        submitWith('bulkForceForm', 'Hapus PERMANEN {n} berita terpilih? Tidak bisa dipulihkan lagi.');
      });
    });
  </script>

</x-admin-layout>
