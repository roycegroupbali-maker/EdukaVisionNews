<x-admin-layout :page-title="'Komentar'" :page-subtitle="'Moderasi komentar pembaca di seluruh berita'">

  @if($pendingCount > 0)
    <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
      Ada <strong>{{ $pendingCount }}</strong> komentar menunggu moderasi.
      <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" style="font-weight:600;">Lihat &rarr;</a>
    </div>
  @endif

  <div class="filter-bar">
    <form method="GET" action="{{ route('admin.comments.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; flex:1;">
      <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach(\App\Models\Comment::statuses() as $val => $label)
          <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
        @endforeach
      </select>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / isi komentar…">
      <button type="submit" class="btn btn-ghost btn-sm">Cari</button>
      @if(request()->anyFilled(['status', 'q']))
        <a href="{{ route('admin.comments.index') }}" class="btn btn-ghost btn-sm">Reset</a>
      @endif
    </form>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Berita</th>
            <th>Nama</th>
            <th>Komentar</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($comments as $comment)
            <tr>
              <td style="max-width:220px;">
                @if($comment->article)
                  <a href="{{ route('article.show', $comment->article->slug) }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit($comment->article->title, 45) }}</a>
                @else
                  <span style="color:var(--muted-2);">(berita dihapus)</span>
                @endif
              </td>
              <td>{{ $comment->name }}</td>
              <td style="max-width:340px; white-space:pre-wrap;">{{ \Illuminate\Support\Str::limit($comment->body, 220) }}</td>
              <td style="white-space:nowrap;">{{ $comment->created_at->translatedFormat('d M Y, H:i') }}</td>
              <td><span class="badge {{ $comment->status_badge_class }}">{{ $comment->status_label }}</span></td>
              <td>
                <div class="row-actions">
                  @if($comment->status !== \App\Models\Comment::STATUS_APPROVED)
                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-ghost btn-sm">Setujui</button>
                    </form>
                  @endif
                  @if($comment->status !== \App\Models\Comment::STATUS_HIDDEN)
                    <form method="POST" action="{{ route('admin.comments.hide', $comment) }}">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn btn-ghost btn-sm">Sembunyikan</button>
                    </form>
                  @endif
                  <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" data-confirm="Hapus komentar ini secara permanen?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6"><div class="empty-state"><h3>Belum ada komentar</h3><p>Komentar dari pembaca yang mengisi form di halaman berita akan muncul di sini untuk dimoderasi.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">{{ $comments->links() }}</div>
  </div>

</x-admin-layout>
