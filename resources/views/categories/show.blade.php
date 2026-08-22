@include('partials.header', [
    'pageTitle' => $category->name . ' — EdukaVisionNews',
    'pageDescription' => 'Kumpulan berita terbaru kategori ' . $category->name . ' dari EdukaVisionNews.',
])

<div class="section-band">
  <div class="wrap">
    @include('partials.ad-slot', ['slot' => 'leaderboard'])
  </div>
</div>

<section class="section-band">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar" style="background:{{ $category->bar_color }};"></span> {{ $category->name }}</h2>
    </div>

    @if($articles->isEmpty())
      <p style="font-family:'IBM Plex Mono',monospace; opacity:.7;">Belum ada artikel di kategori ini.</p>
    @else
      <div class="grid-4">
        @foreach($articles as $a)
          @include('partials.card', ['article' => $a])
        @endforeach
      </div>

      <div class="load-more-row">
        {{ $articles->links() }}
      </div>
    @endif
  </div>
</section>

@include('partials.footer')
