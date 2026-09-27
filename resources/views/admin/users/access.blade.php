@php
    $recommended = $account->role?->permissions ?? [];
    $effective = old('permissions', $account->hasCustomAccess() ? $account->permissions_override : $recommended);

    $groups = [
        'Berita & Alur Verifikasi' => ['articles.create', 'articles.view_all', 'articles.publish', 'articles.delete'],
        'Konten Situs' => ['categories.manage', 'running_texts.manage', 'news_submissions.manage', 'ads.manage'],
        'Analitik' => ['stats.view'],
        'Panel Admin' => ['users.manage', 'roles.manage'],
    ];
@endphp

<x-admin-layout :page-title="'Akses Khusus: '.$account->name" :page-subtitle="$account->email">

  <div class="admin-flash" style="background:rgba(178,137,35,0.12); color:var(--gold-deep); border-color:rgba(178,137,35,0.3);">
    <strong>Rekomendasi:</strong> atur akses lewat menu <a href="{{ route('admin.roles.index') }}">Jabatan</a> supaya konsisten untuk semua orang dengan jabatan yang sama. Gunakan halaman ini <strong>hanya untuk pengecualian</strong> — mis. satu wartawan senior yang boleh langsung publish tanpa membuatkan jabatan baru.
  </div>

  @if($account->hasCustomAccess())
    <div class="admin-flash error">
      Akun ini sedang memakai <strong>akses khusus</strong> (bukan default jabatan "{{ $account->role_name }}").
      <form method="POST" action="{{ route('admin.users.update-access', $account) }}" style="display:inline;">
        @csrf @method('PATCH')
        <input type="hidden" name="reset" value="1">
        <button type="submit" class="btn btn-ghost btn-sm" style="margin-left:8px;">Kembalikan ke default jabatan</button>
      </form>
    </div>
  @else
    <div class="admin-flash" style="background:rgba(27,75,67,0.10); color:var(--teal); border-color:rgba(27,75,67,0.25);">
      Akun ini masih memakai default jabatan <strong>"{{ $account->role_name }}"</strong>. Centang/hilangkan salah satu di bawah untuk membuat akses khusus hanya untuk akun ini.
    </div>
  @endif

  <form method="POST" action="{{ route('admin.users.update-access', $account) }}">
    @csrf
    @method('PATCH')

    <div class="form-card">
      <h3>Hak Akses "{{ $account->name }}"</h3>
      <p style="font-size:12.5px; color:var(--muted-2); margin-top:-6px; margin-bottom:16px;">
        Jabatan saat ini: <strong>{{ $account->role_name }}</strong> — kotak yang bertanda <span class="badge badge-gold" style="font-size:10px;">Rekomendasi</span> adalah default jabatannya.
      </p>

      @foreach($groups as $groupLabel => $keys)
        <div style="margin-bottom:18px;">
          <div style="font-weight:600; font-size:13px; color:var(--ink-2); margin-bottom:8px;">{{ $groupLabel }}</div>
          <div style="display:flex; flex-direction:column; gap:8px;">
            @foreach($keys as $key)
              <label class="field checkbox-field" style="align-items:flex-start; margin:0;">
                <input type="checkbox" name="permissions[]" value="{{ $key }}" @checked(in_array($key, $effective, true))>
                <span style="margin:0;">
                  <strong style="display:block; font-size:13.5px;">
                    {{ $key }}
                    @if(in_array($key, $recommended, true))
                      <span class="badge badge-gold" style="font-size:10px; margin-left:4px;">Rekomendasi</span>
                    @endif
                  </strong>
                  <span style="font-size:12.5px; color:var(--muted);">{{ $permissionCatalog[$key] }}</span>
                </span>
              </label>
            @endforeach
          </div>
        </div>
      @endforeach
      @error('permissions')<div class="field-error">{{ $message }}</div>@enderror
      @error('access')<div class="field-error">{{ $message }}</div>@enderror
    </div>

    <div class="form-actions">
      <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Kembali</a>
      <button type="submit" class="btn btn-accent">Simpan sebagai Akses Khusus</button>
    </div>
  </form>

</x-admin-layout>
