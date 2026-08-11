# ⚙️ PLANNING BACKEND: DATABASE, ROUTES, CONTROLLERS & LOGIC
## Sistem Informasi Penerimaan Karyawan Berbasis Web - PT Sariling Aneka Energi

> **Strategi Eksekusi:** *Vibe Coding Approach* (Native Laravel 11 Architecture).
> **Fokus Backend:** Skema Database Relasional, Middleware RBAC Manual, Controller Standard, Penanganan Upload Berkas Strict, & DomPDF Report Engine.

---

## 📋 DAFTAR ISI
1. [Skema Database & Migration Detailed Design](#1-skema-database--migration-detailed-design)
2. [Custom Middleware & Arsitektur Route RBAC](#2-custom-middleware--arsitektur-route-rbac)
3. [Controller Breakdown & Business Logic](#3-controller-breakdown--business-logic)
4. [Penanganan Upload Berkas & Storage Strategy](#4-penanganan-upload-berkas--storage-strategy)
5. [State Machine Logic & Form Validation](#5-state-machine-logic--form-validation)
6. [Integrasi PDF Report Engine (DomPDF)](#6-integrasi-pdf-report-engine-dompdf)
7. [Instruksi AI Prompting (Vibe Coding Cheatsheet)](#7-instruksi-ai-prompting-vibe-coding-cheatsheet)

---

## 1. Skema Database & Migration Detailed Design

Menggunakan 5 tabel relasional terstruktur tanpa library pihak ketiga.

```
       +--------------------+            +--------------------+
       |       users        |            |      lowongan      |
       +--------------------+            +--------------------+
       | id (PK)            |            | id (PK)            |
       | name               |            | judul_posisi       |
       | email              |            | slug               |
       | password           |            | departemen         |
       | role (enum)        |            | kualifikasi        |
       | no_hp              |            | deskripsi          |
       | alamat             |            | kuota              |
       +--------------------+            | status (enum)      |
                 |                       +--------------------+
                 |                                 |
                 +----------------+----------------+
                                  |
                                  v
                        +--------------------+
                        |      lamaran       |
                        +--------------------+
                        | id (PK)            |
                        | user_id (FK)       |
                        | lowongan_id (FK)   |
                        | kode_pendaftaran   |
                        | path_cv            |
                        | path_ijazah        |
                        | path_ktp           |
                        | path_pendukung     |
                        | status_lamaran     |
                        | catatan_admin      |
                        +--------------------+
                                  |
            +---------------------+---------------------+
            |                                           |
            v                                           v
+------------------------+                 +------------------------+
|     jadwal_seleksi     |                 |     hasil_seleksi      |
+------------------------+                 +------------------------+
| id (PK)                |                 | id (PK)                |
| lamaran_id (FK)        |                 | lamaran_id (FK)        |
| tahap_seleksi (enum)   |                 | nilai_tes              |
| tanggal_waktu          |                 | nilai_wawancara        |
| lokasi_atau_link       |                 | keputusan_akhir (enum) |
| instruksi_tambahan     |                 | catatan_evaluasi       |
+------------------------+                 +------------------------+
```

### Code Migration Laravel 11 (Native PHP)

#### 1. Tabel `users` (`database/migrations/xxxx_create_users_table.php`)
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['admin', 'hrd', 'pelamar'])->default('pelamar');
    $table->string('no_hp', 20)->nullable();
    $table->text('alamat')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
```

#### 2. Tabel `lowongan` (`database/migrations/xxxx_create_lowongan_table.php`)
```php
Schema::create('lowongan', function (Blueprint $table) {
    $table->id();
    $table->string('judul_posisi');
    $table->string('slug')->unique();
    $table->string('departemen');
    $table->text('deskripsi');
    $table->text('kualifikasi');
    $table->integer('kuota')->default(1);
    $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
    $table->date('tanggal_buka');
    $table->date('tanggal_tutup');
    $table->timestamps();
});
```

#### 3. Tabel `lamaran` (`database/migrations/xxxx_create_lamaran_table.php`)
```php
Schema::create('lamaran', function (Blueprint $table) {
    $table->id();
    $table->string('kode_pendaftaran')->unique(); // Contoh: SARILING-202608-001
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('lowongan_id')->constrained('lowongan')->onDelete('cascade');
    $table->string('path_cv');
    $table->string('path_ijazah');
    $table->string('path_ktp');
    $table->string('path_pendukung')->nullable();
    $table->enum('status_lamaran', [
        'pending',           // Baru daftar
        'seleksi_berkas',    // Sedang ditinjau admin
        'lolos_administrasi',// Lolos berkas
        'jadwal_tes',        // Sudah ada jadwal tes/interview
        'diterima',          // Lolos seleksi akhir
        'ditolak'            // Tidak lolos
    ])->default('pending');
    $table->text('catatan_admin')->nullable();
    $table->timestamps();
});
```

#### 4. Tabel `jadwal_seleksi` (`database/migrations/xxxx_create_jadwal_seleksi_table.php`)
```php
Schema::create('jadwal_seleksi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('lamaran_id')->constrained('lamaran')->onDelete('cascade');
    $table->enum('tahap_seleksi', ['tes_online', 'wawancara_hrd', 'wawancara_user', 'mcu']);
    $table->dateTime('tanggal_waktu');
    $table->string('lokasi_atau_link');
    $table->text('instruksi_tambahan')->nullable();
    $table->timestamps();
});
```

#### 5. Tabel `hasil_seleksi` (`database/migrations/xxxx_create_hasil_seleksi_table.php`)
```php
Schema::create('hasil_seleksi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('lamaran_id')->constrained('lamaran')->onDelete('cascade');
    $table->decimal('nilai_tes', 5, 2)->nullable();
    $table->decimal('nilai_wawancara', 5, 2)->nullable();
    $table->enum('keputusan_akhir', ['diterima', 'ditolak', 'cadangan']);
    $table->text('catatan_evaluasi')->nullable();
    $table->date('tanggal_pengumuman');
    $table->timestamps();
});
```

---

## 2. Custom Middleware & Arsitektur Route RBAC

### A. Custom Middleware Class (`app/Http/Middleware/CheckRole.php`)
```php
namespace App\Http\Middleware;

import Closure;
import Illuminate\Http\Request;
import Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
```

### B. Registrasi Middleware di Laravel 11 (`bootstrap/app.php`)
```php
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

### C. Pemetaan Route Lengkap (`routes/web.php`)

```php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicJobController;
use App\Http\Controllers\PelamarDashboardController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JobAdminController;
use App\Http\Controllers\Admin\VerificationAdminController;
use App\Http\Controllers\Admin\ScheduleAdminController;
use App\Http\Controllers\Admin\ResultAdminController;
use App\Http\Controllers\Hrd\ReportHrdController;

// --- ROUTE PUBLIK ---
Route::get('/', [PublicJobController::class, 'index'])->name('home');
Route::get('/lowongan/{slug}', [PublicJobController::class, 'show'])->name('lowongan.detail');

// --- ROUTE AUTHENTICATION ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- ROUTE PELAMAR (ROLE: PELAMAR) ---
Route::middleware(['auth', 'role:pelamar'])->prefix('pelamar')->name('pelamar.')->group(function () {
    Route::get('/dashboard', [PelamarDashboardController::class, 'index'])->name('dashboard');
    Route::get('/lowongan/{lowongan}/lamar', [LamaranController::class, 'create'])->name('lamar.create');
    Route::post('/lowongan/{lowongan}/lamar', [LamaranController::class, 'store'])->name('lamar.store');
    Route::get('/lamaran/{lamaran}', [LamaranController::class, 'show'])->name('lamaran.detail');
});

// --- ROUTE ADMIN (ROLE: ADMIN) ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    
    // CRUD Lowongan
    Route::resource('lowongan', JobAdminController::class);
    
    // Verifikasi Berkas
    Route::get('/pelamar', [VerificationAdminController::class, 'index'])->name('pelamar.index');
    Route::get('/pelamar/{lamaran}', [VerificationAdminController::class, 'show'])->name('pelamar.show');
    Route::post('/pelamar/{lamaran}/status', [VerificationAdminController::class, 'updateStatus'])->name('pelamar.updateStatus');
    
    // Penjadwalan Tes
    Route::get('/jadwal', [ScheduleAdminController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal/{lamaran}', [ScheduleAdminController::class, 'store'])->name('jadwal.store');
    
    // Input Hasil
    Route::get('/hasil', [ResultAdminController::class, 'index'])->name('hasil.index');
    Route::post('/hasil/{lamaran}', [ResultAdminController::class, 'store'])->name('hasil.store');
});

// --- ROUTE HRD / PIMPINAN (ROLE: HRD, ADMIN) ---
Route::middleware(['auth', 'role:hrd,admin'])->prefix('hrd')->name('hrd.')->group(function () {
    Route::get('/dashboard', [ReportHrdController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [ReportHrdController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export-pdf', [ReportHrdController::class, 'exportPdf'])->name('laporan.pdf');
});
```

---

## 3. Controller Breakdown & Business Logic

### 1. `AuthController`
* `processLogin()`: Cek kredensial & redirect otomatis berdasarkan role (`admin` -> `/admin/dashboard`, `hrd` -> `/hrd/dashboard`, `pelamar` -> `/pelamar/dashboard`).
* `processRegister()`: Buat akun pelamar baru dengan default role `pelamar`.

### 2. `LamaranController` (Proses Pendaftaran Pelamar)
* **Pencegahan Duplikasi:**
  ```php
  $exists = Lamaran::where('user_id', auth()->id())
      ->where('lowongan_id', $lowongan->id)
      ->exists();
  if ($exists) {
      return back()->with('error', 'Anda sudah mendaftar pada lowongan ini.');
  }
  ```
* **Penyimpanan Data & Upload:**
  Mengunggah file, menyimpan data ke database, dan membuat Kode Registrasi otomatis (`SARILING-YYYYMM-XXXX`).

### 3. `VerificationAdminController` (Verifikasi Admin)
* Menampilkan daftar pelamar, memfasilitasi preview berkas PDF di browser, dan mengubah `status_lamaran` menjadi `lolos_administrasi` atau `ditolak` disertai catatan.

---

## 4. Penanganan Upload Berkas & Storage Strategy

### A. Struktur Folder Disk Public
```
storage/app/public/
└── berkas_pelamar/
    ├── cv/
    │   └── CV_SARIL-A1B2C3_1723400000.pdf
    ├── ijazah/
    │   └── IJAZAH_SARIL-A1B2C3_1723400000.pdf
    └── ktp/
        └── KTP_SARIL-A1B2C3_1723400000.jpg
```

### B. Potongan Kode Handling Upload pada Controller
```php
private function uploadFile($file, string $type, string $kodePendaftaran): string
{
    $extension = $file->getClientOriginalExtension();
    $filename = strtoupper($type) . '_' . $kodePendaftaran . '_' . time() . '.' . $extension;
    return $file->storeAs("berkas_pelamar/{$type}", $filename, 'public');
}
```

### C. Rule Validasi File Strict
```php
$request->validate([
    'berkas_cv' => 'required|file|mimes:pdf|max:2048',       // Maks 2MB PDF
    'berkas_ijazah' => 'required|file|mimes:pdf|max:2048',   // Maks 2MB PDF
    'berkas_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Maks 2MB Image/PDF
    'berkas_pendukung' => 'nullable|file|mimes:pdf|max:5120', // Maks 5MB PDF
]);
```

---

## 5. State Machine Logic & Form Validation

### Transisi Status Seleksi (*State Logic*)
1. **`pending`**: Status default saat pelamar baru mengirimkan form.
2. **`seleksi_berkas`**: Admin sedang meninjau dokumen.
3. **`lolos_administrasi`**: Admin menyetujui keabsahan berkas pelamar.
4. **`jadwal_tes`**: Admin telah menetapkan tanggal & tempat tes/interview.
5. **`diterima` / `ditolak`**: Keputusan akhir hasil nilai tes dan seleksi.

---

## 6. Integrasi PDF Report Engine (DomPDF)

### Sample Implementation pada `ReportHrdController`
```php
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Lamaran;

public function exportPdf(Request $request)
{
    $lowonganId = $request->input('lowongan_id');
    
    $lamaranQuery = Lamaran::with(['user', 'lowongan', 'hasilSeleksi'])
        ->where('status_lamaran', 'diterima');

    if ($lowonganId) {
        $lamaranQuery->where('lowongan_id', $lowonganId);
    }

    $dataPelamar = $lamaranQuery->get();

    $pdf = Pdf::loadView('pdf.laporan_rekapitulasi', [
        'dataPelamar' => $dataPelamar,
        'tanggalCetak' => now()->format('d F Y')
    ])->setPaper('a4', 'landscape');

    return $pdf->download('Laporan_Rekapitulasi_Pelamar_Lolos.pdf');
}
```

---

## 7. Instruksi AI Prompting (Vibe Coding Cheatsheet)

Saat mengerjakan kode backend ini menggunakan AI (Cursor / Claude Code / ChatGPT / Windsurf), jalankan prompt berikut secara berurutan:

### Prompt 1: Migration & Custom RBAC Middleware
> "Buatkan migration Laravel 11 untuk 5 tabel (`users`, `lowongan`, `lamaran`, `jadwal_seleksi`, `hasil_seleksi`) sesuai skema di PLANNING_BACKEND.md. Buat juga custom middleware `CheckRole` dan daftarkan aliasnya di `bootstrap/app.php` tanpa menggunakan library Spatie."

### Prompt 2: Manual Auth Controller & Routes
> "Buatkan `AuthController` native Laravel 11 untuk penanganan Login, Register (default role pelamar), dan Logout. Lengkapi dengan logika redirect halaman dashboard sesuai role user."

### Prompt 3: Lamaran Controller & File Upload Strategy
> "Buatkan `LamaranController` di Laravel 11 untuk menangani pendaftaran pelamar. Tambahkan pemeriksaan agar pelamar tidak bisa mendaftar dua kali di lowongan yang sama, simpan berkas CV/Ijazah/KTP ke folder `storage/app/public/berkas_pelamar`, dan hasilkan kode registrasi unik otomatis."

### Prompt 4: Custom Admin Controller & DomPDF
> "Buatkan `VerificationAdminController` untuk meninjau dan mengubah status lamaran, serta `ReportHrdController` yang menggunakan `barryvdh/laravel-dompdf` untuk mengeksport data pelamar yang lolos ke file PDF berukuran A4 Landscape."

---
*Dokumen PLANNING_BACKEND.md ini adalah bagian 2 dari 2 berkas perencanaan proyek.*
