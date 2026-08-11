<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;

class PublicJobController extends Controller
{
    /**
     * Tampilkan daftar lowongan publik pada beranda
     */
    public function index()
    {
        $lowongans = Lowongan::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('lowongans'));
    }

    /**
     * Tampilkan detail spesifik lowongan pekerjaan
     */
    public function show($slug)
    {
        $lowongan = Lowongan::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $sudahMelamar = false;
        if (auth()->check() && auth()->user()->isPelamar()) {
            $sudahMelamar = \App\Models\Lamaran::where('user_id', auth()->id())
                ->where('lowongan_id', $lowongan->id)
                ->exists();
        }

        return view('lowongan.show', compact('lowongan', 'sudahMelamar'));
    }
}
