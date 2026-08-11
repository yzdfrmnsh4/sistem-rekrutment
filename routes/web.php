<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\Admin\JobAdminController;
use App\Http\Controllers\Admin\VerificationAdminController;
use App\Http\Controllers\Admin\ScheduleAdminController;
use App\Http\Controllers\Admin\ScoringAdminController;
use App\Http\Controllers\HRD\ReportHrdController;

// --- ROUTE PUBLIK ---
Route::get('/', [PublicJobController::class, 'index'])->name('home');
Route::get('/lowongan/{slug}', [PublicJobController::class, 'show'])->name('lowongan.detail');

// --- ROUTE AUTHENTICATION ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- ROUTE PELAMAR (ROLE: PELAMAR) ---
Route::middleware(['auth', 'role:pelamar'])->prefix('pelamar')->name('pelamar.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $lamarans = \App\Models\Lamaran::with(['lowongan', 'jadwalSeleksi', 'hasilSeleksi'])
            ->where('user_id', $user->id)
            ->get();
        return view('pelamar.dashboard', compact('user', 'lamarans'));
    })->name('dashboard');

    Route::get('/lamar/{lowongan_id}', [LamaranController::class, 'create'])->name('lamar.create');
    Route::post('/lamar/{lowongan_id}', [LamaranController::class, 'store'])->name('lamar.store');
    Route::get('/lamaran/{id}', [LamaranController::class, 'show'])->name('lamaran.detail');
});

// --- ROUTE ADMIN (ROLE: ADMIN) ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalLowongan = \App\Models\Lowongan::count();
        $totalPelamar = \App\Models\User::where('role', 'pelamar')->count();
        $totalLamaran = \App\Models\Lamaran::count();
        $lamaranPending = \App\Models\Lamaran::where('status_lamaran', 'pending')->count();
        return view('admin.dashboard', compact('totalLowongan', 'totalPelamar', 'totalLamaran', 'lamaranPending'));
    })->name('dashboard');

    // CRUD Lowongan Pekerjaan
    Route::resource('lowongan', JobAdminController::class);

    // Verifikasi Berkas Pelamar
    Route::get('/pelamar', [VerificationAdminController::class, 'index'])->name('pelamar.index');
    Route::get('/pelamar/{id}', [VerificationAdminController::class, 'show'])->name('pelamar.show');
    Route::patch('/pelamar/{id}/status', [VerificationAdminController::class, 'updateStatus'])->name('pelamar.updateStatus');

    // Penjadwalan Seleksi & Wawancara
    Route::get('/jadwal', [ScheduleAdminController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [ScheduleAdminController::class, 'store'])->name('jadwal.store');
    Route::delete('/jadwal/{id}', [ScheduleAdminController::class, 'destroy'])->name('jadwal.destroy');

    // Input Nilai & Keputusan Akhir
    Route::get('/nilai', [ScoringAdminController::class, 'index'])->name('nilai.index');
    Route::post('/nilai/{lamaran_id}', [ScoringAdminController::class, 'store'])->name('nilai.store');
});

// --- ROUTE HRD (ROLE: HRD, ADMIN) ---
Route::middleware(['auth', 'role:hrd,admin'])->prefix('hrd')->name('hrd.')->group(function () {
    Route::get('/dashboard', function () {
        $totalLamaran = \App\Models\Lamaran::count();
        $pelamarDiterima = \App\Models\Lamaran::where('status_lamaran', 'diterima')->count();
        $pelamarDitolak = \App\Models\Lamaran::where('status_lamaran', 'ditolak')->count();
        $lowonganAktif = \App\Models\Lowongan::where('status', 'published')->count();
        return view('hrd.dashboard', compact('totalLamaran', 'pelamarDiterima', 'pelamarDitolak', 'lowonganAktif'));
    })->name('dashboard');

    // Modul Laporan Rekapitulasi & Export PDF (DomPDF)
    Route::get('/laporan', [ReportHrdController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [ReportHrdController::class, 'exportPdf'])->name('laporan.exportPdf');
});
