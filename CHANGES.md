# Perubahan: 4 Fitur Baru (OMS/Admin Panel + Website Berita)

Semua fitur di bawah ini ditambahkan **tanpa mengubah struktur/alur yang
sudah berjalan** — field, nama route, dan tampilan lama tetap sama; yang
baru murni ditambahkan.

## 0. Cara memasang (WAJIB dijalankan)

```bash
composer install        # kalau vendor/ belum ada
php artisan migrate      # menambah tabel article_likes, comments,
                          # + kolom likes & comments_enabled di articles
npm install
npm run build             # atau: npm run dev
```

Tidak ada seeder baru yang wajib dijalankan, tapi kalau Anda mem-fresh-seed
database dari awal (`php artisan migrate:fresh --seed`), role **Editor**
otomatis mendapat izin baru `comments.manage` (moderasi komentar). Role
**Super Admin** otomatis mendapat semua izin baru karena memakai
`array_keys(Role::permissionCatalog())`.

Kalau database Anda sudah berjalan lama dan role Editor sudah pernah dibuat
sebelumnya, jalankan ulang seeder role saja supaya izin barunya masuk:

```bash
php artisan db:seed --class=RoleSeeder
```

---

## 1. Text Editor: Bold / Italic / Underline

- **Admin → Tulis/Edit Berita → "Isi Berita"** sekarang punya toolbar
  **B / I / U** di atas kotak isi berita.
- Textarea asli (`name="content"`) tetap ada (disembunyikan) sehingga
  validasi & alur simpan di `Admin\ArticleController` **tidak berubah sama
  sekali** — editor kaya teks di atasnya hanya menyinkronkan HTML ke
  textarea itu sebelum form dikirim.
- Berita **lama** (teks polos, paragraf dipisah baris kosong) tetap tampil
  normal — dideteksi otomatis dan dibungkus `<p>` saat ditampilkan.
- Berita **baru** yang disunting lewat editor ini disimpan sebagai HTML
  minimal (`<p>`, `<strong>`, `<em>`, `<u>`, dst).
- **Keamanan**: sebelum dirender ke halaman publik, HTML disaring lewat
  whitelist ketat di `App\Support\HtmlSanitizer` — hanya tag
  `p, br, strong, b, em, i, u, ul, ol, li` yang dipertahankan, **semua**
  atribut dibuang (jadi `onclick`, `style`, `href="javascript:..."`, dll
  tidak pernah bisa lolos), dan `<script>`/`<style>`/`<iframe>` dibuang
  beserta isinya. Sudah diuji manual terhadap beberapa payload XSS umum.
- Judul berita otomatis tampil tebal di halaman berita (elemen `<h1>` sudah
  bold secara default di desain situs) — tidak perlu toggle terpisah.

**File terkait**: `app/Support/HtmlSanitizer.php` (baru),
`app/Models/Article.php` (accessor `content_html` baru),
`resources/views/admin/articles/form.blade.php`,
`resources/views/articles/show.blade.php`,
`resources/css/admin/admin.css`.

---

## 2. Share ke Media Sosial

- Menambah **Telegram** ke tombol share yang sudah ada (WhatsApp, Facebook,
  X) — jadi sekarang lengkap 4 platform sesuai permintaan.
- Link & judul berita otomatis ikut terbawa (pakai `route('article.share', …)`
  yang sudah ada sebelumnya, hanya ditambah 1 case baru di
  `ArticleShareController`).
- Foto utama berita sudah otomatis jadi preview di WhatsApp/Facebook/
  Telegram karena meta tag Open Graph (`og:image`, dll) sudah ada di
  `partials/header.blade.php` sebelum perubahan ini — tidak perlu diubah.
- URL asli berita **tidak diubah** sama sekali.

**File terkait**: `app/Http/Controllers/ArticleShareController.php`,
`resources/views/articles/show.blade.php`.

---

## 3. Like Berita (Tentative)

- Tombol **Suka** muncul di sebelah tombol share pada halaman berita,
  menampilkan jumlah like dan bertambah saat ditekan.
- **Anti-spam**: setiap pengunjung dikenali lewat cookie anonim tahan-lama
  (bukan akun), lalu kombinasi berita + pengunjung diberi **UNIQUE
  constraint** di database (`article_likes`) — jadi walau tombol diklik
  berkali-kali atau request dikirim paralel, like yang tercatat tetap
  hanya satu per pengunjung per berita (klik lagi = unlike/toggle).
  Ditambah rate-limit (`throttle:20,1`) di route sebagai lapisan kedua.
- **Mudah dimatikan**: satu saklar di `config/features.php` /
  `.env` (`FEATURE_LIKES_ENABLED=false`) mematikan fitur ini di seluruh
  situs — tombolnya hilang dan route-nya otomatis mengembalikan 404, tanpa
  perlu ubah kode.

**File terkait**: `app/Http/Controllers/ArticleLikeController.php` (baru),
`app/Models/ArticleLike.php` (baru), migration
`create_article_likes_table`, `config/features.php`,
`resources/js/modules/article-like.js` (baru),
`resources/css/components/_engagement.css` (baru).

---

## 4. Komentar di Bawah Berita

- Form komentar (nama + isi) tampil di bawah isi berita, di atas daftar
  komentar yang sudah disetujui (nama & waktu ditampilkan).
- **Moderasi**: komentar baru selalu berstatus **pending** dulu, tidak
  langsung tampil. Admin/Editor dengan izin `comments.manage` melihat &
  memoderasi semua komentar dari seluruh berita di menu baru
  **Admin → Komentar**, dengan aksi **Setujui / Sembunyikan / Hapus** dan
  badge jumlah komentar pending di sidebar.
- **Per-berita on/off**: checkbox "Izinkan komentar pembaca pada berita
  ini" di form tulis/edit berita (default aktif). Kalau dimatikan untuk
  satu berita tertentu, form komentar tidak tampil di berita itu meskipun
  saklar global komentar aktif.
- **Saklar global**: `FEATURE_COMMENTS_ENABLED` di `.env` (default `true`)
  mematikan komentar di seluruh situs sekaligus kalau perlu.
- **Keamanan/anti-spam** (berlapis):
  1. Honeypot (field tersembunyi) — bot pengisi form otomatis biasanya
     mengisinya, request seperti itu langsung diabaikan diam-diam.
  2. Validasi ketat panjang nama (maks 100) & komentar (3–2000 karakter).
  3. `strip_tags()` saat disimpan — **tidak ada HTML/JS sama sekali** yang
     masuk ke database.
  4. Saat ditampilkan tetap dirender lewat `{{ }}` (auto-escape Blade),
     bukan `{!! !!}` — lapis pertahanan kedua terhadap XSS.
  5. Rate limit per IP (`throttle:5,1`) di route pengiriman komentar.

**File terkait**: `app/Models/Comment.php` (baru),
`app/Http/Controllers/CommentController.php` (baru, publik),
`app/Http/Controllers/Admin/CommentController.php` (baru, moderasi),
`resources/views/admin/comments/index.blade.php` (baru), migration
`create_comments_table`, izin baru `comments.manage` di `app/Models/Role.php`
& `database/seeders/RoleSeeder.php` (diberikan ke role Editor secara
default), `resources/views/components/admin-layout.blade.php` (menu
sidebar baru).

---

## Ringkasan file yang ditambahkan

```
app/Support/HtmlSanitizer.php
app/Models/ArticleLike.php
app/Models/Comment.php
app/Http/Controllers/ArticleLikeController.php
app/Http/Controllers/CommentController.php
app/Http/Controllers/Admin/CommentController.php
config/features.php
database/migrations/2026_09_28_000001_add_likes_and_comments_settings_to_articles_table.php
database/migrations/2026_09_28_000002_create_article_likes_table.php
database/migrations/2026_09_28_000003_create_comments_table.php
resources/views/admin/comments/index.blade.php
resources/js/modules/article-like.js
resources/css/components/_engagement.css
```

## Ringkasan file yang diubah (tidak ada fitur lama yang dihapus)

```
app/Models/Article.php                         (+relasi, +accessor content_html)
app/Models/Role.php                             (+1 izin: comments.manage)
app/Http/Controllers/ArticleController.php      (eager-load approvedComments)
app/Http/Controllers/ArticleShareController.php (+Telegram)
app/Http/Controllers/Admin/ArticleController.php(+validasi comments_enabled)
database/seeders/RoleSeeder.php                 (+izin comments.manage utk Editor)
routes/web.php                                  (+5 route baru)
resources/views/articles/show.blade.php         (+Telegram, +Like, +Komentar, content_html)
resources/views/admin/articles/form.blade.php   (+toolbar B/I/U, +checkbox komentar)
resources/views/components/admin-layout.blade.php (+menu "Komentar")
resources/css/admin/admin.css                   (+style toolbar rich text)
resources/css/site.css                          (+import _engagement.css)
resources/js/site.js                            (+initArticleLike)
```

Semua sudah dicek dengan `php -l` (tanpa error sintaks) dan
`App\Support\HtmlSanitizer` sudah diuji manual terhadap beberapa payload
XSS umum (script tag, event-handler attribute, `javascript:` URL, tag tak
dikenal) — semuanya berhasil disaring dengan benar. Karena environment ini
tidak memiliki `vendor/` (Composer) maupun database untuk menjalankan
`php artisan migrate`/test end-to-end, mohon jalankan migrasi & lakukan
smoke test singkat di environment Anda sebelum deploy ke produksi.
