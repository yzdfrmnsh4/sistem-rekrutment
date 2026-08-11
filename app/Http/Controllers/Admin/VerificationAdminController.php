<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Lowongan;

class VerificationAdminController extends Controller
{
    /**
     * Tampilkan daftar seluruh berkas lamaran pelamar untuk diverifikasi admin
     */
    public function index(Request $request)
    {
        $query = Lamaran::with(['user', 'lowongan'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status lamaran
        if ($request->filled('status')) {
            $query->where('status_lamaran', $request->status);
        }

        // Filter berdasarkan lowongan
        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->lowongan_id);
        }

        // Search berdasarkan nama pelamar / kode pendaftaran
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_pendaftaran', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $lamarans = $query->paginate(15)->withQueryString();
        $lowongans = Lowongan::all();

        return view('admin.pelamar.index', compact('lamarans', 'lowongans'));
    }

    /**
     * Tampilkan detail dokumen & profil pelamar spesifik untuk peninjauan berkas
     */
    public function show($id)
    {
        $lamaran = Lamaran::with(['user', 'lowongan', 'jadwalSeleksi', 'hasilSeleksi'])
            ->findOrFail($id);

        return view('admin.pelamar.show', compact('lamaran'));
    }

    /**
     * Update status verifikasi berkas lamaran (Lolos Administrasi / Ditolak / Seleksi Berkas)
     */
    public function updateStatus(Request $request, $id)
    {
        $lamaran = Lamaran::findOrFail($id);

        $validated = $request->validate([
            'status_lamaran' => ['required', 'in:pending,seleksi_berkas,lolos_administrasi,jadwal_tes,diterima,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ]);

        $lamaran->update([
            'status_lamaran' => $validated['status_lamaran'],
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()->route('admin.pelamar.show', $lamaran->id)
            ->with('success', 'Status verifikasi lamaran pelamar berhasil diperbarui menjadi: ' . strtoupper(str_replace('_', ' ', $validated['status_lamaran'])));
    }
}
