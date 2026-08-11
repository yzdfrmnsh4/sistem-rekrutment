<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\JadwalSeleksi;

class ScheduleAdminController extends Controller
{
    /**
     * Tampilkan daftar jadwal seleksi & form penetapan jadwal
     */
    public function index()
    {
        // Pelamar yang sudah lolos administrasi atau sedang dalam proses tes/wawancara
        $lamaransLolos = Lamaran::with(['user', 'lowongan'])
            ->whereIn('status_lamaran', ['lolos_administrasi', 'jadwal_tes'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $jadwals = JadwalSeleksi::with(['lamaran.user', 'lamaran.lowongan'])
            ->orderBy('tanggal_waktu', 'asc')
            ->get();

        return view('admin.jadwal.index', compact('lamaransLolos', 'jadwals'));
    }

    /**
     * Simpan jadwal seleksi baru untuk pelamar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lamaran_id' => ['required', 'exists:lamaran,id'],
            'tahap_seleksi' => ['required', 'in:tes_online,wawancara_hrd,wawancara_user,mcu'],
            'tanggal_waktu' => ['required', 'date'],
            'lokasi_atau_link' => ['required', 'string', 'max:550'],
            'instruksi_tambahan' => ['nullable', 'string', 'max:1000'],
        ], [
            'lamaran_id.required' => 'Pelamar wajib dipilih.',
            'tahap_seleksi.required' => 'Tahap seleksi wajib dipilih.',
            'tanggal_waktu.required' => 'Tanggal & Waktu pelaksanaan wajib diisi.',
            'lokasi_atau_link.required' => 'Lokasi atau link meeting/tes wajib diisi.',
        ]);

        JadwalSeleksi::create($validated);

        // Update status lamaran ke 'jadwal_tes'
        Lamaran::where('id', $validated['lamaran_id'])->update([
            'status_lamaran' => 'jadwal_tes'
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal seleksi berhasil ditetapkan dan diperbarui pada akun pelamar.');
    }

    /**
     * Hapus jadwal seleksi
     */
    public function destroy($id)
    {
        $jadwal = JadwalSeleksi::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal seleksi telah dihapus.');
    }
}
