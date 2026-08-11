<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@sariling.co.id'],
            [
                'name' => 'Administrator System',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Raya Serang Km 14.5 Cikupa, Tangerang',
            ]
        );

        // 2. Seed HRD User
        User::updateOrCreate(
            ['email' => 'hrd@sariling.co.id'],
            [
                'name' => 'Manager HRD Sariling',
                'password' => Hash::make('password'),
                'role' => 'hrd',
                'no_hp' => '081298765432',
                'alamat' => 'Tangerang, Banten',
            ]
        );

        // 3. Seed Sample Pelamar User
        User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Pratama',
                'password' => Hash::make('password'),
                'role' => 'pelamar',
                'no_hp' => '081311223344',
                'alamat' => 'Cikupa, Tangerang, Banten',
            ]
        );

        // 4. Seed Lowongan Pekerjaan Sampel
        Lowongan::updateOrCreate(
            ['slug' => 'teknisi-genset-mechanical'],
            [
                'judul_posisi' => 'Teknisi Genset & Mechanical',
                'departemen' => 'Engineering & Service',
                'deskripsi' => 'Bertanggung jawab dalam instalasi, pemeliharaan berkala, overhaul, serta troubleshooting unit genset diesel daya sedang hingga besar di lokasi workshop maupun pelanggan industri.',
                'kualifikasi' => "- Pria, Usia maks 30 tahun\n- Pendidikan min. SMK Teknik Mesin / D3 Teknik\n- Memahami engine diesel (Perkins, Cummins, Deutz)\n- Pengalaman minimal 1 tahun di bidang genset",
                'kuota' => 3,
                'status' => 'published',
                'tanggal_buka' => '2026-08-01',
                'tanggal_tutup' => '2026-09-30',
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'staff-admin-rekrutmen-hrd'],
            [
                'judul_posisi' => 'Staff Admin Rekrutmen & HRD',
                'departemen' => 'Human Resource Department',
                'deskripsi' => 'Mengelola administrasi penerimaan karyawan baru, penjadwalan proses seleksi, verifikasi kelengkapan berkas pelamar, serta pengarsipan dokumen HR.',
                'kualifikasi' => "- Pria/Wanita, Usia maks 28 tahun\n- Pendidikan min. D3/S1 Manajemen / Psikologi / Administrasi\n- Menguasai MS Office (Excel, Word) & Sistem Informasi HR\n- Komunikatif, teliti, dan memiliki interpersonal skill yang baik",
                'kuota' => 2,
                'status' => 'published',
                'tanggal_buka' => '2026-08-01',
                'tanggal_tutup' => '2026-09-15',
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'electrical-support-engineer'],
            [
                'judul_posisi' => 'Electrical Support Engineer',
                'departemen' => 'Engineering',
                'deskripsi' => 'Merancang dan memverifikasi sistem kontrol panel ATS/AMF, modul sinkronisasi genset, serta memberikan dukungan teknis untuk pemeliharaan kelistrikan genset.',
                'kualifikasi' => "- Pria/Wanita, Usia maks 32 tahun\n- Pendidikan min. S1 Teknik Elektro / Listrik\n- Memahami diagram skematik listrik & kontrol panel genset\n- Pengalaman min. 2 tahun di bidang kelistrikan industri",
                'kuota' => 2,
                'status' => 'published',
                'tanggal_buka' => '2026-08-05',
                'tanggal_tutup' => '2026-09-20',
            ]
        );
    }
}
