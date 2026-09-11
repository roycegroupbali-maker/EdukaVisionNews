<x-admin-layout :page-title="'Akun Admin'" :page-subtitle="'Konfirmasi pendaftaran akun admin baru, lalu aktifkan atau nonaktifkan akun kapan saja'">

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Terdaftar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($accounts as $account)
            <tr>
              <td class="title-cell">
                {{ $account->name }}
                @if($account->id === auth()->id())
                  <div class="sub">Ini akun Anda</div>
                @endif
              </td>
              <td>{{ $account->email }}</td>
              <td>
                @if($account->is_active)
                  <span class="badge badge-green">Aktif</span>
                @else
                  <span class="badge badge-gold">Menunggu Aktivasi</span>
                @endif
              </td>
              <td style="font-size:12px; color:var(--muted);">{{ $account->created_at->translatedFormat('d M Y, H:i') }}</td>
              <td>
                @if($account->id === auth()->id())
                  <span style="font-size:12px; color:var(--muted-2);">—</span>
                @else
                  <div class="row-actions">
                    <form method="POST" action="{{ route('admin.users.toggle-active', $account) }}"
                      data-confirm="{{ $account->is_active
                        ? 'Nonaktifkan akun admin "'.$account->name.'"? Akun ini akan langsung kehilangan akses ke panel admin.'
                        : 'Aktifkan akun admin "'.$account->name.'"? Akun ini akan bisa masuk ke panel admin.' }}">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn {{ $account->is_active ? 'btn-ghost' : 'btn-accent' }} btn-sm">
                        {{ $account->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                      </button>
                    </form>
                  </div>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="5"><div class="empty-state">Belum ada akun admin.</div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</x-admin-layout>