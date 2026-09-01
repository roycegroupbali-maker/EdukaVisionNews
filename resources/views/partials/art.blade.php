{{--
    Generates the same style of abstract SVG "photo" placeholder the original
    static design used, but driven by the article's art_color1 / art_color2 /
    art_pattern fields instead of being hand-written per card.

    Usage: @include('partials.art', ['article' => $article])
    Optional: 'viewbox' => '0 0 300 225' (default)
--}}
@php
    $vb = $viewbox ?? '0 0 300 225';
    [$vx, $vy, $vw, $vh] = array_map('intval', explode(' ', $vb));
    $c1 = $article->art_color1;
    $c2 = $article->art_color2;
    $pattern = $article->art_pattern;
@endphp
@if($article->image_url)
  <img
    src="{{ $article->image_url }}"
    alt="{{ $article->image_alt ?: $article->title }}"
    loading="lazy"
    style="width:100%; height:100%; object-fit:cover; display:block;"
  >
@else
<svg viewBox="{{ $vb }}" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
  <rect width="{{ $vw }}" height="{{ $vh }}" fill="{{ $c1 }}"/>
  @switch($pattern)
    @case('circles')
      <circle cx="{{ $vw * 0.7 }}" cy="{{ $vh * 0.35 }}" r="{{ $vh * 0.3 }}" fill="{{ $c2 }}" opacity="0.5"/>
      <circle cx="{{ $vw * 0.7 }}" cy="{{ $vh * 0.35 }}" r="{{ $vh * 0.15 }}" fill="{{ $c2 }}" opacity="0.4"/>
      @break
    @case('triangle')
      <path d="M{{ $vw * 0.2 }} {{ $vh * 0.8 }} L{{ $vw * 0.5 }} {{ $vh * 0.25 }} L{{ $vw * 0.8 }} {{ $vh * 0.8 }} Z" fill="{{ $c2 }}" opacity="0.35"/>
      @break
    @case('grid')
      <rect x="{{ $vw * 0.23 }}" y="{{ $vh * 0.3 }}" width="{{ $vw * 0.54 }}" height="{{ $vh * 0.42 }}" rx="6" fill="none" stroke="{{ $c2 }}" stroke-width="1.5" opacity="0.4"/>
      @break
    @case('dots')
      <circle cx="{{ $vw * 0.35 }}" cy="{{ $vh * 0.5 }}" r="4" fill="{{ $c2 }}" opacity="0.6"/>
      <circle cx="{{ $vw * 0.5 }}" cy="{{ $vh * 0.4 }}" r="4" fill="{{ $c2 }}" opacity="0.6"/>
      <circle cx="{{ $vw * 0.65 }}" cy="{{ $vh * 0.55 }}" r="4" fill="{{ $c2 }}" opacity="0.6"/>
      <path d="M{{ $vw * 0.35 }} {{ $vh * 0.5 }} L{{ $vw * 0.5 }} {{ $vh * 0.4 }} L{{ $vw * 0.65 }} {{ $vh * 0.55 }}" stroke="{{ $c2 }}" stroke-width="1" opacity="0.3"/>
      @break
    @case('arrow')
      <path d="M{{ $vw * 0.13 }} {{ $vh * 0.8 }} L{{ $vw * 0.33 }} {{ $vh * 0.53 }} L{{ $vw * 0.5 }} {{ $vh * 0.66 }} L{{ $vw * 0.8 }} {{ $vh * 0.35 }}" stroke="{{ $c2 }}" stroke-width="2" fill="none" opacity="0.6"/>
      @break
    @default
      <path d="M0 {{ $vh * 0.75 }} L{{ $vw * 0.2 }} {{ $vh * 0.53 }} L{{ $vw * 0.37 }} {{ $vh * 0.67 }} L{{ $vw * 0.6 }} {{ $vh * 0.35 }} L{{ $vw }} {{ $vh * 0.58 }}" stroke="{{ $c2 }}" stroke-width="2" fill="none" opacity="0.55"/>
  @endswitch
</svg>
@endif
