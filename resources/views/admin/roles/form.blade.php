@php
    $isEdit = $isEdit ?? false;
    $action = $isEdit ? route('admin.roles.update', $role) : route('admin.roles.store');
    $isSuperAdmin = $role->slug === \App\Models\Role::SUPER_ADMIN;
    $selected = old('permissions', $role->permissions ?? []);

    // Kelompokkan katalog permission per area supaya form lebih mudah dibaca.
    $groups = [
        'Berita & Alur Verifikasi' => ['articles.create', 'articles.view_all', 'articles.publish', 'articles.delete'],
        'Konten Situs' => ['categories.manage', 'running_texts.manage', 'news_submissions.manage', 'ads.manage'],
        'Analitik' => ['stats.view'],
        'Panel Admin' => ['users.manage', 'roles.manage'],
    ];
@endphp

<x-admin-layout :page-title="$isEdit ? 'Edit Jabatan' : 'Tambah Jabatan'" :page-subtitle="'Tentukan nama jabatan & hak akses yang dimilikinya di panel admin'">

  <form method="POST" action="{{ $action }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="form-grid">
      <div>
        <div class="form-card">
          <h3>Hak Akses</h3>

          @if($isSuperAdmin)
            <p style="font-size:13px; color:var(--muted); margin-bottom:14px;">
              Super Admin selalu memiliki <strong>seluruh hak akses</strong> secara otomatis dan tidak bisa dibatasi lewat form ini, supaya panel selalu punya minimal satu akun berkuasa penuh.
            </p>
          @endif

          @foreach($groups as $groupLabel => $keys)
            <div style="margin-bottom:18px;">
              <div style="font-weight:600; font-size:13px; color:var(--ink-2); margin-bottom:8px;">{{ $groupLabel }}</div>
              <div style="display:flex; flex-direction:column; gap:8px;">
                @foreach($keys as $key)
                  <label class="field checkbox-field" style="align-items:flex-start; margin:0;">
                    <input type="checkbox" name="permissions[]" value="{{ $key }}"
                      @checked($isSuperAdmin || in_array($key, $selected, true))
                      @disabled($isSuperAdmin)>
                    <span style="margin:0;">
                      <strong style="display:block; font-size:13.5px;">{{ $key }}</strong>
                      <span style="font-size:12.5px; color:var(--muted);">{{ \App\Models\Role::permissionCatalog()[$key] }}</span>
                    </span>
                  </label>
                @endforeach
              </div>
            </div>
          @endforeach
          @error('permissions')<div class="field-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="sticky-side">
        <div class="form-card">
          <h3>Detail Jabatan</h3>

          <div class="field">
            <label for="nameInput">Nama Jabatan</label>
            <input type="text" id="nameInput" name="name" value="{{ old('name', $role->name) }}" required maxlength="100"
              placeholder="mis. Redaktur Pelaksana" @disabled($role->is_system)>
            @if($role->is_system)
              <div class="field-hint">Nama jabatan bawaan sistem tidak bisa diubah.</div>
              <input type="hidden" name="name" value="{{ $role->name }}">
            @endif
            @error('name')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="descriptionInput">Deskripsi <span style="font-weight:400; color:var(--muted-2);">(opsional)</span></label>
            <textarea id="descriptionInput" name="description" maxlength="255" style="min-height:80px;"
              placeholder="Jelaskan tanggung jawab jabatan ini…">{{ old('description', $role->description) }}</textarea>
            @error('description')<div class="field-error">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="form-actions">
          <a href="{{ route('admin.roles.index') }}" class="btn btn-ghost">Batal</a>
          <button type="submit" class="btn btn-accent">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Jabatan' }}</button>
        </div>
      </div>
    </div>
  </form>

</x-admin-layout>
