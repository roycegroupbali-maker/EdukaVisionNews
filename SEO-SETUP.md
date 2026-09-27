# Setup SEO — EdukaVisionNews

Ringkasan perubahan yang ditambahkan ke project, dan langkah lanjutan yang perlu kamu lakukan sendiri (verifikasi domain, dll).

## 1. Apa yang sudah dibuat/diperbaiki di kode

**`resources/views/partials/header.blade.php`** (dipakai semua halaman publik)
- Meta `description`, `keywords`, `robots`/`googlebot`, `author` — sekarang bisa dioverride per halaman.
- `og:image` + `twitter:image` — sebelumnya tidak pernah dikirim sama sekali (share ke WhatsApp/Facebook/Twitter tidak akan menampilkan gambar). Sekarang pakai foto artikel, fallback ke logo.
- Variabel `ogType`, `ogPublishedTime`, `ogSection` yang tadinya sudah dikirim dari halaman artikel tapi **tidak pernah dipakai** di header — sekarang dirender sebagai meta `article:published_time`, `article:modified_time`, `article:author`, `article:section`, `article:tag`.
- JSON-LD `NewsMediaOrganization` + `WebSite` dengan `SearchAction` (sitewide) — ini yang memungkinkan Google menampilkan **kotak pencarian di bawah hasil pencarian** (sitelinks search box) dan mengenali identitas media.
- JSON-LD `BreadcrumbList` opsional lewat variabel `$breadcrumbs` — sudah dipasang di halaman artikel & kategori.
- `apple-touch-icon`, `og:locale=id_ID`.

**`resources/views/articles/show.blade.php`**
- Kirim gambar artikel, tag, author, breadcrumb ke header.
- JSON-LD `NewsArticle` dilengkapi: `image`, `inLanguage`, `keywords`, `wordCount` (sebelumnya sudah ada headline/tanggal/publisher, itu dipertahankan).

**`resources/views/categories/show.blade.php`** — breadcrumb + keyword kategori.

**`resources/views/search.blade.php`** dan **`resources/views/news-submission/track.blade.php`**
- Ditambahi `noindex, follow` — halaman hasil pencarian & lacak tiket adalah konten tipis/duplikat yang sebaiknya tidak masuk index Google (praktik standar semua situs berita/e-commerce).

**`app/Http/Controllers/SitemapController.php`** + **`resources/views/partials/sitemap.blade.php`**
- `lastmod` kategori sekarang dihitung dari artikel terbaru di kategori itu (sebelumnya selalu `now()`, jadi tidak informatif untuk crawler).
- Tambah `changefreq` per jenis halaman.
- Tambah `<image:image>` untuk artikel yang punya foto (image sitemap → peluang muncul di Google Images/Google Discover).
- Tambah 3 halaman statis (Tentang Kami, Redaksi, Pedoman Media Siber) ke sitemap.

**`routes/web.php`** — `robots.txt` diubah dari file statis menjadi route dinamis, supaya baris `Sitemap:` selalu memakai domain asli (`APP_URL`) di production, bukan hardcoded. `/admin` tetap diblokir; `/cari` & `/lacak-berita` sengaja dibiarkan bisa di-crawl (dikontrol lewat meta `noindex` di halamannya, bukan `Disallow`, supaya Google benar-benar bisa men-deindex-nya).

**`.env.example`** — `APP_NAME=EdukaVisionNews`, `APP_LOCALE=id` (sebelumnya `en`, padahal `<html lang="id">` dan semua tanggal ditampilkan dalam Bahasa Indonesia — ini memperbaiki ketidaksesuaian bahasa yang dilihat mesin pencari).

## 2. Yang WAJIB kamu lakukan sendiri setelah deploy

1. **Isi `APP_URL`** di `.env` produksi dengan domain asli (`https://edukavisionnews.com`, bukan `http://localhost`). Semua canonical URL, sitemap, dan Open Graph URL mengikuti nilai ini.
2. **Daftarkan ke Google Search Console** (search.google.com/search-console) dan **Bing Webmaster Tools**, verifikasi kepemilikan domain, lalu submit `https://domainmu.com/sitemap.xml`.
3. **Cek `robots.txt` & `sitemap.xml` di production** — buka `/robots.txt` dan `/sitemap.xml` langsung di browser untuk pastikan URL yang muncul sudah domain asli, bukan `localhost`.
4. **Isi `sameAs` di JSON-LD Organization** (`partials/header.blade.php`, baris `'sameAs' => []`) dengan link akun resmi Facebook/Instagram/X kalau ada — membantu Google menyatukan identitas brand.
5. **Upload gambar untuk setiap artikel** (field `image_path`/`image_alt` di admin) — artikel tanpa foto memakai logo sebagai fallback share image, kurang menarik di media sosial.
6. Opsional tapi disarankan: pasang Google Analytics 4 / Search Console Insights untuk memonitor performa, dan daftar ke **Google News Publisher Center** kalau memang media berita aktif (butuh syarat tambahan dari Google: kepemilikan editorial jelas, tanggal publikasi konsisten — halaman Redaksi & Pedoman Media Siber yang sudah ada membantu ini).

## 3. Yang tidak diubah karena sudah baik
- Struktur URL sudah SEO-friendly (`/berita/judul-slug`, `/kategori/slug`).
- Setiap halaman artikel sudah punya satu `<h1>` yang jelas.
- Canonical tag dan sitemap dasar sudah ada sebelumnya — hanya diperkuat.
