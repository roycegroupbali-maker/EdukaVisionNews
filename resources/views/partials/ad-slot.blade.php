{{--
    Partial unit iklan dinamis.
    Usage: @include('partials.ad-slot', ['slot' => 'leaderboard', 'type' => 'leaderboard'])
    - slot: kunci di tabel ads (leaderboard|rectangle|midpage|mobile_bar)
    - type: variasi tampilan (leaderboard|rectangle|midpage) — biasanya sama dengan slot
    Variabel $ads (array slot => Ad|null) disuntik lewat View Composer di AppServiceProvider.

    Gambar iklan selalu ditempatkan di dalam bingkai ber-rasio tetap (lihat Ad::SLOT_RATIOS).
    Cara gambar mengisi bingkai (fit), titik fokus (pos_x/pos_y) dan zoom diatur
    per iklan dari panel admin lewat Ad::image_style.
--}}
@php
    $__ad = ($ads[$slot] ?? null);
    $__type = $type ?? $slot;
    $__ratio = \App\Models\Ad::SLOT_RATIOS[$__type] ?? \App\Models\Ad::SLOT_RATIOS['leaderboard'];
    $__frame = "--ad-ratio:{$__ratio['desktop']}; --ad-ratio-m:{$__ratio['mobile']};";
    $__hasImage = $__ad && $__ad->image_url;
@endphp

@if($__type === 'leaderboard')
  <div class="ad-leaderboard {{ $__hasImage ? 'has-image' : '' }}">
    <span class="ad-eyebrow">Iklan</span>
    @if($__hasImage)
      <a href="{{ route('ads.click', $__ad) }}" target="_blank" rel="noopener sponsored" class="ad-frame" style="{{ $__frame }}">
        <img src="{{ $__ad->image_url }}" alt="{{ $__ad->title }}" style="{{ $__ad->image_style }}">
      </a>
    @else
      <span class="ad-creative">Ruang Iklan Leaderboard · 970 × 90</span>
      <span class="ad-note">Slot iklan header — tayang di semua halaman utama</span>
    @endif
  </div>
@elseif($__type === 'rectangle')
  <div class="ad-rect {{ $__hasImage ? 'has-image' : '' }}">
    <span class="ad-eyebrow">Iklan</span>
    @if($__hasImage)
      <a href="{{ route('ads.click', $__ad) }}" target="_blank" rel="noopener sponsored" class="ad-frame" style="{{ $__frame }}">
        <img src="{{ $__ad->image_url }}" alt="{{ $__ad->title }}" style="{{ $__ad->image_style }}">
      </a>
      <a href="{{ route('ads.click', $__ad) }}" target="_blank" rel="noopener sponsored" class="ad-cta" style="align-self:center;">{{ $__ad->cta_text ?: 'Pelajari Selengkapnya' }}</a>
    @else
      <span class="ad-creative">Ruang Iklan Rectangle · 300 × 600</span>
      <span class="ad-note">Menyesuaikan tinggi widget di sebelahnya</span>
      <span class="ad-cta">Pelajari Selengkapnya</span>
    @endif
  </div>
@elseif($__type === 'midpage')
  <div class="ad-midpage {{ $__hasImage ? 'has-image' : '' }}">
    <span class="ad-eyebrow">Iklan</span>
    @if($__hasImage)
      <a href="{{ route('ads.click', $__ad) }}" target="_blank" rel="noopener sponsored" class="ad-frame" style="{{ $__frame }}">
        <img src="{{ $__ad->image_url }}" alt="{{ $__ad->title }}" style="{{ $__ad->image_style }}">
      </a>
    @else
      <span class="ad-creative">Ruang Iklan Tengah Halaman · 728 × 250</span>
    @endif
  </div>
@endif
