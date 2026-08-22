{{--
    Usage: @include('partials.card', ['article' => $a, 'variant' => 'default'])
    variant: default | big | stacked | side
--}}
@php $variant = $variant ?? 'default'; @endphp

@if($variant === 'side')
  <a href="{{ route('article.show', $article->slug) }}" class="side-item">
    <div class="side-thumb">@include('partials.art', ['article' => $article, 'viewbox' => '0 0 100 100'])</div>
    <div>
      <span class="tag {{ $article->category->tag_class }}">{{ $article->subcategory ?? $article->category->name }}</span>
      <p class="side-title">{{ $article->title }}</p>
      <span class="side-meta">{{ $article->read_minutes }} MENIT BACA</span>
    </div>
  </a>

@elseif($variant === 'stacked')
  <a href="{{ route('article.show', $article->slug) }}" class="stacked-card">
    <div class="stacked-thumb">@include('partials.art', ['article' => $article, 'viewbox' => '0 0 110 80'])</div>
    <div>
      <span class="tag {{ $article->category->tag_class }}">{{ $article->subcategory ?? $article->category->name }}</span>
      <p class="card-title" style="font-size:15.5px; margin:6px 0 4px;">{{ $article->title }}</p>
      <span class="byline">{{ $article->read_minutes }} MENIT BACA</span>
    </div>
  </a>

@elseif($variant === 'big')
  <a href="{{ route('article.show', $article->slug) }}" class="card big-card">
    <div class="card-art">@include('partials.art', ['article' => $article, 'viewbox' => '0 0 300 232'])</div>
    <span class="tag {{ $article->category->tag_class }}">{{ $article->subcategory ?? $article->category->name }}</span>
    <h3 class="card-title">{{ $article->title }}</h3>
    <p class="card-dek">{{ $article->excerpt }}</p>
    <span class="byline">{{ $article->read_minutes }} MENIT BACA</span>
  </a>

@else
  <a href="{{ route('article.show', $article->slug) }}" class="card {{ $class ?? '' }}">
    <div class="card-art">@include('partials.art', ['article' => $article])</div>
    <span class="tag {{ $article->category->tag_class }}">{{ $article->subcategory ?? $article->category->name }}</span>
    <h3 class="card-title">{{ $article->title }}</h3>
    <p class="card-dek">{{ $article->excerpt }}</p>
    <span class="byline">{{ $article->read_minutes }} MENIT BACA</span>
  </a>
@endif
