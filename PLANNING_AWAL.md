# 🛠️ PLANNING AWAL: SET UP, CONFIGURATION & UI ARCHITECTURE
## Sistem Informasi Penerimaan Karyawan Berbasis Web - PT Sariling Aneka Energi

> **Strategi Eksekusi:** *Vibe Coding Approach* (Custom Native Laravel 11 + Tailwind CSS v3).
> **Prinsip Utama:** Murni menggunakan Blade Template, Custom Middleware Auth/RBAC, dan Alpine.js/Vanilla JS tanpa library `filament`, `spatie/laravel-permission`, maupun `livewire`.

---

## 📋 DAFTAR ISI
1. [Ringkasan Proyek & Ketentuan Tech Stack](#1-ringkasan-proyek--ketentuan-tech-stack)
2. [Environment & Setup Project Blueprint](#2-environment--setup-project-blueprint)
3. [Konfigurasi Tailwind CSS v3 & Frontend Tools](#3-konfigurasi-tailwind-css-v3--frontend-tools)
4. [Strategi RBAC Manual (Tanpa Spatie Permission)](#4-strategi-rbac-manual-tanpa-spatie-permission)
5. [Peta Halaman (Sitemap) & Wireframe UI Layout](#5-peta-halaman-sitemap--wireframe-ui-layout)
6. [Roadmap Tahapan Eksekusi Vibe Coding](#6-roadmap-tahapan-eksekusi-vibe-coding)

---

## 1. Ringkasan Proyek & Ketentuan Tech Stack

Proyek ini adalah platform digital rekrutmen karyawan untuk **PT Sariling Aneka Energi Tangerang**. Sistem dirancang responsif, modern, dan aman dengan **budget & waktu minimal** menggunakan metode **Vibe Coding** yang mengandalkan kemudahan struktur Laravel 11.

### Matrix Teknologi yang Digunakan:

| Komponen | Teknologi / Library | Keterangan & Alasan |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 11 (PHP >= 8.2)** | Framework utama dengan arsitektur MVC yang bersih dan ramah AI code generator. |
| **Styling Engine** | **Tailwind CSS v3** | Utilitas CSS v3 (`^3.4`) untuk pembuatan layout responsif dan bersih secara presisi. |
| **Interaktivitas UI** | **Alpine.js v3 / Vanilla JS** | Pengganti Livewire. Ringan untuk modal, dropdown, preview file, dan interaksi tab. |
| **Icon Set** | **Heroicons / Lucide Icons** | SVG Icon set tanpa beban library berat. |
| **PDF Engine** | **Barryvdh DomPDF** | Engine cetak laporan PDF rekapitulasi data pelamar & surat panggilan tes. |
| **Role & Permission** | **Custom Enum + Middleware Manual** | Mengatur akses `admin`, `hrd`, `pelamar` langsung via kolom database & class Middleware. |
| **Admin & HRD Panel** | **Custom Blade Layout** | Dibuat manual menggunakan komponen Blade reuseable (Sidebar, Topbar, Data Table). |

---

## 2. Environment & Setup Project Blueprint

### A. Persyaratan Sistem
* **PHP:** Minimal versi 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `gd`).
* **Composer:** Versi 2.x.
* **Node.js & NPM:** Node.js LTS v20+.
* **Database Engine:** MySQL 8.0+ / MariaDB 10.4+.

### B. Perintah Inisialisasi Proyek (Terminal Execute)

```bash
# 1. Buat proyek Laravel 11 baru
composer create-project laravel/laravel e-recruitment-sariling

# 2. Masuk ke direktori proyek
cd e-recruitment-sariling

# 3. Install DOMPDF untuk laporan PDF
composer require barryvdh/laravel-dompdf

# 4. Install Tailwind CSS v3 & Vite Tools
npm install -D tailwindcss@^3.4 postcss autoprefixer @tailwindcss/forms
npx tailwindcss init -p

# 5. Install Alpine.js untuk interaktivitas UI manual
npm install alpinejs

# 6. Buat Symbolic Link Storage
php artisan storage:link
```

### C. File Konfigurasi Environment (`.env`)

```ini
APP_NAME="E-Recruitment PT Sariling Aneka Energi"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_recruitment_sariling
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
MAX_FILE_SIZE_KB=5120
```

---

## 3. Konfigurasi Tailwind CSS v3 & Frontend Tools

### A. Konfigurasi `tailwind.config.js`
```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#f0f7ff',
          100: '#e0effe',
          600: '#0284c7', // Warna utama PT Sariling
          700: '#0369a1',
          900: '#0c4a6e',
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
```

### B. Konfigurasi `resources/css/app.css`
```css
@tailwindcss base;
@tailwindcss components;
@tailwindcss utilities;

[x-cloak] { display: none !important; }
```

### C. Inisialisasi Alpine.js pada `resources/js/app.js`
```javascript
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
```

---

## 4. Strategi RBAC Manual (Tanpa Spatie Permission)

Untuk menjaga sistem tetap ringan tanpa dependency Spatie, pengelolaan role menggunakan pendekatan native:

1. **Kolom Database:** Tambahkan kolom `role` bertipe `ENUM('admin', 'hrd', 'pelamar')` pada tabel `users`.
2. **Custom Middleware:**
   * `CheckRole`: Memeriksa apakah user yang terautentikasi memiliki role yang sesuai dengan grup route.
3. **Blade Helper Directive:**
   * Pembuatan custom Blade IF directive atau method sederhana `$user->hasRole('admin')` pada Model `User`.

---

## 5. Peta Halaman (Sitemap) & Wireframe UI Layout

Sistem dibagi menjadi 3 zona layout utama menggunakan **Blade Components & Layouts**:

```
                                +------------------------------------+
                                |    SISTEM REKRUTMEN PT SARILING   |
                                +------------------------------------+
                                                  |
        +-----------------------------------------+-----------------------------------------+
        |                                         |                                         |
        v                                         v                                         v
+-------------------+                     +-------------------+                     +-------------------+
|  LAYOUT: PELAMAR  |                     |   LAYOUT: ADMIN   |                     |    LAYOUT: HRD    |
+-------------------+                     +-------------------+                     +-------------------+
| Navbar Public     |                     | Topbar + Sidebar  |                     | Topbar + Sidebar  |
| - Home / Lowongan |                     | - Dashboard Stat  |                     | - Dashboard Stat  |
| - Detail Lowongan |                     | - Kelola Lowongan |                     | - Laporan Rekap   |
| - Login / Register|                     | - Data Pelamar    |                     | - Export PDF/XLS  |
| Dashboard Pelamar |                     | - Verifikasi CV   |                     | - Grafik Pelamar  |
| - Form Lamar      |                     | - Penjadwalan Tes |                     +-------------------+
| - Track Timeline  |                     | - Input Nilai     |
+-------------------+                     +-------------------+
```

### Detail Rincian Halaman Per Zona:

#### 1. Zona Public & Candidate Portal (`layouts/app.blade.php`)
* `GET /` : **Landing Page** (Hero section, Tentang Perusahaan, List Card Lowongan Aktif dengan Search/Filter, Footer).
* `GET /lowongan/{slug}` : **Detail Job** (Kualifikasi, Deskripsi, Syarat Berkas, Tombol "Lamar Sekarang").
* `GET /login` & `GET /register` : **Auth Pelamar** (Form login & registrasi dengan Tailwind UI).
* `GET /pelamar/dashboard` : **Dashboard Pelamar** (Ringkasan lamaran yang sedang berjalan).
* `GET /pelamar/lamar/{lowongan_id}` : **Form Melamar** (Form isian riwayat + input file upload CV, Ijazah, KTP dengan Alpine.js preview).
* `GET /pelamar/lamaran/{id}` : **Detail Status & Timeline** (Progress bar visual status seleksi).

#### 2. Zona Admin Panel Manual (`layouts/admin.blade.php`)
* `GET /admin/dashboard` : **Statistik Ringkas** (Total Lowongan, Total Pelamar, Perlu Verifikasi).
* `GET /admin/lowongan` : **Tabel CRUD Lowongan** (Fitur Tambah, Edit, Hapus, Change Status Draft/Publish).
* `GET /admin/pelamar` : **Tabel Data Pelamar** (Filter berdasarkan Lowongan & Status, Button Modal Review Berkas).
* `GET /admin/pelamar/{id}/verifikasi` : **Halaman Detail & Verification** (Tampilan preview PDF CV/KTP + Form Aksi Lolos/Tolak + Catatan).
* `GET /admin/jadwal` : **Kelola Jadwal Seleksi** (Form assign tanggal & lokasi tes/interview ke pelamar).
* `GET /admin/hasil` : **Input Nilai & Keputusan** (Form input nilai tes & penentuan status diterima/ditolak).

#### 3. Zona HRD / Executive Panel (`layouts/hrd.blade.php`)
* `GET /hrd/dashboard` : **Executive Overview** (Grafik ringkas & persentase kelulusan).
* `GET /hrd/laporan` : **Modul Laporan** (Filter Tanggal & Posisi Job + Tombol Cetak PDF via DomPDF).

---

## 6. Roadmap Tahapan Eksekusi Vibe Coding

```
+-----------------------------------------------------------------------------------+
| TAHAP 1: SETUP ENVIRONMENT & CORE LAYOUTS (Target: 1 Jam)                        |
| - Install Laravel 11, Tailwind v3, DomPDF, Alpine.js                             |
| - Buat Master Layout Blade (App, Admin, HRD) & Custom CSS                         |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| TAHAP 2: DATABASE & MANUAL AUTH RBAC (Target: 1,5 Jam)                            |
| - Eksekusi Migration Tabel & Custom Middleware Role Check                         |
| - Buat Auth Controller Manual (Login, Register, Logout, Role Redirection)         |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| TAHAP 3: FRONTEND PORTAL PELAMAR (Target: 2,5 Jam)                                |
| - Landing Page, Detail Job Page, Form Apply + File Upload JavaScript Preview      |
| - Dashboard Pelamar & UI Timeline Status Seleksi                                  |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| TAHAP 4: MANUAL ADMIN & HRD DASHBOARD (Target: 3 Jam)                            |
| - Custom Data Table Blade (Lowongan CRUD, List Pelamar, Modal Preview PDF)        |
| - Form Penjadwalan, Input Nilai, & Integration DomPDF Export                      |
+-----------------------------------------------------------------------------------+
                                         |
                                         v
+-----------------------------------------------------------------------------------+
| TAHAP 5: FINISHING & TESTING (Target: 1 Jam)                                      |
| - Validasi upload berkas, proteksi route RBAC, responsive display check           |
+-----------------------------------------------------------------------------------+
```

---
*Dokumen PLANNING_AWAL.md ini adalah bagian 1 dari 2 berkas perencanaan proyek.*
