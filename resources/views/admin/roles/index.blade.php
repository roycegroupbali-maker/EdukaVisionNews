<x-admin-layout :page-title="'Jabatan'" :page-subtitle="'Atur jabatan panel & tentukan sampai mana hak akses tiap jabatan'">

  <div class="filter-bar">
    <div style="flex:1;"></div>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-accent">+ Tambah Jabatan</a>
  </div>

  <div class="panel">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Jabatan</th>
            <th>Deskripsi</th>
            <th>Hak Akses</th>
            <th>Pengguna</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($roles as $role)
            <tr>
              <td class="title-cell">
                {{ $role->name }}
                @if($role->is_system)
                  <div class="sub">Jabatan bawaan sistem</div>
                @endif
              </td>
              <td style="max-width:280px; font-size:13px; color:var(--muted);">{{ $role->description ?: '—' }}</td>
              <td style="font-size:12.5px; color:var(--muted);">
                @if($role->slug === \App\Models\Role::SUPER_ADMIN)
                  Semua akses (penuh)
                @elseif(empty($role->permissions))
                  <span style="color:var(--muted-2);">Belum ada akses</span>
                @else
                  {{ count($role->permissions) }} dari {{ count(\App\Models\Role::permissionCatalog()) }} hak akses
                @endif
              </td>
              <td>{{ $role->users_count }} orang</td>
              <td>
                <div class="row-actions">
                  <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-ghost btn-sm">
                    {{ $role->slug === \App\Models\Role::SUPER_ADMIN ? 'Lihat' : 'Edit' }}
                  </a>
                  @unless($role->is_system)
                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" data-confirm="Hapus jabatan &quot;{{ $role->name }}&quot;? Tindakan ini tidak bisa dibatalkan.">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  @endunless
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="5"><div class="empty-state"><h3>Belum ada jabatan</h3><p>Tambahkan jabatan custom sesuai struktur redaksi Anda.</p></div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</x-admin-layout>
