<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use Illuminate\Support\Str;

class JobAdminController extends Controller
{
    /**
     * Tampilkan daftar lowongan pekerjaan di Admin Panel
     */
    public function index()
    {
        $lowongans = Lowongan::withCount('lamaran')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.lowongan.index', compact('lowongans'));
    }

    /**
     * Tampilkan form pembuatan lowongan baru
     */
    public function create()
    {
        return view('admin.lowongan.create');
    }

    /**
     * Simpan lowongan baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_posisi' => ['required', 'string', 'max:255'],
            'departemen' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kualifikasi' => ['required', 'string'],
            'kuota' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,published,closed'],
            'tanggal_buka' => ['required', 'date'],
            'tanggal_tutup' => ['required', 'date', 'after_or_equal:tanggal_buka'],
        ]);

        $validated['slug'] = Str::slug($validated['judul_posisi']) . '-' . Str::random(5);

        Lowongan::create($validated);

        return redirect()->route('admin.lowongan.index')
            ->with('success', 'Lowongan pekerjaan baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit lowongan
     */
    public function edit(Lowongan $lowongan)
    {
        return view('admin.lowongan.edit', compact('lowongan'));
    }

    /**
     * Perbarui data lowongan
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $validated = $request->validate([
            'judul_posisi' => ['required', 'string', 'max:255'],
            'departemen' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kualifikasi' => ['required', 'string'],
            'kuota' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,published,closed'],
            'tanggal_buka' => ['required', 'date'],
            'tanggal_tutup' => ['required', 'date', 'after_or_equal:tanggal_buka'],
        ]);

        if ($lowongan->judul_posisi !== $validated['judul_posisi']) {
            $validated['slug'] = Str::slug($validated['judul_posisi']) . '-' . Str::random(5);
        }

        $lowongan->update($validated);

        return redirect()->route('admin.lowongan.index')
            ->with('success', 'Data lowongan berhasil diperbarui.');
    }

    /**
     * Hapus lowongan
     */
    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')
            ->with('success', 'Lowongan pekerjaan telah dihapus.');
    }
}
