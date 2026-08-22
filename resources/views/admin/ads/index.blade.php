<x-admin-layout :page-title="'Iklan / Ads'" :page-subtitle="'Upload dan kelola materi iklan untuk tiap slot di situs'">

  <div class="filter-bar">
    <div style="flex:1; font-size:13px; color:var(--muted);">
      Slot iklan yang tersedia: leaderboard (atas), rectangle (samping), tengah halaman, dan sticky bar mobile.
    </div>
    <a href="{{ route('admin.ads.create') }}" class="btn btn-accent">+ Upload Iklan Baru</a>
  </div>

  @foreach($slots as $slotKey => $slotLabel)
    <div class="slot-group-title">
      <h3>{{ $slotLabel }}</h3>
      <span>{{ isset($adsBySlot[$slotKey]) ? $adsBySlot[$slotKey]->count() : 0 }} iklan</span>
    </div>

    <div class="panel">
      <div class="table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Preview</th>
              <th>Judul</th>
              <th>Pengiklan</th>
              <th>Status</th>
              <th>Jadwal</th>
              <th>Klik</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($adsBySlot[$slotKey] ?? [] as $ad)
              <tr>
                <td style="width:90px;">
                  @if($ad->image_path)
                    <img src="{{ $ad->image_url }}" alt="{{ $ad->title }}" style="width:80px; height:50px; object-fit:cover; border-radius:6px; border:1px solid var(--paper-line);">
                  @else
                    <div style="width:80px; height:50px; border-radius:6px; background:var(--paper-alt); display:flex; align-items:center; justify-content:center; font-size:10px; color:var(--muted-2);">Tanpa gambar</div>
                  @endif
                </td>
                <td class="title-cell">
                  <a href="{{ route('admin.ads.edit', $ad) }}">{{ $ad->title }}</a>
                  @if($ad->target_url)<div class="sub">{{ \Illuminate\Support\Str::limit($ad->target_url, 40) }}</div>@endif
                </td>
                <td>{{ $ad->advertiser ?: '—' }}</td>
                <td>
                  @if($ad->is_active)
                    <span class="badge badge-green">Aktif</span>
                  @else
                    <span class="badge badge-gray">Nonaktif</span>
                  @endif
                </td>
                <td style="font-size:12px; color:var(--muted);">
                  @if($ad->starts_at || $ad->ends_at)
                    {{ optional($ad->starts_at)->translatedFormat('d M Y') ?? 'Kapan saja' }} – {{ optional($ad->ends_at)->translatedFormat('d M Y') ?? 'tanpa batas' }}
                  @else
                    Selalu tayang
                  @endif
                </td>
                <td>{{ number_format($ad->clicks) }}</td>
                <td>
                  <div class="row-actions">
                    <a href="{{ route('admin.ads.edit', $ad) }}" class="btn btn-ghost btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.ads.toggle-active', $ad) }}">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn btn-ghost btn-sm">{{ $ad->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.ads.destroy', $ad) }}" data-confirm="Hapus iklan &quot;{{ $ad->title }}&quot;?">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="7"><div class="empty-state" style="padding:26px 0;">Belum ada iklan di slot ini.</div></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  @endforeach

</x-admin-layout>
