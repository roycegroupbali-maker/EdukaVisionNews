<x-admin-layout :page-title="'Akun Admin'" :page-subtitle="'Konfirmasi pendaftaran akun baru, atur jabatan, lalu aktifkan atau nonaktifkan akun kapan saja'">

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Jabatan</th>
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
              <td>
                @if(auth()->user()->isSuperAdmin())
                  <a href="{{ route('admin.users.access', $account) }}">{{ $account->email }}</a>
                @else
                  {{ $account->email }}
                @endif
                @if($account->hasCustomAccess())
                  <div class="sub" style="color:var(--gold-deep);">Akses khusus</div>
                @endif
              </td>
              <td>
                @if($account->id === auth()->id() && ! auth()->user()->isSuperAdmin())
                  <span class="badge badge-gray">{{ $account->role_name }}</span>
                @else
                  <form method="POST" action="{{ route('admin.users.update-role', $account) }}" style="display:inline-block;">
                    @csrf @method('PATCH')
                    <select name="role_id" onchange="this.form.submit()" style="min-width:160px;">
                      <option value="">— Tanpa jabatan —</option>
                      @foreach($roles as $role)
                        <option value="{{ $role->id }}" @selected($account->role_id === $role->id)>{{ $role->name }}</option>
                      @endforeach
                    </select>
                  </form>
                @endif
              </td>
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
                        ? 'Nonaktifkan akun \"'.$account->name.'\"? Akun ini akan langsung kehilangan akses ke panel admin.'
                        : 'Aktifkan akun \"'.$account->name.'\"? Akun ini akan bisa masuk ke panel admin.' }}">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn {{ $account->is_active ? 'btn-ghost' : 'btn-accent' }} btn-sm">
                        {{ $account->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                      </button>
                    </form>

                    @if(! $account->is_active && ! $account->isSuperAdmin())
                      <form method="POST" action="{{ route('admin.users.destroy', $account) }}"
                        data-confirm="Hapus permanen akun &quot;{{ $account->name }}&quot; ({{ $account->email }})? Tindakan ini tidak bisa dibatalkan.">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    @endif
                  </div>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="6"><div class="empty-state">Belum ada akun.</div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <p style="font-size:12.5px; color:var(--muted-2); margin-top:14px;">
    Jabatan menentukan hak akses tiap akun di panel — kelola daftar jabatan &amp; hak aksesnya di menu <a href="{{ route('admin.roles.index') }}">Jabatan</a>.
  </p>

</x-admin-layout>
