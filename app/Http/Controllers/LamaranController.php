<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LamaranController extends Controller
{
    /**
     * Tampilkan form pengisian lamaran & upload berkas
     */
    public function create($lowonganId)
    {
        $lowongan = Lowongan::where('id', $lowonganId)
            ->where('status', 'published')
            ->firstOrFail();

        // Cek duplikasi pendaftaran
        $exists = Lamaran::where('user_id', auth()->id())
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($exists) {
            return redirect()->route('pelamar.dashboard')
                ->with('error', 'Anda sudah mendaftar pada posisi ' . $lowongan->judul_posisi . '.');
        }

        return view('pelamar.lamar', compact('lowongan'));
    }

    /**
     * Simpan data lamaran & unggah berkas strict
     */
    public function store(Request $request, $lowonganId)
    {
        $lowongan = Lowongan::where('id', $lowonganId)
            ->where('status', 'published')
            ->firstOrFail();

        // Cek duplikasi pendaftaran
        $exists = Lamaran::where('user_id', auth()->id())
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($exists) {
            return redirect()->route('pelamar.dashboard')
                ->with('error', 'Anda sudah mendaftar pada posisi ini sebelumnya.');
        }

        // Strict Form & File Upload Validation
        $validated = $request->validate([
            'berkas_cv' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'berkas_ijazah' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'berkas_ktp' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'berkas_pendukung' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'berkas_cv.required' => 'Berkas CV (Curriculum Vitae) wajib diunggah.',
            'berkas_cv.mimes' => 'Berkas CV harus bertipe PDF.',
            'berkas_cv.max' => 'Ukuran berkas CV maksimal 2MB.',
            'berkas_ijazah.required' => 'Berkas Ijazah & Transkrip wajib diunggah.',
            'berkas_ijazah.mimes' => 'Berkas Ijazah harus bertipe PDF.',
            'berkas_ijazah.max' => 'Ukuran berkas Ijazah maksimal 2MB.',
            'berkas_ktp.required' => 'Scan KTP wajib diunggah.',
            'berkas_ktp.mimes' => 'Scan KTP harus berupa gambar (JPG/PNG) atau PDF.',
            'berkas_ktp.max' => 'Ukuran scan KTP maksimal 2MB.',
            'berkas_pendukung.mimes' => 'Dokumen pendukung harus bertipe PDF.',
            'berkas_pendukung.max' => 'Ukuran dokumen pendukung maksimal 5MB.',
        ]);

        // Generate Kode Pendaftaran Unik (Contoh: SARILING-202608-001)
        $countToday = Lamaran::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $kodePendaftaran = 'SARILING-' . now()->format('Ym') . '-' . sprintf('%03d', $countToday + 1);

        // Process File Uploads
        $pathCv = $this->uploadFile($request->file('berkas_cv'), 'cv', $kodePendaftaran);
        $pathIjazah = $this->uploadFile($request->file('berkas_ijazah'), 'ijazah', $kodePendaftaran);
        $pathKtp = $this->uploadFile($request->file('berkas_ktp'), 'ktp', $kodePendaftaran);
        
        $pathPendukung = null;
        if ($request->hasFile('berkas_pendukung')) {
            $pathPendukung = $this->uploadFile($request->file('berkas_pendukung'), 'pendukung', $kodePendaftaran);
        }

        // Create Lamaran Record
        Lamaran::create([
            'kode_pendaftaran' => $kodePendaftaran,
            'user_id' => auth()->id(),
            'lowongan_id' => $lowongan->id,
            'path_cv' => $pathCv,
            'path_ijazah' => $pathIjazah,
            'path_ktp' => $pathKtp,
            'path_pendukung' => $pathPendukung,
            'status_lamaran' => 'pending',
        ]);

        return redirect()->route('pelamar.dashboard')
            ->with('success', 'Lamaran Anda untuk posisi ' . $lowongan->judul_posisi . ' berhasil dikirim! Kode Pendaftaran: ' . $kodePendaftaran);
    }

    /**
     * Tampilkan detail lamaran pelamar
     */
    public function show($id)
    {
        $lamaran = Lamaran::with(['lowongan', 'jadwalSeleksi', 'hasilSeleksi'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('pelamar.detail_lamaran', compact('lamaran'));
    }

    /**
     * Helper simpan file ke storage public
     */
    private function uploadFile($file, string $type, string $kodePendaftaran): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = strtoupper($type) . '_' . str_replace('-', '_', $kodePendaftaran) . '_' . time() . '.' . $extension;
        return $file->storeAs("berkas_pelamar/{$type}", $filename, 'public');
    }
}
