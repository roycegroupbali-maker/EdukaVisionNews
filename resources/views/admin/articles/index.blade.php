@php
    $me = auth()->user();
    $canPublish = $me->hasPermission('articles.publish');
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

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
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
            <tr><td colspan="7"><div class="empty-state"><h3>Belum ada berita</h3><p>Mulai tulis berita pertama sesuai kategori yang diinginkan.</p></div></td></tr>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
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
