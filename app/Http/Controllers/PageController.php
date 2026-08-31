<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

/**
 * Halaman statis: Tentang Kami, Redaksi, dan Pedoman Media Siber.
 *
 * Catatan: data tim redaksi, alamat, dan kontak di sini adalah data DUMMY
 * (fiktif) untuk keperluan tampilan situs EdukaVisionNews — bukan data
 * organisasi lain — sehingga bebas disesuaikan tanpa masalah hak cipta.
 */
class PageController extends Controller
{
    /**
     * /tentang-kami — profil singkat media.
     */
    public function about(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('pages.tentang-kami', compact('categories'));
    }

    /**
     * /redaksi — susunan redaksi (data dummy).
     */
    public function redaksi(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        $struktur = [
            [
                'jabatan' => 'Pemimpin Redaksi / Penanggung Jawab',
                'nama' => ['Arya Wicaksana'],
            ],
            [
                'jabatan' => 'Redaktur Eksekutif',
                'nama' => ['Nadia Puspitasari'],
            ],
            [
                'jabatan' => 'Redaktur Pelaksana',
                'nama' => ['Bimo Aditya', 'Kirana Larasati', 'Fajar Nugroho'],
            ],
            [
                'jabatan' => 'Desk Nasional',
                'nama' => ['Rangga Saputra', 'Melati Anggraini', 'Yusuf Hakim', 'Dewi Anjani'],
            ],
            [
                'jabatan' => 'Desk Edukasi',
                'nama' => ['Citra Maheswari', 'Agung Prasetyo'],
            ],
            [
                'jabatan' => 'Desk Bisnis & Ekonomi',
                'nama' => ['Reza Firmansyah', 'Salsabila Putri'],
            ],
            [
                'jabatan' => 'Desk Olahraga',
                'nama' => ['Bagas Kurniawan', 'Intan Permatasari'],
            ],
            [
                'jabatan' => 'Desk Lifestyle & Kuliner',
                'nama' => ['Wulan Setiawati', 'Dimas Ramadhan'],
            ],
            [
                'jabatan' => 'Cek Fakta',
                'nama' => ['Hana Oktavia', 'Farhan Ardiansyah'],
            ],
            [
                'jabatan' => 'Fotografer',
                'nama' => ['Galih Pratama', 'Sari Wulandari'],
            ],
            [
                'jabatan' => 'Tim Multimedia & Media Sosial',
                'nama' => ['Putri Ayuningtyas', 'Alif Rahmatullah', 'Nia Kusumawati'],
            ],
            [
                'jabatan' => 'Sekretaris Redaksi',
                'nama' => ['Eriza Gatmasari'],
            ],
            [
                'jabatan' => 'Teknologi & Produk (IT / Developer) — Head of IT / Product',
                'nama' => ['Royce Francis Maulana Maliq, S.Kom., S.Ds'],
            ],
            [
                'jabatan' => 'Teknologi & Produk (IT / Developer) — Lead Programmer',
                'nama' => ['Mahayasa Wibawa'],
            ],
            [
                'jabatan' => 'Teknologi & Produk (IT / Developer) — Web Developer / Software Engineer',
                'nama' => ['Nama-nama Staff IT'],
            ],
        ];

        $kontak = [
            'perusahaan' => 'PT Eduka Vision Media Nusantara',
            'alamat' => 'Jl. Raya Legian No. 88, Kuta, Badung, Bali 80361, Indonesia',
            'email_redaksi' => 'redaksi@edukavisionnews.id',
            'email_kerja_sama' => 'kerjasama@edukavisionnews.id',
            'telepon' => '(0361) 700-1234',
        ];

        return view('pages.redaksi', compact('categories', 'struktur', 'kontak'));
    }

    /**
     * /pedoman-media-siber — Pedoman Pemberitaan Media Siber (Dewan Pers).
     */
    public function pedomanMediaSiber(): View
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('pages.pedoman-media-siber', compact('categories'));
    }
}
