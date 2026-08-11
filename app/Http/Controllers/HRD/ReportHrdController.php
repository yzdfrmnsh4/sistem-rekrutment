<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Lowongan;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportHrdController extends Controller
{
    /**
     * Tampilkan halaman modul laporan rekapitulasi HRD
     */
    public function index(Request $request)
    {
        $query = Lamaran::with(['user', 'lowongan', 'hasilSeleksi'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->lowongan_id);
        }

        if ($request->filled('status')) {
            $query->where('status_lamaran', $request->status);
        } else {
            // Default tampilkan pelamar yang sudah diproses (diterima, ditolak, lolos)
            $query->whereIn('status_lamaran', ['diterima', 'ditolak', 'lolos_administrasi', 'jadwal_tes']);
        }

        $lamarans = $query->get();
        $lowongans = Lowongan::all();

        return view('hrd.laporan', compact('lamarans', 'lowongans'));
    }

    /**
     * Generate & Unduh Laporan Rekapitulasi PDF menggunakan Barryvdh DomPDF
     */
    public function exportPdf(Request $request)
    {
        $query = Lamaran::with(['user', 'lowongan', 'hasilSeleksi', 'jadwalSeleksi'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->lowongan_id);
        }

        if ($request->filled('status')) {
            $query->where('status_lamaran', $request->status);
        } else {
            $query->whereIn('status_lamaran', ['diterima', 'ditolak', 'lolos_administrasi', 'jadwal_tes']);
        }

        $lamarans = $query->get();
        $selectedLowongan = $request->filled('lowongan_id') ? Lowongan::find($request->lowongan_id) : null;
        $tanggalCetak = now()->format('d F Y, H:i');

        // Load PDF View dengan DomPDF
        $pdf = Pdf::loadView('hrd.laporan_pdf', compact('lamarans', 'selectedLowongan', 'tanggalCetak'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Rekapitulasi-Rekrutmen-PT-Sariling-' . date('Ymd-His') . '.pdf');
    }
}
