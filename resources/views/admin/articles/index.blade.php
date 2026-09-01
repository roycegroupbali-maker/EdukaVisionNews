<x-admin-layout :page-title="'Berita'" :page-subtitle="'Kelola semua berita, filter berdasarkan kategori'">

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
        <option value="published" @selected(request('status') === 'published')>Tayang</option>
        <option value="draft" @selected(request('status') === 'draft')>Draf</option>
      </select>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      @if(request()->anyFilled(['category','status','q']))
        <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost btn-sm">Reset</a>
      @endif
    </form>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-accent">+ Tulis Berita</a>
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
            <th>Share</th>
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
                <a href="{{ route('admin.articles.edit', $article) }}">{{ $article->title }}</a>
                <div class="sub">oleh {{ $article->author }}</div>
              </td>
              <td>{{ $article->category->name ?? '—' }}</td>
              <td>
                @if($article->published_at && $article->published_at->lte(now()))
                  <span class="badge badge-green">Tayang</span>
                @else
                  <span class="badge badge-gray">Draf</span>
                @endif
                @if($article->is_featured)
                  <span class="badge badge-gold">Headline</span>
                @endif
              </td>
              <td>{{ number_format($article->views) }}</td>
              <td>{{ number_format($article->shares) }}</td>
              <td>{{ $article->created_at->translatedFormat('d M Y') }}</td>
              <td>
                <div class="row-actions">
                  <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-ghost btn-sm">Edit</a>
                  <form method="POST" action="{{ route('admin.articles.toggle-featured', $article) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-ghost btn-sm">{{ $article->is_featured ? 'Lepas Headline' : 'Jadikan Headline' }}</button>
                  </form>
                  <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" data-confirm="Hapus berita &quot;{{ $article->title }}&quot;? Tindakan ini tidak bisa dibatalkan.">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="8"><div class="empty-state"><h3>Belum ada berita</h3><p>Mulai tulis berita pertama sesuai kategori yang diinginkan.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="pagination-wrap">{{ $articles->links() }}</div>

</x-admin-layout>
