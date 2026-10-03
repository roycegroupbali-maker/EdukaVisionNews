<x-admin-layout :page-title="'Pengaturan Akun'" :page-subtitle="'Kelola nama, email, dan kata sandi akun admin kamu'">

  <div class="form-grid">
    <div>
      <div class="form-card">
        <h3>Informasi Akun</h3>

        <form method="POST" action="{{ route('admin.account.update') }}">
          @csrf
          @method('PUT')

          <div class="field">
            <label for="accName">Nama</label>
            <input type="text" id="accName" name="name" value="{{ old('name', $user->name) }}" required maxlength="100">
            @error('name')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="accEmail">Email</label>
            <input type="email" id="accEmail" name="email" value="{{ old('email', $user->email) }}" required maxlength="150">
            @error('email')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="accPassword">Kata Sandi Baru <span style="font-weight:400; color:var(--muted-2);">(kosongkan kalau tidak ingin mengganti)</span></label>
            <input type="password" id="accPassword" name="password" placeholder="••••••••" autocomplete="new-password">
            <div class="field-hint">Minimal 8 karakter.</div>
            @error('password')<div class="field-error">{{ $message }}</div>@enderror
          </div>

          <div class="field">
            <label for="accPasswordConfirm">Konfirmasi Kata Sandi Baru</label>
            <input type="password" id="accPasswordConfirm" name="password_confirmation" placeholder="••••••••" autocomplete="new-password">
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-accent">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>

    <div class="sticky-side">
      <div class="form-card">
        <h3>Verifikasi Email</h3>
        @if($user->email_verified_at)
          <p style="font-size:13px; color:var(--muted); line-height:1.6;">
            ✓ Email <strong>{{ $user->email }}</strong> sudah terverifikasi
            ({{ $user->email_verified_at->translatedFormat('d M Y') }}).
          </p>
        @else
          <p style="font-size:13px; color:var(--muted); line-height:1.6;">
            Email <strong>{{ $user->email }}</strong> belum diverifikasi. Verifikasi bersifat
            opsional dan tidak memengaruhi login. Kami akan mengirim tautan ke email ini
            hanya saat kamu menekan tombol di bawah.
          </p>
          <form method="POST" action="{{ route('admin.account.verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-accent">Kirim email verifikasi</button>
          </form>
        @endif
      </div>

      <div class="form-card">
        <h3>Keamanan</h3>
        <p style="font-size:13px; color:var(--muted); line-height:1.6;">
          Halaman ini dikunci dengan konfirmasi kata sandi. Setelah beberapa waktu tidak
          digunakan, kamu akan diminta memasukkan kata sandi lagi sebelum bisa mengubah
          data akun.
        </p>
      </div>
    </div>
  </div>

</x-admin-layout>
