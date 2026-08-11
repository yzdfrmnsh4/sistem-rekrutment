<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// --- ROUTE PUBLIK ---
Route::get('/', function () {
    $lowongans = \App\Models\Lowongan::where('status', 'published')
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();
    return view('welcome', compact('lowongans'));
})->name('home');

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
});
