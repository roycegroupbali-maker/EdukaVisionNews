@php $variant = $variant ?? 'small'; @endphp

@if($variant === 'feature')
  <a href="{{ route('article.show', $article->slug) }}" class="recipe-feature">
    <div class="recipe-feature-art">@include('partials.art', ['article' => $article, 'viewbox' => '0 0 500 400'])</div>
    <div class="recipe-feature-body">
      <span class="tag resep">{{ $article->subcategory ?? 'Resep Pilihan Hari Ini' }}</span>
      <h3 class="display">{{ $article->title }}</h3>
      <p>{{ $article->excerpt }}</p>
      <div class="recipe-meta">
        <div class="recipe-meta-item"><span class="num">{{ $article->recipe_minutes ?? 30 }}</span><span class="lbl">Menit</span></div>
        <div class="recipe-meta-item"><span class="num">{{ $article->recipe_servings ?? 4 }}</span><span class="lbl">Porsi</span></div>
        <div class="recipe-meta-item"><span class="num">{{ $article->recipe_difficulty ?? 'Mudah' }}</span><span class="lbl">Tingkat</span></div>
      </div>
    </div>
  </a>
@else
  <a href="{{ route('article.show', $article->slug) }}" class="recipe-card">
    <div class="recipe-card-art">@include('partials.art', ['article' => $article])</div>
    <div class="recipe-card-body">
      <span class="tag resep">{{ $article->subcategory ?? 'Resep' }}</span>
      <h3 class="card-title">{{ $article->title }}</h3>
      <p class="card-dek">{{ $article->excerpt }}</p>
      <div class="recipe-time"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg> {{ $article->recipe_minutes ?? 30 }} menit · {{ $article->recipe_servings ?? 4 }} porsi</div>
    </div>
  </a>
@endif
