@include('partials.header', [
    'pageTitle' => ($query !== '' ? 'Hasil Pencarian: ' . $query . ' — EdukaVisionNews' : 'Cari Berita — EdukaVisionNews'),
    'pageDescription' => 'Cari berita, resep, dan artikel di EdukaVisionNews.',
    'robots' => 'noindex, follow',
    'query' => $query,
])

<section class="section-band">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Hasil Pencarian @if($query)"{{ $query }}"@endif</h2>
    </div>

    <p style="font-family:'IBM Plex Mono',monospace; font-size:13px; opacity:.7; margin-bottom:20px;">
      {{ $articles->total() }} artikel ditemukan
    </p>

    @if($articles->isEmpty())
      <p style="font-family:'IBM Plex Mono',monospace; opacity:.7;">Tidak ada artikel yang cocok dengan kata kunci tersebut. Coba kata kunci lain.</p>
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
