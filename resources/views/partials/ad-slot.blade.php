{{--
    Partial unit iklan dinamis.
    Usage: @include('partials.ad-slot', ['slot' => 'leaderboard', 'type' => 'leaderboard'])
    - slot: kunci di tabel ads (leaderboard|rectangle|midpage|mobile_bar)
    - type: variasi tampilan (leaderboard|rectangle|midpage) — biasanya sama dengan slot
    Variabel $ads (array slot => Ad|null) disuntik lewat View Composer di AppServiceProvider.
--}}
@php
    $__ad = ($ads[$slot] ?? null);
    $__type = $type ?? $slot;
@endphp

@if($__type === 'leaderboard')
  <div class="ad-leaderboard">
    <span class="ad-eyebrow">Iklan</span>
    @if($__ad)
      <a href="{{ route('ads.click', $__ad) }}" target="_blank" rel="noopener sponsored" style="display:block; width:100%; max-width:640px;">
        <img src="{{ $__ad->image_url }}" alt="{{ $__ad->title }}" style="width:100%; border-radius:4px;">
      </a>
    @else
      <span class="ad-creative">Ruang Iklan Leaderboard · 970 × 90</span>
      <span class="ad-note">Slot iklan header — tayang di semua halaman utama</span>
    @endif
  </div>
@elseif($__type === 'rectangle')
  <div class="ad-rect">
    <span class="ad-eyebrow">Iklan</span>
    @if($__ad)
      <img src="{{ $__ad->image_url }}" alt="{{ $__ad->title }}" style="width:100%; border-radius:6px; margin-top:4px;">
      <span class="ad-creative">{{ $__ad->title }}</span>
      <a href="{{ route('ads.click', $__ad) }}" target="_blank" rel="noopener sponsored" class="ad-cta">{{ $__ad->cta_text ?: 'Pelajari Selengkapnya' }}</a>
    @else
      <span class="ad-creative">Ruang Iklan Rectangle · 300 × 600</span>
      <span class="ad-note">Menyesuaikan tinggi widget di sebelahnya</span>
      <span class="ad-cta">Pelajari Selengkapnya</span>
    @endif
  </div>
@elseif($__type === 'midpage')
  <div class="ad-midpage">
    <span class="ad-eyebrow">Iklan</span>
    @if($__ad)
      <a href="{{ route('ads.click', $__ad) }}" target="_blank" rel="noopener sponsored" style="display:block; width:100%; max-width:520px;">
        <img src="{{ $__ad->image_url }}" alt="{{ $__ad->title }}" style="width:100%; border-radius:4px;">
      </a>
    @else
      <span class="ad-creative">Ruang Iklan Tengah Halaman · 728 × 250</span>
    @endif
  </div>
@endif
