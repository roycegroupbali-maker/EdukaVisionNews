# Panduan Lengkap — EdukaVisionNews

Proyek Laravel + Vite untuk portal berita **EdukaVisionNews**. Dokumen ini menjelaskan
struktur folder, cara instalasi, cara kerja CSS/JS yang sudah dirapikan, dan cara
mengembangkan fitur baru. Tinggal salin seluruh folder ini, ikuti langkah instalasi,
dan proyek siap jalan.

---

## 1. Struktur Folder (ringkas)

```
EdukaVisionNews/
├── app/                        # Kode backend Laravel (Controller, Model, Provider)
├── bootstrap/                  # Bootstrap framework Laravel
├── config/                     # File konfigurasi (app, database, mail, dst)
├── database/                   # Migrasi, seeder, factory
├── public/                     # Document root (index.php, favicon, hasil build Vite)
├── resources/
│   ├── css/                    # ⭐ SEMUA CSS ada di sini (lihat bagian 3)
│   ├── js/                     # ⭐ SEMUA JavaScript ada di sini (lihat bagian 4)
│   └── views/                  # Blade template (index.blade.php = halaman utama)
├── routes/
│   └── web.php                 # Routing halaman ("/" -> index.blade.php)
├── storage/                    # Cache, log, file upload
├── tests/                      # Unit & feature test (Pest)
├── .env / .env.example         # Konfigurasi environment
├── composer.json               # Dependensi PHP
├── package.json                # Dependensi Node/Vite
├── vite.config.js              # Konfigurasi build Vite
└── PANDUAN.md                  # File ini
```

> Folder `vendor/` (dependensi PHP) dan `node_modules/` (dependensi Node) **tidak
> disertakan** dalam paket ini karena ukurannya besar dan otomatis dibuat ulang
> saat instalasi (lihat Bagian 2). Ini praktik standar — jangan pernah
> menyalin `vendor/`/`node_modules/` secara manual antar proyek.

---

## 2. Instalasi & Menjalankan Proyek

### 2.1 Prasyarat
- PHP 8.2+ beserta ekstensi umum (mbstring, pdo, sqlite/mysql, dll)
- Composer 2.x
- Node.js 20+ dan npm
- (Opsional) MySQL/MariaDB jika tidak memakai SQLite bawaan

### 2.2 Langkah instalasi

```bash
# 1. Masuk ke folder proyek
cd EdukaVisionNews

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node/Vite (ini juga akan otomatis meng-install
#    Tailwind CSS v4 dan laravel-vite-plugin sesuai package.json)
npm install

# 4. Siapkan file environment (jika .env belum ada / ingin key baru)
cp .env.example .env
php artisan key:generate

# 5. Siapkan database (default: SQLite)
touch database/database.sqlite
php artisan migrate
```

### 2.3 Menjalankan mode development

Buka **dua terminal**:

```bash
# Terminal 1 — server Laravel
php artisan serve
```

```bash
# Terminal 2 — Vite dev server (hot reload CSS/JS otomatis)
npm run dev
```

Buka `http://127.0.0.1:8000` di browser. Setiap kali file CSS/JS di folder
`resources/css` atau `resources/js` disimpan, halaman akan otomatis refresh.

### 2.4 Build untuk produksi

```bash
npm run build
```

Perintah ini menghasilkan file CSS/JS yang sudah di-*minify* dan digabung
(bundled) ke dalam `public/build/`. Setelah build, cukup upload seluruh
proyek (tanpa `node_modules`) ke server, jalankan `composer install --no-dev`
di server, dan halaman akan otomatis memakai hasil build (bukan lagi mode dev).

---

## 3. Struktur CSS (folder `resources/css/`)

Semua CSS website EdukaVisionNews **sudah dipisah per bagian**, tidak lagi
digabung dalam satu file panjang. Tujuannya supaya gampang dicari & diedit.

```
resources/css/
├── app.css                     # Tailwind CSS (dipakai halaman welcome/dashboard bawaan Laravel)
├── site.css                    # ⭐ ENTRY POINT — hanya berisi daftar @import, urutannya penting
├── _responsive.css             # Semua media query (breakpoint tablet & mobile)
│
├── base/
│   ├── _reset-base.css         # Variabel warna (--ink, --gold, --pulse, dst), reset CSS, tipografi dasar
│   └── _progress-theme.css     # Reading progress bar + override tema gelap (dark mode)
│
├── layout/
│   ├── _topbar.css             # Bar utilitas paling atas (tanggal, cuaca, jam)
│   ├── _header.css             # Header utama: logo, menu navigasi, tombol aksi
│   ├── _search-overlay.css     # Overlay pencarian artikel
│   ├── _ticker.css             # Ticker berita berjalan (breaking news)
│   ├── _category-strip.css     # Strip kategori di bawah header
│   ├── _divider.css            # Garis dekoratif pemisah antar section
│   └── _footer.css             # Footer situs
│
└── components/
    ├── _ads.css                # Semua unit iklan (leaderboard, rectangle, native, sticky mobile)
    ├── _hero.css                # Section hero / berita utama
    ├── _section-header.css     # Judul tiap section ("Berita Terkini", "Dunia", dst)
    ├── _cards.css               # Grid kartu berita standar
    ├── _lifestyle-layout.css   # Layout 3 kolom khusus Lifestyle/Edukasi
    ├── _scoreboard.css          # Papan skor pertandingan olahraga
    ├── _world-strip.css         # Layout strip section Dunia/Internasional
    ├── _recipe.css               # Kartu & feature resep masakan
    ├── _poll.css                 # Widget jajak pendapat pembaca
    ├── _newsletter.css           # Form berlangganan newsletter
    └── _back-to-top.css          # Tombol kembali ke atas
```

### Cara kerja `site.css`

`site.css` **tidak berisi style langsung**, hanya daftar `@import` yang
memanggil semua file di atas secara berurutan (base → layout → components →
responsive). Urutan ini sengaja dijaga supaya *cascade* CSS (aturan yang
"menang" saat ada konflik) tetap sesuai desain asli.

```css
@import './base/_reset-base.css';
@import './base/_progress-theme.css';
@import './layout/_topbar.css';
/* ...dst */
@import './_responsive.css';   /* WAJIB PALING AKHIR */
```

Vite otomatis menggabungkan semua `@import` ini menjadi satu file CSS saat
build produksi (`npm run build`), jadi performa di browser tidak terpengaruh
meski file sumbernya dipecah banyak.

### Cara menambah / mengedit style

- **Mengubah warna tema** (merah "pulse", emas "gold", navy "ink", dst) →
  edit `resources/css/base/_reset-base.css`, bagian `:root { ... }`.
  Karena semua file lain memakai variabel CSS ini (`var(--pulse)`, dsb),
  mengubah satu tempat akan otomatis berlaku ke seluruh situs.
- **Mengubah tampilan komponen tertentu** (misal kartu resep) → langsung
  buka file yang sesuai, contoh `resources/css/components/_recipe.css`.
- **Menambah komponen baru** → buat file baru di `components/` atau
  `layout/`, lalu tambahkan barisnya di `site.css` sesuai urutan yang tepat.

---

## 4. Struktur JavaScript (folder `resources/js/`)

```
resources/js/
├── app.js                       # Bawaan starter Laravel (kosong, boleh dipakai bebas)
├── site.js                      # ⭐ ENTRY POINT — mengimpor & menjalankan semua modul fitur
└── modules/
    ├── reading-progress.js      # Bar progres bacaan di atas halaman
    ├── live-clock.js            # Jam berjalan di top bar
    ├── theme-toggle.js          # Tombol ganti mode terang/gelap
    ├── search.js                 # Overlay pencarian artikel (index dibangun otomatis dari kartu)
    ├── nav-scrollspy.js         # Strip kategori + penanda menu aktif saat scroll
    ├── trending-tabs.js          # Tab "Sedang Tren" (Terpopuler/Terbaru/Terkomentar)
    ├── poll.js                   # Widget jajak pendapat pembaca
    └── misc-widgets.js           # Muat berita lainnya, kembali ke atas, newsletter,
                                   # bookmark, tutup iklan sticky mobile
```

Setiap modul adalah **ES Module** (`export function initXxx() { ... }`) yang
hanya berjalan jika elemen HTML terkait ada di halaman (pakai pengecekan
`if (!el) return;`), jadi aman dipakai di halaman lain yang tidak
memiliki semua elemen tersebut.

`site.js` tinggal mengimpor dan memanggil semuanya:

```js
import { initReadingProgress } from './modules/reading-progress.js';
// ...import modul lain

function initSite() {
  initReadingProgress();
  // ...panggil modul lain
}

document.addEventListener('DOMContentLoaded', initSite);
```

### Cara menambah fitur JS baru

1. Buat file baru di `resources/js/modules/`, misalnya `modules/dark-mode-memory.js`.
2. Tulis fungsi `export function initDarkModeMemory() { ... }`.
3. Import dan panggil fungsi itu di `resources/js/site.js`.

Tidak perlu mengubah `vite.config.js` — semua file di dalam `modules/` otomatis
ikut ter-bundle karena diimpor lewat `site.js`.

---

## 5. Menghubungkan CSS/JS ke halaman (Blade)

Halaman utama ada di `resources/views/index.blade.php`. Di bagian `<head>`,
CSS dan JS dipanggil lewat satu baris directive Laravel Vite:

```blade
@vite(['resources/css/site.css', 'resources/js/site.js'])
```

- Saat **development** (`npm run dev` aktif), Vite menyuntikkan CSS/JS versi
  live-reload secara otomatis.
- Saat **produksi** (`npm run build` sudah dijalankan), Laravel otomatis
  membaca `public/build/manifest.json` dan memuat file hasil build yang
  sudah di-*minify*.

Jika ingin membuat halaman baru dengan CSS/JS terpisah (misalnya halaman
artikel detail), cukup buat file CSS/JS baru dan tambahkan ke daftar `input`
di `vite.config.js`:

```js
laravel({
    input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/site.css',
        'resources/js/site.js',
        // tambahkan entry baru di sini, contoh:
        // 'resources/css/artikel.css',
        // 'resources/js/artikel.js',
    ],
    refresh: true,
    // ...
}),
```

---

## 6. Daftar Fitur yang Sudah Ada

| Fitur | Lokasi CSS | Lokasi JS |
|---|---|---|
| Reading progress bar | `base/_progress-theme.css` | `modules/reading-progress.js` |
| Jam live di top bar | `layout/_topbar.css` | `modules/live-clock.js` |
| Mode gelap/terang | `base/_progress-theme.css` | `modules/theme-toggle.js` |
| Pencarian artikel (overlay) | `layout/_search-overlay.css` | `modules/search.js` |
| Ticker berita berjalan | `layout/_ticker.css` | – (CSS animation) |
| Strip kategori + scrollspy menu aktif | `layout/_category-strip.css` | `modules/nav-scrollspy.js` |
| Semua unit iklan (leaderboard, rectangle, native, sticky mobile) | `components/_ads.css` | `modules/misc-widgets.js` (tutup iklan mobile) |
| Hero / berita utama + tombol bookmark | `components/_hero.css` | `modules/misc-widgets.js` |
| Grid berita + tombol "Muat Berita Lainnya" | `components/_cards.css` | `modules/misc-widgets.js` |
| Widget "Sedang Tren" (tab) | (bagian dari `components/_ads.css` grid) | `modules/trending-tabs.js` |
| Papan skor olahraga | `components/_scoreboard.css` | – |
| Kartu & feature resep masakan | `components/_recipe.css` | – |
| Jajak pendapat pembaca (voting) | `components/_poll.css` | `modules/poll.js` |
| Form newsletter | `components/_newsletter.css` | `modules/misc-widgets.js` |
| Tombol kembali ke atas | `components/_back-to-top.css` | `modules/misc-widgets.js` |
| Responsif (tablet & mobile) | `_responsive.css` | – |

---

## 7. Tips Pengembangan Lanjutan

- **Data statis → dinamis**: Saat ini semua berita, resep, dan skor
  ditulis langsung di `index.blade.php` (data dummy). Untuk membuatnya
  dinamis, buat Model + Migration (mis. `Article`, `Category`), lalu
  ganti bagian HTML statis dengan `@foreach ($articles as $article)`.
- **Routing artikel detail**: tambahkan route baru di `routes/web.php`,
  misalnya `Route::get('/artikel/{slug}', [ArticleController::class, 'show'])`.
- **Autentikasi (login/redaksi)**: proyek ini starter Laravel standar,
  jadi bisa langsung pakai Laravel Breeze/Fortify bila perlu halaman admin.
- **Ganti font**: font Google (Fraunces, Inter, IBM Plex Mono) dipanggil di
  baris `@import url(...)` paling atas `resources/css/site.css`. Ganti URL
  tersebut untuk memakai font lain.

---

## 7.1 Panel Admin (Kelola Berita & Iklan)

Proyek ini sudah punya panel admin sederhana untuk mengelola berita per
kategori dan iklan yang tampil di situs, tanpa perlu utak-atik database
manual.

### Akses

- URL: `/admin/login`
- Tautan masuknya sengaja diletakkan **kecil di paling bawah footer**
  (tulisan "Admin", opacity rendah) di semua halaman publik — bukan di
  menu utama, supaya tidak mengganggu tampilan situs untuk pembaca biasa.
- Akun default (dibuat lewat seeder, **wajib diganti setelah login pertama**):
  - Email: `admin@edukavisionnews.test`
  - Password: `admin123`

### Fitur

1. **Dashboard** (`/admin`) — ringkasan jumlah berita (tayang/draf), jumlah
   iklan aktif, sebaran berita per kategori, berita terbaru & terpopuler.
2. **Berita** (`/admin/articles`) — tulis/edit/hapus berita, pilih kategori,
   atur excerpt, isi berita, penulis, estimasi baca, warna & pola gambar
   generatif (preview langsung berubah saat warna/pola diganti), field
   khusus resep (waktu masak/porsi/tingkat kesulitan), jadikan headline,
   tandai konten bersponsor, dan jadwalkan atau langsung tayangkan. Daftar
   berita bisa difilter per kategori, status (tayang/draf), atau dicari
   judulnya.
3. **Kategori** (`/admin/categories`) — tambah kategori baru, ubah nama/
   slug/urutan tampil langsung dari tabel. Kategori yang masih punya
   berita tidak bisa dihapus (harus dipindah/hapus beritanya dulu).
4. **Iklan / Ads** (`/admin/ads`) — upload gambar iklan untuk 4 slot yang
   sudah ada di desain situs: Leaderboard (970×90, atas halaman),
   Rectangle (300×600, samping widget), Tengah Halaman (728×250), dan
   Sticky Bar Mobile. Bisa atur tautan tujuan, teks tombol, jadwal
   mulai/berakhir tayang, aktif/nonaktif, dan urutan prioritas kalau ada
   beberapa iklan di slot yang sama. Setiap klik pengunjung ke iklan
   otomatis dihitung.

Kalau tidak ada iklan aktif di suatu slot, halaman publik otomatis
menampilkan placeholder desain aslinya ("Ruang Iklan …") — jadi situs
tetap rapi walau admin belum upload apa-apa.

### Setup tambahan yang WAJIB dijalankan

Karena panel admin butuh migrasi baru, seeder akun admin, dan upload
gambar iklan, jalankan langkah berikut setelah menarik kode ini (selain
langkah instalasi biasa di Bagian 2):

```bash
php artisan migrate            # menambah kolom is_admin & tabel ads
php artisan db:seed --class=Database\\Seeders\\AdminUserSeeder
php artisan storage:link       # supaya gambar iklan bisa diakses publik
npm install && npm run build   # compile CSS/JS baru untuk panel admin
```

Kalau ini instalasi baru dari nol, cukup jalankan `php artisan migrate --seed`
(seeder akun admin sudah didaftarkan di `DatabaseSeeder`).

### Cara kerja teknis singkat

- Login admin pakai session guard bawaan Laravel (`Auth::attempt`), lalu
  middleware `admin` (`app/Http/Middleware/EnsureUserIsAdmin.php`) memastikan
  hanya user dengan `is_admin = true` yang bisa masuk `/admin/*`.
- Gambar iklan disimpan di disk `public` (`storage/app/public/ads`), diakses
  lewat `Storage::url()` — makanya `storage:link` wajib dijalankan.
- Slot iklan aktif dikirim ke halaman publik lewat View Composer di
  `AppServiceProvider`, lalu dirender oleh partial
  `resources/views/partials/ad-slot.blade.php` yang otomatis fallback ke
  placeholder desain asli kalau belum ada iklan aktif di slot tersebut.

---

## 8. Ringkasan Perintah Cepat

```bash
composer install && npm install     # instalasi awal
cp .env.example .env && php artisan key:generate
php artisan migrate --seed          # migrasi + seed data (kategori, berita contoh, akun admin)
php artisan storage:link            # supaya gambar iklan yang diupload bisa diakses publik

php artisan serve                   # jalankan backend
npm run dev                         # jalankan Vite (mode development, tab terpisah)

npm run build                       # build produksi
```

Login panel admin: buka `/admin/login` (atau klik tautan kecil "Admin" di
footer paling bawah), pakai `admin@edukavisionnews.test` / `admin123`,
lalu segera ganti passwordnya.

Selamat berkarya! 🎉


