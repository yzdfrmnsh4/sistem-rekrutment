<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\HasilSeleksi;

class ScoringAdminController extends Controller
{
    /**
     * Tampilkan daftar pelamar yang siap diinput nilai & keputusan akhir
     */
    public function index()
    {
        $lamarans = Lamaran::with(['user', 'lowongan', 'jadwalSeleksi', 'hasilSeleksi'])
            ->whereIn('status_lamaran', ['jadwal_tes', 'lolos_administrasi', 'diterima', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.nilai.index', compact('lamarans'));
    }

    /**
     * Simpan / Perbarui nilai tes, wawancara, & keputusan akhir pelamar
     */
    public function store(Request $request, $lamaranId)
    {
        $lamaran = Lamaran::findOrFail($lamaranId);

        $validated = $request->validate([
            'nilai_tes' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_wawancara' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'keputusan_akhir' => ['required', 'in:diterima,ditolak,cadangan'],
            'catatan_evaluasi' => ['nullable', 'string', 'max:1000'],
            'tanggal_pengumuman' => ['required', 'date'],
        ], [
            'keputusan_akhir.required' => 'Keputusan akhir pelamar wajib dipilih.',
            'tanggal_pengumuman.required' => 'Tanggal pengumuman wajib ditentukan.',
        ]);

        HasilSeleksi::updateOrCreate(
            ['lamaran_id' => $lamaran->id],
            [
                'nilai_tes' => $validated['nilai_tes'],
                'nilai_wawancara' => $validated['nilai_wawancara'],
                'keputusan_akhir' => $validated['keputusan_akhir'],
                'catatan_evaluasi' => $validated['catatan_evaluasi'],
                'tanggal_pengumuman' => $validated['tanggal_pengumuman'],
            ]
        );

        // Update status_lamaran utama
        $statusUtama = ($validated['keputusan_akhir'] === 'diterima') ? 'diterima' : (($validated['keputusan_akhir'] === 'ditolak') ? 'ditolak' : 'jadwal_tes');
        $lamaran->update([
            'status_lamaran' => $statusUtama
        ]);

        return redirect()->route('admin.nilai.index')
            ->with('success', 'Penilaian dan Keputusan Akhir untuk pelamar ' . $lamaran->user->name . ' telah berhasil disimpan.');
    }
}
