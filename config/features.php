<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Fitur Like Berita (Tentative)
    |--------------------------------------------------------------------------
    | Saklar utama on/off fitur "Suka" di seluruh situs. Fitur ini masih
    | tentatif — set FEATURE_LIKES_ENABLED=false di .env untuk mematikannya
    | sementara (tombol & routenya otomatis nonaktif/404) tanpa perlu ubah
    | atau deploy ulang kode.
    */
    'likes_enabled' => env('FEATURE_LIKES_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Fitur Komentar Berita
    |--------------------------------------------------------------------------
    | Saklar utama on/off fitur komentar di seluruh situs. Selain saklar
    | global ini, tiap berita juga punya kolom "comments_enabled" sendiri
    | yang bisa diatur wartawan/editor langsung dari form tulis/edit berita —
    | jadi komentar bisa dimatikan per-berita meskipun saklar global aktif.
    */
    'comments_enabled' => env('FEATURE_COMMENTS_ENABLED', true),

];
