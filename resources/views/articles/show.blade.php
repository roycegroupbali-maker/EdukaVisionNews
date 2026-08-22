@include('partials.header', [
    'pageTitle' => $article->title . ' — EdukaVisionNews',
    'pageDescription' => $article->excerpt,
    'ogType' => 'article',
    'ogPublishedTime' => $article->published_at?->toIso8601String(),
    'ogSection' => $article->category->name,
])

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $article->title,
    'description' => $article->excerpt,
    'datePublished' => $article->published_at?->toIso8601String(),
    'dateModified' => $article->updated_at?->toIso8601String(),
    'author' => ['@type' => 'Person', 'name' => $article->author],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'EdukaVisionNews',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')],
    ],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
    'articleSection' => $article->category->name,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

<div class="section-band">
  <div class="wrap">
    @include('partials.ad-slot', ['slot' => 'leaderboard'])
  </div>
</div>

<article class="section-band article-detail">
  <div class="wrap" style="max-width:760px;">

    <nav style="font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:.04em; margin-bottom:18px; color:var(--ink-soft, #667);">
      <a href="{{ route('home') }}">Beranda</a>
      &nbsp;/&nbsp;
      <a href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a>
    </nav>

    <span class="tag {{ $article->category->tag_class }}">{{ $article->subcategory ?? $article->category->name }}</span>
    <h1 class="display" style="font-size:clamp(28px,4vw,44px); line-height:1.15; margin:14px 0 12px;">{{ $article->title }}</h1>
    <p class="feature-dek" style="font-size:18px; margin-bottom:16px;">{{ $article->excerpt }}</p>

    <div class="byline" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:22px;">
      <span>{{ strtoupper($article->author) }}</span>
      <span>·</span>
      <span>{{ $article->readable_date }}</span>
      <span>·</span>
      <span>{{ $article->read_minutes }} MENIT BACA</span>
      <span>·</span>
      <span>{{ number_format($article->views) }} DIBACA</span>
    </div>

    <div class="feature-art" style="aspect-ratio:16/9; margin-bottom:26px; border-radius:10px; overflow:hidden;">
      @include('partials.art', ['article' => $article, 'viewbox' => '0 0 640 400'])
    </div>

    <div class="article-body" style="font-family:'Fraunces', serif; font-size:18px; line-height:1.8; color:var(--ink,#1a1a1a);">
      @foreach($article->paragraphs as $p)
        <p style="margin-bottom:20px;">{{ $p }}</p>
      @endforeach
    </div>

    @if($article->category->slug === 'resep' && ($article->recipe_minutes || $article->recipe_servings))
      <div class="recipe-meta" style="margin-top:10px;">
        <div class="recipe-meta-item"><span class="num">{{ $article->recipe_minutes ?? '-' }}</span><span class="lbl">Menit</span></div>
        <div class="recipe-meta-item"><span class="num">{{ $article->recipe_servings ?? '-' }}</span><span class="lbl">Porsi</span></div>
        <div class="recipe-meta-item"><span class="num">{{ $article->recipe_difficulty ?? '-' }}</span><span class="lbl">Tingkat</span></div>
      </div>
    @endif

    <div style="margin-top:34px;">
      @include('partials.ad-slot', ['slot' => 'midpage'])
    </div>
  </div>
</article>

@if($related->count())
<section class="section-band alt">
  <div class="wrap">
    <div class="section-head">
      <h2 class="section-title"><span class="bar"></span> Artikel Terkait</h2>
    </div>
    <div class="grid-4">
      @foreach($related as $r)
        @include('partials.card', ['article' => $r])
      @endforeach
    </div>
  </div>
</section>
@endif

@include('partials.footer')
