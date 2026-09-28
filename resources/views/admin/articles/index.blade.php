@php
    $me = auth()->user();
    $canPublish = $me->hasPermission('articles.publish');
    $canDeleteAny = $me->hasPermission('articles.delete');
    // Berita yang boleh dihapus user ini (sama dengan aturan tombol Hapus per baris).
    $isDeletable = fn ($a) => $canDeleteAny
        || ($a->author_id === $me->id && in_array($a->status, [\App\Models\Article::STATUS_DRAFT, \App\Models\Article::STATUS_REVISION], true));
    $showBulk = $articles->contains(fn ($a) => $isDeletable($a));
@endphp

<x-admin-layout :page-title="'Berita'" :page-subtitle="$canPublish ? 'Kelola semua berita, tinjau pengajuan wartawan' : 'Berita yang Anda tulis & ajukan'">

  @if($canPublish && $pendingCount > 0)
    <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
      Ada <strong>{{ $pendingCount }}</strong> berita menunggu tinjauan Anda.
      <a href="{{ route('admin.articles.index', ['status' => 'pending']) }}" style="font-weight:600;">Lihat &rarr;</a>
    </div>
  @endif

  <div class="filter-bar">
    <form method="GET" action="{{ route('admin.articles.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <select name="category" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        @foreach($categories as $c)
          <option value="{{ $c->slug }}" @selected(request('category') === $c->slug)>{{ $c->name }}</option>
        @endforeach
      </select>
      <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach(\App\Models\Article::statuses() as $val => $label)
          <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
        @endforeach
      </select>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      @if(request()->anyFilled(['category','status','q']))
        <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost btn-sm">Reset</a>
      @endif
    </form>
    @if($me->hasPermission('articles.create'))
      <a href="{{ route('admin.articles.create') }}" class="btn btn-accent">+ Tulis Berita</a>
    @endif
  </div>

  @if($showBulk)
    <div id="bulkBar" style="display:none; align-items:center; gap:12px; flex-wrap:wrap; padding:10px 14px; margin-bottom:12px; border-radius:8px; background:rgba(200,60,60,0.08); border:1px solid rgba(200,60,60,0.25);">
      <span><strong id="bulkCount">0</strong> berita dipilih</span>
      <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">Hapus Terpilih</button>
      <button type="button" id="bulkCancelBtn" class="btn btn-ghost btn-sm">Batal</button>
    </div>
  @endif

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            @if($showBulk)
              <th style="width:36px;"><input type="checkbox" id="checkAll" title="Pilih semua di halaman ini"></th>
            @endif
            <th></th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Views</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($articles as $article)
            <tr>
              @if($showBulk)
                <td style="width:36px;">
                  @if($isDeletable($article))
                    <input type="checkbox" class="row-check" value="{{ $article->id }}">
                  @endif
                </td>
              @endif
              <td style="width:52px;">
                <div style="width:48px; height:36px; border-radius:4px; overflow:hidden; background:var(--paper-alt);">
                  @include('partials.art', ['article' => $article, 'viewbox' => '0 0 48 36'])
                </div>
              </td>
              <td class="title-cell">
                @if($canPublish || $article->author_id === $me->id)
                  <a href="{{ route('admin.articles.edit', $article) }}">{{ $article->title }}</a>
                @else
                  {{ $article->title }}
                @endif
                <div class="sub">
                  oleh {{ $article->authorUser->name ?? $article->author }}
                  @if($article->status === \App\Models\Article::STATUS_REVISION && $article->review_note)
                    · <span style="color:var(--pulse-deep);">Catatan: {{ \Illuminate\Support\Str::limit($article->review_note, 60) }}</span>
                  @endif
                </div>
              </td>
              <td>{{ $article->category->name ?? '—' }}</td>
              <td>
                <span class="badge {{ $article->status_badge_class }}">{{ $article->status_label }}</span>
                @if($article->is_featured)
                  <span class="badge badge-gold">Headline</span>
                @endif
              </td>
              <td>{{ number_format($article->views) }}</td>
              <td>{{ $article->created_at->translatedFormat('d M Y') }}</td>
              <td>
                <div class="row-actions">
                  @if($canPublish && in_array($article->status, [\App\Models\Article::STATUS_PENDING, \App\Models\Article::STATUS_REVISION], true))
                    <form method="POST" action="{{ route('admin.articles.approve', $article) }}">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn btn-accent btn-sm">ACC &amp; Tayangkan</button>
                    </form>
                    <button type="button" class="btn btn-danger btn-sm js-reject-btn" data-action="{{ route('admin.articles.reject', $article) }}">Tolak / Revisi</button>
                  @endif

                  @if($canPublish || $article->author_id === $me->id)
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-ghost btn-sm">Edit</a>
                  @endif

                  @if($canPublish)
                    <form method="POST" action="{{ route('admin.articles.toggle-featured', $article) }}">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn btn-ghost btn-sm">{{ $article->is_featured ? 'Lepas Headline' : 'Jadikan Headline' }}</button>
                    </form>
                  @endif

                  @if($me->hasPermission('articles.delete') || ($article->author_id === $me->id && in_array($article->status, [\App\Models\Article::STATUS_DRAFT, \App\Models\Article::STATUS_REVISION], true)))
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" data-confirm="Hapus berita &quot;{{ $article->title }}&quot;? Tindakan ini tidak bisa dibatalkan.">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="{{ $showBulk ? 8 : 7 }}"><div class="empty-state"><h3>Belum ada berita</h3><p>Mulai tulis berita pertama sesuai kategori yang diinginkan.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap">{{ $articles->links() }}</div>

  <!-- Form tersembunyi untuk aksi "Tolak / Revisi" — catatan diminta lewat prompt() lalu dikirim ke sini -->
  <form method="POST" id="rejectForm" style="display:none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="review_note" id="rejectNoteInput">
  </form>

  @if($showBulk)
    <!-- Form tersembunyi untuk hapus massal — id berita yang dicentang diisi lewat JS -->
    <form method="POST" action="{{ route('admin.articles.bulk-destroy') }}" id="bulkDeleteForm" style="display:none;">
      @csrf
      @method('DELETE')
    </form>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // ----- Hapus massal (centang) -----
      var bulkForm = document.getElementById('bulkDeleteForm');
      if (bulkForm) {
        var checkAll = document.getElementById('checkAll');
        var bar = document.getElementById('bulkBar');
        var countEl = document.getElementById('bulkCount');
        var rows = Array.prototype.slice.call(document.querySelectorAll('.row-check'));

        function refresh() {
          var n = rows.filter(function (c) { return c.checked; }).length;
          countEl.textContent = n;
          bar.style.display = n > 0 ? 'flex' : 'none';
          checkAll.checked = n > 0 && n === rows.length;
          checkAll.indeterminate = n > 0 && n < rows.length;
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

        document.getElementById('bulkDeleteBtn').addEventListener('click', function () {
          var selected = rows.filter(function (c) { return c.checked; });
          if (!selected.length) return;
          if (!window.confirm('Hapus ' + selected.length + ' berita terpilih? Tindakan ini tidak bisa dibatalkan.')) return;
          selected.forEach(function (c) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = c.value;
            bulkForm.appendChild(input);
          });
          bulkForm.submit();
        });
      }

      document.querySelectorAll('.js-reject-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var note = window.prompt('Catatan revisi untuk wartawan (wajib diisi, jelaskan apa yang perlu diperbaiki):');
          if (note === null) return; // dibatalkan
          note = note.trim();
          if (!note) {
            window.alert('Catatan revisi wajib diisi.');
            return;
          }
          var form = document.getElementById('rejectForm');
          form.action = btn.getAttribute('data-action');
          document.getElementById('rejectNoteInput').value = note;
          form.submit();
        });
      });
    });
  </script>

</x-admin-layout>
