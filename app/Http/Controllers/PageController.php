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
                    'jabatan' => 'Pimpinan Redaksi',
                    'nama'    => ['Emanuel Dewata Oja'],
                ],
                [
                    'jabatan' => 'Redaktur Pelaksana',
                    'nama'    => ['Selvina'],
                ],
                [
                    'jabatan' => 'Redaktur / Editor',
                    'nama'    => ['Arnold Dhae'],
                ],
                [
                    'jabatan' => 'Reporter / Wartawan',
                    'nama'    => ['Ari Hutapea (Koordinator)', 'Tim Eduka Vision News'],
                ],
                [
                    'jabatan' => 'Teknologi & Multimedia — Head of IT / Product',
                    'nama'    => ['Royce Francis Maulana Maliq, S.Kom., S.Ds'],
                ],
                [
                    'jabatan' => 'Teknologi & Multimedia — Lead Programmer',
                    'nama'    => ['I Dewa Nyoman Mahayasa Wibawa, S.kom'],
                ],
            ];

                    $kontak = [
                        'perusahaan'       => 'PT Eduka Vision Media Nusantara',
                        'alamat'           => 'Jl. Kertapura IIIB No. 23B, Denpasar',
                        'email_redaksi'    => 'redaksi@edukavisionnews.id',
                        'email_kerja_sama' => 'kerjasama@edukavisionnews.id',
                        'telepon'          => '089601469218',
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
