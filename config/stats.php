<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Zona waktu rekap statistik
    |--------------------------------------------------------------------------
    | Dipakai untuk menentukan "hari ini" saat mencatat views/share ke tabel
    | article_stats, serta batas awal/akhir minggu, bulan, dan tahun pada
    | Laporan Statistik. Sengaja dipisah dari APP_TIMEZONE supaya jam yang
    | sudah tersimpan di tabel lain tidak ikut bergeser.
    |
    | Contoh nilai: Asia/Jakarta (WIB), Asia/Makassar (WITA), Asia/Jayapura (WIT)
    */
    'timezone' => env('STATS_TIMEZONE', 'Asia/Makassar'),

];
