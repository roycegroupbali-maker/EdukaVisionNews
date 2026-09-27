<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug');

        foreach ($this->articles() as $i => $a) {
            Article::updateOrCreate(
                ['slug' => Str::slug($a['title'])],
                [
                    'category_id' => $categories[$a['cat']],
                    'title' => $a['title'],
                    'subcategory' => $a['sub'] ?? null,
                    'excerpt' => $a['excerpt'],
                    'content' => $a['content'],
                    'author' => $a['author'] ?? 'Redaksi EdukaVisionNews',
                    'read_minutes' => $a['read'] ?? 4,
                    'views' => $a['views'] ?? random_int(120, 4200),
                    'art_color1' => $a['c1'],
                    'art_color2' => $a['c2'],
                    'art_pattern' => $a['pattern'] ?? 'wave',
                    'recipe_minutes' => $a['recipe_minutes'] ?? null,
                    'recipe_servings' => $a['recipe_servings'] ?? null,
                    'recipe_difficulty' => $a['recipe_difficulty'] ?? null,
                    'is_featured' => $a['featured'] ?? false,
                    'is_sponsored' => $a['sponsored'] ?? false,
                    'status' => Article::STATUS_PUBLISHED,
                    'published_at' => now()->subHours($i * 3 + random_int(1, 2)),
                ]
            );
        }
    }

    private function articles(): array
    {
        return [
            // ===================== BERITA =====================
            [
                'cat' => 'berita', 'featured' => true, 'read' => 6,
                'title' => 'Anggaran Infrastruktur Digital Desa Naik 40 Persen Tahun Depan',
                'sub' => 'Berita Terkini', 'author' => 'Ratih Anggraeni',
                'excerpt' => 'Pemerintah pusat menaikkan alokasi dana untuk jaringan internet desa demi mempercepat pemerataan akses pendidikan dan layanan publik hingga ke wilayah terpencil.',
                'content' => "Pemerintah pusat resmi menaikkan alokasi anggaran infrastruktur digital desa sebesar 40 persen untuk tahun anggaran mendatang. Kenaikan ini ditujukan untuk mempercepat pembangunan jaringan internet di wilayah pedesaan dan daerah 3T (tertinggal, terdepan, terluar) yang selama ini masih bergantung pada sinyal seluler terbatas.\n\nMenurut keterangan resmi, dana tambahan akan digunakan untuk membangun menara telekomunikasi baru, memasang kabel serat optik di jalur-jalur prioritas, serta menyediakan subsidi perangkat bagi sekolah dan puskesmas. Program ini diharapkan menjangkau lebih dari seribu desa yang selama ini masuk kategori wilayah blank spot.\n\nSejumlah pemerintah daerah menyambut baik kebijakan ini karena dinilai akan mempercepat digitalisasi layanan publik, mulai dari administrasi kependudukan hingga sistem pembelajaran jarak jauh. Namun sejumlah pengamat mengingatkan agar pemerataan akses juga dibarengi dengan pelatihan literasi digital bagi warga agar manfaatnya benar-benar dirasakan.",
                'c1' => '#14213D', 'c2' => '#2a3f75', 'pattern' => 'wave',
            ],
            [
                'cat' => 'berita', 'read' => 4,
                'title' => 'DPR Sahkan Revisi Aturan Perlindungan Data Pribadi Konsumen',
                'sub' => 'Nasional',
                'excerpt' => 'Aturan baru memperketat kewajiban pelaku usaha digital dalam pengelolaan data pengguna.',
                'content' => "Dewan Perwakilan Rakyat mengesahkan revisi aturan perlindungan data pribadi konsumen dalam rapat paripurna. Revisi ini memperketat kewajiban pelaku usaha digital dalam mengumpulkan, menyimpan, dan mengelola data penggunanya.\n\nSalah satu poin utama revisi adalah kewajiban perusahaan melaporkan insiden kebocoran data dalam waktu maksimal 3x24 jam sejak diketahui, disertai sanksi administratif yang lebih tegas bagi pelanggar. Perusahaan rintisan (startup) diberi masa transisi selama satu tahun untuk menyesuaikan sistem mereka.\n\nAsosiasi pelaku usaha digital menyatakan kesiapannya mendukung aturan baru ini, meski meminta pemerintah menyediakan panduan teknis yang jelas agar implementasinya tidak membebani usaha kecil dan menengah.",
                'c1' => '#2a3f75', 'c2' => '#FBF8F3', 'pattern' => 'dots',
            ],
            [
                'cat' => 'berita', 'read' => 3,
                'title' => 'Rupiah Menguat Tipis Ditopang Optimisme Investor Asing',
                'sub' => 'Ekonomi',
                'excerpt' => 'Analis menilai penguatan didorong sentimen positif dari data neraca dagang.',
                'content' => "Nilai tukar rupiah terhadap dolar Amerika Serikat ditutup menguat tipis pada perdagangan hari ini, ditopang oleh optimisme investor asing terhadap prospek ekonomi domestik. Penguatan ini melanjutkan tren positif sepekan terakhir.\n\nAnalis pasar uang menilai sentimen positif didorong oleh rilis data neraca dagang yang mencatatkan surplus lebih besar dari perkiraan pasar. Arus masuk modal asing ke pasar obligasi domestik juga tercatat meningkat dalam beberapa hari terakhir.\n\nMeski demikian, sejumlah analis mengingatkan potensi volatilitas masih tinggi menjelang keputusan suku bunga bank sentral negara-negara maju yang dapat memengaruhi arah pergerakan nilai tukar dalam jangka pendek.",
                'c1' => '#2a3f75', 'c2' => '#FBF8F3', 'pattern' => 'circles',
            ],
            [
                'cat' => 'berita', 'read' => 5,
                'title' => 'Proyek Jalan Tol Trans-Sulawesi Masuk Tahap Pembebasan Lahan',
                'sub' => 'Daerah',
                'excerpt' => 'Pemerintah daerah menjanjikan proses ganti rugi yang transparan bagi warga terdampak.',
                'content' => "Proyek strategis nasional Jalan Tol Trans-Sulawesi memasuki tahap pembebasan lahan di beberapa titik seksi utama. Pemerintah daerah setempat menjanjikan proses ganti rugi yang transparan dan sesuai dengan nilai appraisal independen bagi warga terdampak.\n\nSosialisasi telah dilakukan di sejumlah desa yang dilalui trase jalan tol, melibatkan tim appraisal, notaris, dan perwakilan warga. Sebagian besar warga menyatakan mendukung proyek asalkan proses ganti rugi berjalan cepat dan adil.\n\nPemerintah menargetkan pembebasan lahan rampung dalam delapan bulan ke depan agar konstruksi fisik dapat dimulai sesuai jadwal, mengingat proyek ini diharapkan memangkas waktu tempuh antarkota secara signifikan.",
                'c1' => '#1c2c52', 'c2' => '#FBF8F3', 'pattern' => 'triangle',
            ],
            [
                'cat' => 'berita', 'read' => 4,
                'title' => 'Startup Lokal Kembangkan Sensor Cuaca Murah untuk Petani',
                'sub' => 'Teknologi',
                'excerpt' => 'Alat ini diklaim mampu memangkas biaya pemantauan cuaca hingga separuh harga pasar.',
                'content' => "Sebuah perusahaan rintisan lokal mengembangkan sensor cuaca berbiaya rendah yang dirancang khusus untuk kebutuhan petani skala kecil. Alat ini diklaim mampu memangkas biaya pemantauan cuaca hingga separuh dibandingkan perangkat sejenis yang beredar di pasaran.\n\nSensor tersebut mampu mengukur kelembapan tanah, curah hujan, dan suhu udara secara real-time, lalu mengirimkan data ke aplikasi ponsel petani melalui jaringan seluler dasar sehingga tetap dapat digunakan di wilayah dengan sinyal terbatas.\n\nUji coba di beberapa kelompok tani menunjukkan hasil positif berupa penghematan penggunaan air irigasi dan penurunan risiko gagal panen akibat perubahan cuaca ekstrem yang tidak terdeteksi lebih awal.",
                'c1' => '#0f1830', 'c2' => '#C9A227', 'pattern' => 'dots',
            ],
            [
                'cat' => 'berita', 'read' => 4,
                'title' => 'Layanan Telemedis Gratis Diperluas ke 50 Puskesmas Baru',
                'sub' => 'Kesehatan',
                'excerpt' => 'Program ini menyasar wilayah dengan rasio dokter dan penduduk yang masih timpang.',
                'content' => "Kementerian Kesehatan memperluas cakupan layanan telemedis gratis ke 50 puskesmas baru yang tersebar di wilayah dengan rasio dokter dan penduduk yang masih timpang. Perluasan ini menjadi bagian dari upaya pemerataan akses layanan kesehatan dasar.\n\nMelalui layanan ini, pasien di puskesmas dapat berkonsultasi langsung dengan dokter spesialis dari kota besar tanpa harus melakukan rujukan fisik, terutama untuk kasus-kasus yang tidak memerlukan penanganan darurat.\n\nPihak kementerian menargetkan seluruh puskesmas di wilayah 3T sudah terhubung dengan sistem telemedis dalam dua tahun ke depan, seiring dengan perluasan infrastruktur internet desa yang tengah berjalan.",
                'c1' => '#1c2c52', 'c2' => '#FBF8F3', 'pattern' => 'grid',
            ],

            // ===================== DUNIA =====================
            [
                'cat' => 'dunia', 'read' => 6,
                'title' => 'Delegasi ASEAN Sepakati Peta Jalan Transisi Energi Bersih Kawasan',
                'sub' => 'Diplomasi',
                'excerpt' => 'Sejumlah negara anggota berkomitmen memangkas emisi karbon melalui investasi bersama di sektor energi terbarukan.',
                'content' => "Para delegasi negara anggota ASEAN menyepakati peta jalan bersama untuk mempercepat transisi energi bersih di kawasan. Kesepakatan ini dicapai setelah rangkaian pertemuan tingkat menteri yang membahas target pengurangan emisi karbon regional.\n\nDalam peta jalan tersebut, negara-negara anggota berkomitmen meningkatkan porsi energi terbarukan dalam bauran energi nasional masing-masing, sekaligus membuka peluang investasi lintas negara untuk proyek pembangkit listrik tenaga surya dan angin skala besar.\n\nSejumlah analis menilai kesepakatan ini penting sebagai sinyal politik, meski implementasinya akan sangat bergantung pada kemampuan pendanaan dan transfer teknologi masing-masing negara anggota dalam beberapa tahun ke depan.",
                'c1' => '#5B4B8A', 'c2' => '#FBF8F3', 'pattern' => 'circles',
            ],
            [
                'cat' => 'dunia', 'read' => 4,
                'title' => 'Bank Sentral Eropa Tahan Suku Bunga di Tengah Inflasi Melandai',
                'sub' => 'Ekonomi Global',
                'excerpt' => 'Keputusan ini sejalan dengan ekspektasi pasar meski sejumlah ekonom memperkirakan pemangkasan tahun depan.',
                'content' => "Bank Sentral Eropa memutuskan menahan suku bunga acuan pada level saat ini, sejalan dengan ekspektasi mayoritas pelaku pasar. Keputusan ini diambil di tengah tren inflasi kawasan yang mulai melandai mendekati target jangka panjang.\n\nDalam konferensi pers, pejabat bank sentral menekankan bahwa keputusan ke depan akan tetap bergantung pada data ekonomi, termasuk perkembangan pasar tenaga kerja dan harga energi yang masih fluktuatif akibat ketegangan geopolitik.\n\nSejumlah ekonom memperkirakan ruang pemangkasan suku bunga baru akan terbuka pada tahun depan apabila tren disinflasi terus berlanjut secara konsisten selama beberapa kuartal mendatang.",
                'c1' => '#4a3d70', 'c2' => '#FBF8F3', 'pattern' => 'triangle',
            ],
            [
                'cat' => 'dunia', 'read' => 5,
                'title' => 'Misi Eksplorasi Laut Dalam Temukan Ekosistem Baru di Pasifik',
                'sub' => 'Sains',
                'excerpt' => 'Para peneliti mendokumentasikan spesies yang belum pernah tercatat sebelumnya di kedalaman lebih dari 5.000 meter.',
                'content' => "Sebuah tim peneliti internasional berhasil mendokumentasikan ekosistem laut dalam baru di kawasan Pasifik pada kedalaman lebih dari 5.000 meter. Temuan ini diperoleh melalui misi eksplorasi menggunakan kendaraan bawah laut tanpa awak.\n\nDalam ekspedisi tersebut, tim menemukan sejumlah spesies yang diduga belum pernah tercatat dalam literatur ilmiah sebelumnya, termasuk beberapa jenis moluska dan organisme mikroskopis yang hidup di sekitar ventilasi hidrotermal.\n\nPara ilmuwan menyebut temuan ini penting untuk memahami ketahanan ekosistem laut dalam terhadap perubahan iklim, sekaligus menjadi dasar argumen bagi perluasan kawasan konservasi laut internasional.",
                'c1' => '#3d3260', 'c2' => '#C9A227', 'pattern' => 'dots',
            ],
            [
                'cat' => 'dunia', 'read' => 4,
                'title' => 'KTT Regional Bahas Kerja Sama Energi Terbarukan Antarnegara',
                'sub' => 'Diplomasi',
                'excerpt' => 'Pemimpin kawasan menandatangani nota kesepahaman awal untuk proyek interkoneksi listrik lintas batas.',
                'content' => "Konferensi tingkat tinggi regional membahas perluasan kerja sama energi terbarukan antarnegara, termasuk rencana interkoneksi jaringan listrik lintas batas yang memungkinkan ekspor-impor listrik hijau antarnegara tetangga.\n\nBeberapa kepala negara menandatangani nota kesepahaman awal sebagai landasan studi kelayakan proyek, yang ditargetkan rampung dalam dua tahun ke depan sebelum memasuki tahap konstruksi.\n\nProyek ini digadang-gadang dapat memperkuat ketahanan energi kawasan sekaligus mempercepat pencapaian target netral karbon yang telah disepakati bersama dalam berbagai forum internasional.",
                'c1' => '#5B4B8A', 'c2' => '#FBF8F3', 'pattern' => 'wave',
            ],

            // ===================== BISNIS =====================
            [
                'cat' => 'bisnis', 'read' => 3,
                'title' => 'IHSG Ditutup Menguat Didorong Sektor Perbankan dan Energi',
                'sub' => 'Pasar Modal',
                'excerpt' => 'Aksi beli investor domestik menopang penguatan indeks di tengah sentimen global yang beragam.',
                'content' => "Indeks Harga Saham Gabungan (IHSG) ditutup menguat pada perdagangan hari ini, ditopang oleh penguatan saham-saham sektor perbankan dan energi. Aksi beli investor domestik menjadi penopang utama di tengah sentimen global yang masih beragam.\n\nBeberapa saham blue chip perbankan mencatatkan kenaikan signifikan menyusul rilis laporan keuangan kuartalan yang melampaui ekspektasi analis. Sektor energi turut terangkat seiring kenaikan harga komoditas global.\n\nAnalis pasar modal memperkirakan penguatan berpotensi berlanjut dalam jangka pendek, meski investor tetap diimbau mewaspadai volatilitas menjelang rilis data ekonomi makro dari negara-negara mitra dagang utama.",
                'c1' => '#14213D', 'c2' => '#C9A227', 'pattern' => 'wave',
            ],
            [
                'cat' => 'bisnis', 'read' => 4,
                'title' => 'Perusahaan Logistik Nasional Perluas Gudang ke 6 Kota Baru',
                'sub' => 'Perusahaan',
                'excerpt' => 'Ekspansi ini merespons lonjakan volume belanja daring menjelang akhir tahun.',
                'content' => "Salah satu perusahaan logistik nasional mengumumkan rencana perluasan gudang penyimpanan ke enam kota baru sebagai respons atas lonjakan volume belanja daring menjelang akhir tahun. Investasi ekspansi ini mencapai ratusan miliar rupiah.\n\nDengan tambahan fasilitas baru, perusahaan menargetkan waktu pengiriman ke wilayah timur Indonesia dapat dipangkas hingga satu hari lebih cepat dibandingkan kondisi saat ini.\n\nManajemen menyebut ekspansi ini juga akan membuka ribuan lapangan kerja baru di masing-masing kota, mulai dari staf gudang hingga kurir pengiriman lokal.",
                'c1' => '#1c2c52', 'c2' => '#FBF8F3', 'pattern' => 'grid',
            ],
            [
                'cat' => 'bisnis', 'read' => 4,
                'title' => 'Insentif Pajak UMKM Diperpanjang hingga Akhir Tahun Depan',
                'sub' => 'UMKM',
                'excerpt' => 'Kebijakan ini diharapkan memacu pertumbuhan usaha kecil pascapemulihan ekonomi.',
                'content' => "Pemerintah memperpanjang masa berlaku insentif pajak bagi pelaku usaha mikro, kecil, dan menengah (UMKM) hingga akhir tahun depan. Kebijakan ini diharapkan dapat terus memacu pertumbuhan usaha kecil pascapemulihan ekonomi.\n\nInsentif berupa pengurangan tarif pajak final ini sebelumnya dijadwalkan berakhir pada tahun ini, namun diperpanjang setelah mempertimbangkan masukan dari asosiasi pengusaha yang menilai pelaku UMKM masih membutuhkan ruang napas fiskal.\n\nPemerintah juga tengah menyiapkan skema pendampingan digitalisasi pembukuan bagi UMKM agar lebih siap ketika insentif tersebut nantinya berakhir secara bertahap.",
                'c1' => '#2a3f75', 'c2' => '#C9A227', 'pattern' => 'circles',
            ],
            [
                'cat' => 'bisnis', 'read' => 5,
                'title' => 'Lowongan Kerja Sektor Digital Naik 22 Persen Tahun Ini',
                'sub' => 'Ketenagakerjaan',
                'excerpt' => 'Permintaan tertinggi datang dari posisi analis data dan pengembang perangkat lunak.',
                'content' => "Jumlah lowongan kerja di sektor digital tercatat naik 22 persen dibandingkan tahun lalu, menurut data terbaru platform pencarian kerja nasional. Permintaan tertinggi datang dari posisi analis data dan pengembang perangkat lunak.\n\nTren ini didorong oleh percepatan transformasi digital di berbagai sektor industri, mulai dari perbankan, ritel, hingga logistik, yang membutuhkan tenaga kerja dengan keahlian teknis khusus.\n\nSejumlah lembaga pelatihan merespons tren ini dengan membuka program percepatan keahlian digital bagi lulusan baru maupun pekerja yang ingin beralih karier ke sektor teknologi.",
                'c1' => '#0f1830', 'c2' => '#C9A227', 'pattern' => 'arrow',
            ],

            // ===================== OLAHRAGA =====================
            [
                'cat' => 'olahraga', 'read' => 3,
                'title' => 'Timnas U-20 Melaju ke Semifinal Usai Menang Dramatis 3–2',
                'sub' => 'Sepak Bola',
                'excerpt' => 'Gol penentu dicetak pada menit tambahan waktu setelah pertandingan berjalan ketat sejak babak pertama.',
                'content' => "Tim nasional Indonesia U-20 memastikan tiket ke babak semifinal usai menang dramatis dengan skor 3–2 atas tuan rumah. Gol penentu kemenangan dicetak pada menit tambahan waktu setelah pertandingan berjalan ketat sejak babak pertama.\n\nPelatih tim menyebut kemenangan ini hasil dari kerja keras dan mentalitas pantang menyerah para pemain muda, terutama setelah sempat tertinggal dua gol di babak kedua sebelum bangkit melakukan comeback.\n\nDi babak semifinal, timnas dijadwalkan menghadapi lawan yang juga tampil impresif sepanjang turnamen, dan pertandingan diprediksi berjalan sengit mengingat kedua tim sama-sama dalam performa terbaik.",
                'c1' => '#2C5F8A', 'c2' => '#FBF8F3', 'pattern' => 'circles',
            ],
            [
                'cat' => 'olahraga', 'read' => 4,
                'title' => 'Ganda Putra Indonesia Sabet Gelar Juara Turnamen Terbuka',
                'sub' => 'Bulutangkis',
                'excerpt' => 'Pasangan muda ini tampil konsisten sepanjang turnamen tanpa kehilangan satu set pun.',
                'content' => "Pasangan ganda putra Indonesia berhasil menyabet gelar juara pada turnamen bulutangkis terbuka setelah tampil konsisten sepanjang kompetisi tanpa kehilangan satu set pun hingga babak final.\n\nDi partai puncak, keduanya mengandalkan permainan net yang rapat serta pukulan smash keras untuk mematahkan perlawanan lawan yang merupakan unggulan turnamen.\n\nGelar ini menjadi modal penting bagi kedua pemain muda tersebut menjelang serangkaian turnamen internasional yang akan menentukan peringkat mereka di level dunia dalam beberapa bulan mendatang.",
                'c1' => '#1f4a6b', 'c2' => '#FBF8F3', 'pattern' => 'grid',
            ],
            [
                'cat' => 'olahraga', 'read' => 4,
                'title' => 'Liga Basket Nasional Musim Baru Resmi Dibuka Pekan Ini',
                'sub' => 'Basket',
                'excerpt' => 'Dua belas tim akan bersaing memperebutkan gelar juara dalam format kompetisi yang diperpanjang.',
                'content' => "Kompetisi Liga Basket Nasional musim baru resmi dibuka pekan ini, diikuti oleh dua belas tim yang akan bersaing memperebutkan gelar juara dalam format kompetisi yang diperpanjang dibandingkan musim sebelumnya.\n\nPanitia penyelenggara menyebut perpanjangan format bertujuan meningkatkan kualitas kompetisi sekaligus memberi lebih banyak jam terbang bagi pemain muda potensial.\n\nBeberapa tim mendatangkan pemain asing baru untuk memperkuat skuad, sementara sejumlah tim lain memilih fokus mengembangkan talenta lokal sebagai strategi jangka panjang.",
                'c1' => '#16344d', 'c2' => '#FBF8F3', 'pattern' => 'triangle',
            ],
            [
                'cat' => 'olahraga', 'read' => 3,
                'title' => 'Pembalap Muda Indonesia Naik Podium di Seri Asia',
                'sub' => 'Balap',
                'excerpt' => 'Hasil ini menjadi pencapaian terbaik sepanjang kariernya di ajang balap internasional.',
                'content' => "Pembalap muda Indonesia berhasil naik podium pada seri balap tingkat Asia, menjadi pencapaian terbaik sepanjang kariernya di ajang balap internasional. Ia finis di posisi kedua setelah persaingan ketat hingga lap terakhir.\n\nTim menyebut hasil ini merupakan buah dari persiapan intensif selama beberapa bulan terakhir, termasuk sesi latihan tambahan di sirkuit yang sama sebelum balapan resmi berlangsung.\n\nDengan hasil ini, sang pembalap kini menempati posisi tiga besar klasemen sementara dan berpeluang bersaing memperebutkan gelar juara seri musim ini.",
                'c1' => '#0d2536', 'c2' => '#C9A227', 'pattern' => 'wave',
            ],

            // ===================== LIFESTYLE =====================
            [
                'cat' => 'lifestyle', 'read' => 6,
                'title' => '5 Kebiasaan Pagi Sederhana yang Terbukti Meningkatkan Fokus Kerja',
                'sub' => 'Kesehatan',
                'excerpt' => 'Bukan soal bangun lebih pagi, tapi soal urutan aktivitas yang tepat sejak 10 menit pertama.',
                'content' => "Banyak orang percaya kunci produktivitas adalah bangun lebih pagi. Namun menurut sejumlah studi terbaru, yang lebih menentukan justru urutan aktivitas pada 10 menit pertama setelah bangun tidur.\n\nLima kebiasaan yang disarankan meliputi menghindari layar ponsel di lima menit pertama, minum air putih sebelum kopi, melakukan peregangan ringan, menuliskan tiga prioritas hari itu, dan mendapatkan paparan cahaya alami sesegera mungkin.\n\nPara ahli menekankan bahwa konsistensi lebih penting daripada kesempurnaan rutinitas — menjalankan dua atau tiga kebiasaan secara konsisten setiap hari terbukti lebih efektif dibandingkan mencoba seluruh rutinitas sekaligus namun tidak bertahan lama.",
                'c1' => '#1B4B43', 'c2' => '#FBF8F3', 'pattern' => 'circles',
            ],
            [
                'cat' => 'lifestyle', 'read' => 4,
                'title' => 'Desa Wisata Ini Jadi Favorit Baru Wisatawan Lokal Akhir Pekan',
                'sub' => 'Traveling',
                'excerpt' => 'Suasana asri dan aktivitas budaya jadi daya tarik utama bagi pengunjung dari kota besar.',
                'content' => "Sebuah desa wisata di kawasan pegunungan menjadi destinasi favorit baru wisatawan lokal untuk mengisi akhir pekan. Suasana asri, udara sejuk, dan beragam aktivitas budaya menjadi daya tarik utama bagi pengunjung yang datang dari kota-kota besar.\n\nPengunjung dapat mencoba berbagai kegiatan mulai dari belajar membatik, menanam padi di sawah terasering, hingga menikmati kuliner khas yang diolah langsung oleh warga setempat menggunakan resep turun-temurun.\n\nPengelola desa wisata menyebut jumlah kunjungan meningkat signifikan sejak dipromosikan melalui media sosial, dan kini tengah menyiapkan penambahan homestay untuk mengakomodasi lonjakan wisatawan pada musim liburan mendatang.",
                'c1' => '#2f6659', 'c2' => '#FBF8F3', 'pattern' => 'wave',
            ],
            [
                'cat' => 'lifestyle', 'read' => 5,
                'title' => 'Mengatur Waktu Layar Anak Tanpa Drama, Ini Triknya',
                'sub' => 'Keluarga',
                'excerpt' => 'Pendekatan konsisten dan kesepakatan bersama terbukti lebih efektif dibanding larangan total.',
                'content' => "Mengatur waktu layar anak kerap menjadi sumber perdebatan di rumah. Menurut psikolog anak, pendekatan yang konsisten dan melibatkan kesepakatan bersama terbukti jauh lebih efektif dibandingkan larangan total yang justru sering memicu perlawanan.\n\nBeberapa trik yang disarankan antara lain menetapkan jam bebas layar bersama seluruh anggota keluarga, bukan hanya untuk anak, serta menyediakan alternatif kegiatan menarik sebagai pengganti waktu di depan gawai.\n\nOrang tua juga disarankan menjelaskan alasan di balik aturan tersebut kepada anak sesuai usianya, alih-alih sekadar memberi batasan tanpa penjelasan yang membuat anak merasa dikekang.",
                'c1' => '#245349', 'c2' => '#FBF8F3', 'pattern' => 'dots',
            ],
            [
                'cat' => 'lifestyle', 'read' => 4,
                'title' => 'Metode Amplop Digital, Cara Milenial Atur Uang Bulanan',
                'sub' => 'Keuangan Pribadi',
                'excerpt' => 'Adaptasi metode klasik ini kini banyak dipakai lewat aplikasi dompet digital.',
                'content' => "Metode amplop, teknik mengatur keuangan klasik dengan memisahkan uang tunai ke dalam amplop sesuai kebutuhan, kini beradaptasi ke versi digital dan populer di kalangan milenial. Alih-alih uang tunai, kategori pengeluaran dipisahkan melalui fitur \"kantong\" di aplikasi dompet digital.\n\nMetode ini dinilai membantu menghindari pengeluaran berlebih karena setiap kategori memiliki batas nominal yang jelas, sehingga pengguna lebih sadar terhadap sisa anggaran yang tersedia sepanjang bulan.\n\nPerencana keuangan menyarankan agar pembagian kantong disesuaikan dengan prioritas masing-masing individu, dengan porsi minimal untuk tabungan dan dana darurat sebelum dialokasikan ke kebutuhan gaya hidup.",
                'c1' => '#3a7768', 'c2' => '#FBF8F3', 'pattern' => 'grid',
            ],
            [
                'cat' => 'lifestyle', 'read' => 3,
                'title' => 'Menata Ruang Tamu Sempit Agar Terasa Lebih Lapang',
                'sub' => 'Rumah',
                'excerpt' => 'Pemilihan warna dan penataan furnitur multifungsi jadi kunci utama.',
                'content' => "Ruang tamu berukuran terbatas bukan halangan untuk tetap terasa lapang dan nyaman. Desainer interior menyarankan pemilihan warna cat dinding yang cerah serta penataan furnitur multifungsi sebagai kunci utama.\n\nBeberapa trik sederhana meliputi penggunaan cermin untuk memantulkan cahaya, memilih sofa dengan kaki ramping agar lantai terlihat lebih luas, dan menghindari peletakan terlalu banyak dekorasi kecil yang membuat ruangan terkesan penuh.\n\nPenataan pencahayaan berlapis, mulai dari lampu utama hingga lampu meja, juga disebut mampu menciptakan kedalaman visual yang membuat ruang tamu sempit terasa lebih hidup dan lapang.",
                'c1' => '#1e453c', 'c2' => '#FBF8F3', 'pattern' => 'grid',
            ],
            [
                'cat' => 'lifestyle', 'read' => 4,
                'title' => 'Olahraga 15 Menit di Sela Kerja, Efektifkah untuk Stamina?',
                'sub' => 'Kebugaran',
                'excerpt' => 'Studi menunjukkan sesi latihan singkat namun rutin tetap memberi manfaat signifikan.',
                'content' => "Bagi pekerja kantoran yang kesulitan menyisihkan waktu berolahraga, sesi latihan singkat selama 15 menit di sela jam kerja disebut tetap memberi manfaat signifikan bagi stamina dan kebugaran tubuh, menurut sejumlah studi kesehatan olahraga.\n\nKuncinya terletak pada konsistensi dan intensitas latihan, bukan durasinya. Latihan interval singkat yang menggabungkan gerakan kardio ringan dan penguatan otot dasar terbukti mampu meningkatkan detak jantung secara efektif dalam waktu singkat.\n\nAhli kebugaran menyarankan menjadwalkan sesi olahraga singkat ini di jam yang sama setiap hari agar menjadi kebiasaan, misalnya saat jam istirahat siang sebelum makan.",
                'c1' => '#2a5b50', 'c2' => '#FBF8F3', 'pattern' => 'wave',
            ],

            // ===================== EDUKASI =====================
            [
                'cat' => 'edukasi', 'read' => 4,
                'title' => 'Program Beasiswa Guru Daerah 3T Dibuka Bulan Depan',
                'sub' => 'Sekolah',
                'excerpt' => 'Kuota tahun ini ditambah untuk menjangkau lebih banyak wilayah tertinggal dan terluar.',
                'content' => "Kementerian Pendidikan mengumumkan pembukaan pendaftaran program beasiswa bagi guru yang bertugas di daerah tertinggal, terdepan, dan terluar (3T) mulai bulan depan. Kuota tahun ini ditambah untuk menjangkau lebih banyak wilayah yang selama ini kekurangan tenaga pengajar berkualitas.\n\nProgram ini mencakup bantuan biaya pendidikan lanjutan, pelatihan metode pengajaran, serta insentif tambahan bagi guru yang bersedia mengabdi minimal tiga tahun di wilayah penempatan.\n\nPara calon pendaftar diminta menyiapkan portofolio pengajaran dan mengikuti seleksi wawancara yang akan digelar secara daring untuk menjangkau pelamar dari seluruh wilayah Indonesia.",
                'c1' => '#8A6D1D', 'c2' => '#FBF8F3', 'pattern' => 'triangle',
            ],
            [
                'cat' => 'edukasi', 'read' => 5,
                'title' => 'Jalur Mandiri PTN 2026 Terapkan Skema Penilaian Baru',
                'sub' => 'Perguruan Tinggi',
                'excerpt' => 'Calon mahasiswa diminta menyiapkan portofolio selain nilai ujian tertulis.',
                'content' => "Sejumlah perguruan tinggi negeri mengumumkan penerapan skema penilaian baru untuk jalur seleksi mandiri tahun 2026. Selain nilai ujian tertulis, calon mahasiswa kini juga diminta menyiapkan portofolio yang relevan dengan program studi pilihan.\n\nSkema ini bertujuan menilai calon mahasiswa secara lebih holistik, tidak hanya berdasarkan kemampuan akademik semata, tetapi juga minat dan pengalaman yang relevan dengan bidang yang akan ditekuni.\n\nPihak kampus menyediakan panduan teknis penyusunan portofolio melalui laman resmi masing-masing, dan mengimbau calon peserta mempersiapkan berkas jauh-jauh hari sebelum masa pendaftaran ditutup.",
                'c1' => '#a17f24', 'c2' => '#FBF8F3', 'pattern' => 'grid',
            ],
            [
                'cat' => 'edukasi', 'read' => 4,
                'title' => 'Studi: Membaca Bersuara Percepat Perkembangan Bahasa Anak',
                'sub' => 'Riset',
                'excerpt' => 'Peneliti menyarankan rutinitas 15 menit setiap malam sebelum tidur.',
                'content' => "Sebuah studi terbaru menemukan bahwa kebiasaan membaca bersuara kepada anak sejak usia dini terbukti mempercepat perkembangan kemampuan bahasa dan kosakata mereka dibandingkan anak yang jarang dibacakan cerita.\n\nPeneliti menyarankan orang tua meluangkan waktu sekitar 15 menit setiap malam sebelum tidur untuk membacakan buku cerita, sambil mengajak anak berinteraksi dengan bertanya tentang gambar atau alur cerita yang sedang dibacakan.\n\nSelain manfaat bahasa, rutinitas ini juga disebut memperkuat kedekatan emosional antara orang tua dan anak, serta membangun kebiasaan membaca sejak dini yang bermanfaat hingga usia sekolah.",
                'c1' => '#6f5717', 'c2' => '#FBF8F3', 'pattern' => 'circles',
            ],
            [
                'cat' => 'edukasi', 'read' => 3,
                'title' => 'Kelas Coding Gratis untuk Pelajar SMK Dibuka di 8 Kota',
                'sub' => 'Keterampilan',
                'excerpt' => 'Materi difokuskan pada pengembangan aplikasi sederhana untuk kebutuhan UMKM sekitar.',
                'content' => "Sebuah inisiatif pelatihan menyelenggarakan kelas coding gratis bagi pelajar SMK di delapan kota besar. Materi pelatihan difokuskan pada pengembangan aplikasi sederhana yang dapat langsung dimanfaatkan oleh UMKM di sekitar lokasi sekolah masing-masing.\n\nSelama pelatihan, peserta akan didampingi mentor dari industri teknologi untuk membangun proyek nyata, mulai dari aplikasi pencatatan penjualan hingga sistem pemesanan sederhana berbasis web.\n\nPenyelenggara berharap program ini dapat membuka wawasan karier di bidang teknologi bagi pelajar SMK sekaligus memberi manfaat langsung bagi pelaku usaha kecil di lingkungan sekitar mereka.",
                'c1' => '#8A6D1D', 'c2' => '#FBF8F3', 'pattern' => 'grid',
            ],

            // ===================== RESEP =====================
            [
                'cat' => 'resep', 'read' => 5,
                'title' => 'Gulai Ikan Kembung Rempah Kampung',
                'sub' => 'Resep Pilihan Hari Ini',
                'excerpt' => 'Kuah kuning gurih dengan rempah utuh yang disangrai dulu sebelum dihaluskan, membuat aromanya jauh lebih dalam dari gulai biasa.',
                'content' => "Gulai ikan kembung rempah kampung mengandalkan kuah kuning gurih dengan aroma rempah yang dalam. Rahasianya ada pada rempah utuh yang disangrai terlebih dahulu sebelum dihaluskan, sehingga minyak alaminya keluar dan aromanya jauh lebih kuat dibanding gulai biasa.\n\nGunakan ikan kembung segar agar dagingnya tetap padat setelah dimasak dalam kuah santan. Rebus santan dengan api kecil sambil terus diaduk agar tidak pecah, dan masukkan ikan setelah kuah benar-benar mendidih dan rempah tercampur rata.\n\nSajikan gulai ini hangat bersama nasi putih dan sambal terasi untuk pengalaman makan yang lebih lengkap khas masakan kampung.",
                'c1' => '#5a2413', 'c2' => '#A8461E', 'pattern' => 'circles',
                'recipe_minutes' => 35, 'recipe_servings' => 4, 'recipe_difficulty' => 'Mudah',
            ],
            [
                'cat' => 'resep', 'read' => 3,
                'title' => 'Pisang Goreng Krispi Tepung Beras',
                'sub' => 'Camilan',
                'excerpt' => 'Kunci teksturnya yang renyah tahan lama ada di perbandingan tepung beras dan tapioka.',
                'content' => "Pisang goreng krispi ini mengandalkan kombinasi tepung beras dan tapioka untuk menghasilkan tekstur renyah yang tahan lama meski sudah dingin. Perbandingan yang tepat antara kedua tepung ini menjadi kunci utama resep.\n\nCelupkan pisang ke dalam adonan yang sudah diberi sedikit air es agar hasil gorengan lebih ringan dan tidak berminyak. Goreng dengan minyak panas dan api sedang agar matang merata tanpa gosong di bagian luar.\n\nSajikan selagi hangat dengan taburan gula halus atau keju parut sesuai selera untuk camilan sore yang praktis.",
                'c1' => '#7a3318', 'c2' => '#A8461E', 'pattern' => 'circles',
                'recipe_minutes' => 20, 'recipe_servings' => 3, 'recipe_difficulty' => 'Mudah',
            ],
            [
                'cat' => 'resep', 'read' => 4,
                'title' => 'Bubur Ayam Kampung Kuah Kuning',
                'sub' => 'Sarapan',
                'excerpt' => 'Resep rumahan dengan taburan cakwang dan bawang goreng buatan sendiri.',
                'content' => "Bubur ayam kampung kuah kuning ini menggunakan kaldu ayam kampung yang dimasak lama agar rasanya lebih gurih alami tanpa perlu banyak penyedap tambahan. Kunyit segar memberikan warna kuning cerah yang khas pada kuahnya.\n\nMasak beras dengan kaldu ayam hingga benar-benar lembut, aduk sesekali agar tidak lengket di dasar panci. Suwir daging ayam kampung yang telah direbus sebagai pelengkap di atas bubur.\n\nLengkapi dengan taburan cakwang dan bawang goreng buatan sendiri, serta kecap manis dan sambal sesuai selera untuk sarapan hangat yang mengenyangkan.",
                'c1' => '#8a4322', 'c2' => '#A8461E', 'pattern' => 'circles',
                'recipe_minutes' => 45, 'recipe_servings' => 4, 'recipe_difficulty' => 'Sedang',
            ],
            [
                'cat' => 'resep', 'read' => 3,
                'title' => 'Sayur Lodeh Sederhana untuk Makan Siang Cepat',
                'sub' => 'Hidangan Utama',
                'excerpt' => 'Hanya butuh satu panci dan bahan yang biasanya sudah ada di dapur.',
                'content' => "Sayur lodeh sederhana ini cocok untuk makan siang cepat karena hanya membutuhkan satu panci dan bahan-bahan yang biasanya sudah tersedia di dapur, seperti labu siam, kacang panjang, dan tahu tempe.\n\nTumis bumbu halus hingga harum sebelum menuangkan santan agar aroma rempah lebih keluar dan kuah tidak berbau langu. Masukkan sayuran secara bertahap sesuai tingkat kematangan yang dibutuhkan.\n\nMasak dengan api kecil hingga santan mendidih perlahan dan sayuran empuk namun tidak terlalu lembek, lalu sajikan hangat bersama nasi putih.",
                'c1' => '#6e2c14', 'c2' => '#A8461E', 'pattern' => 'triangle',
                'recipe_minutes' => 30, 'recipe_servings' => 5, 'recipe_difficulty' => 'Mudah',
            ],

            // ===================== TEKNOLOGI / HIBURAN / OPINI (pelengkap navigasi) =====================
            [
                'cat' => 'teknologi', 'read' => 4,
                'title' => 'Adopsi Pembayaran Digital di Pasar Tradisional Terus Meningkat',
                'sub' => 'Teknologi',
                'excerpt' => 'Pedagang pasar kini makin terbiasa menerima pembayaran nontunai lewat kode QR.',
                'content' => "Adopsi pembayaran digital di pasar-pasar tradisional terus menunjukkan peningkatan dalam setahun terakhir. Semakin banyak pedagang yang menyediakan kode QR pembayaran di lapak mereka guna memudahkan transaksi pembeli.\n\nBank Indonesia mencatat pertumbuhan transaksi nontunai di sektor informal cukup signifikan, didorong oleh kampanye literasi keuangan digital yang menyasar langsung pedagang pasar di berbagai kota.\n\nSejumlah pedagang mengaku transaksi lebih praktis dan mengurangi risiko uang palsu, meski sebagian masih mempertahankan opsi tunai bagi pembeli yang belum terbiasa dengan metode pembayaran digital.",
                'c1' => '#14213D', 'c2' => '#C9A227', 'pattern' => 'grid',
            ],
            [
                'cat' => 'hiburan', 'read' => 3,
                'title' => 'Festival Musik Tahunan Umumkan Deretan Musisi Lokal Pengisi Panggung',
                'sub' => 'Musik',
                'excerpt' => 'Panitia menyebut tahun ini fokus mengangkat musisi independen dari luar Jawa.',
                'content' => "Panitia festival musik tahunan mengumumkan deretan musisi lokal yang akan mengisi panggung utama tahun ini. Berbeda dari tahun sebelumnya, penyelenggara menyebut fokus tahun ini adalah mengangkat musisi independen dari luar Pulau Jawa.\n\nSelain penampilan musik, festival juga akan diramaikan dengan bazar produk kreatif lokal dan area komunitas yang menampilkan karya seniman muda dari berbagai daerah.\n\nTiket festival dijual bertahap dengan harga early bird yang lebih terjangkau, dan panitia mengimbau pengunjung membeli tiket lebih awal mengingat kapasitas venue tahun ini dibatasi demi kenyamanan bersama.",
                'c1' => '#5B4B8A', 'c2' => '#C9A227', 'pattern' => 'dots',
            ],
            [
                'cat' => 'opini', 'read' => 5,
                'title' => 'Opini: Pentingnya Literasi Digital Sejak Bangku Sekolah Dasar',
                'sub' => 'Opini',
                'excerpt' => 'Menyiapkan generasi muda menghadapi dunia digital tidak bisa ditunda hingga jenjang lebih tinggi.',
                'content' => "Di tengah derasnya arus informasi digital, literasi digital semestinya tidak lagi diperkenalkan pada jenjang pendidikan tinggi, melainkan sejak bangku sekolah dasar. Anak-anak saat ini sudah terpapar gawai dan internet jauh sebelum mereka memahami cara menyaring informasi yang benar.\n\nKurikulum yang mengintegrasikan literasi digital sejak dini dapat membekali anak dengan kemampuan berpikir kritis terhadap informasi yang mereka konsumsi, sekaligus memahami etika berinteraksi di ruang digital.\n\nTanpa persiapan yang memadai sejak dini, generasi muda berisiko lebih rentan terhadap misinformasi dan dampak negatif penggunaan media sosial yang tidak terkontrol.",
                'c1' => '#8A6D1D', 'c2' => '#FBF8F3', 'pattern' => 'wave',
            ],
        ];
    }
}
