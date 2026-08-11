<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\JadwalSeleksi;
use App\Models\HasilSeleksi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin, HRD, Pelamar)
        $admin = User::create([
            'name' => 'Admin Sariling',
            'email' => 'admin@sariling.co.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '081234567890',
            'alamat' => 'HQ PT Sariling Aneka Energi, Cikupa, Tangerang',
        ]);

        $hrd = User::create([
            'name' => 'HRD Executive Sariling',
            'email' => 'hrd@sariling.co.id',
            'password' => Hash::make('password'),
            'role' => 'hrd',
            'no_hp' => '081298765432',
            'alamat' => 'HQ PT Sariling Aneka Energi, Cikupa, Tangerang',
        ]);

        $pelamar1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'pelamar@sariling.co.id',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
            'no_hp' => '085711223344',
            'alamat' => 'Jl. Merdeka No. 45, Tangerang',
        ]);

        $pelamar2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti.aminah@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
            'no_hp' => '085899887766',
            'alamat' => 'Jl. Sudirman No. 12, Jakarta Barat',
        ]);

        $pelamar3 = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
            'no_hp' => '081344556677',
            'alamat' => 'Jl. Gajah Mada No. 88, Tangerang',
        ]);

        // 2. Seed Lowongan Pekerjaan
        $job1 = Lowongan::create([
            'judul_posisi' => 'Teknisi Genset Diesel Heavy Duty',
            'slug' => 'teknisi-genset-diesel-heavy-duty',
            'departemen' => 'Engineering & Maintenance',
            'deskripsi' => 'Melakukan pemeliharaan berkala, preventive maintenance, troubleshooting, dan overhaul mesin genset diesel skala industri kapasitas 50kVA - 2500kVA.',
            'kualifikasi' => "- Pria, Usia Maksimal 32 Tahun\n- Pendidikan minimal SMK/D3 Teknik Mesin / Otomotif / Listrik\n- Memiliki pengalaman minimal 2 tahun menangani mesin genset diesel (Perkins, Cummins, Baudouin, Lovol)\n- Siap ditugaskan ke site luar kota jika diperlukan\n- Memiliki SIM A/C aktif",
            'kuota' => 3,
            'status' => 'published',
            'tanggal_buka' => now()->subDays(10),
            'tanggal_tutup' => now()->addDays(20),
        ]);

        $job2 = Lowongan::create([
            'judul_posisi' => 'Staff HRD & General Affair',
            'slug' => 'staff-hrd-general-affair',
            'departemen' => 'Human Resources',
            'deskripsi' => 'Bertanggung jawab atas administrasi rekrutmen karyawan, absensi, pengurusan BPJS TK & Kesehatan, serta fasilitas umum kantor.',
            'kualifikasi' => "- Pria/Wanita, Usia Maksimal 28 Tahun\n- Pendidikan minimal S1 Psikologi / Manajemen / Hukum\n- Pengalaman minimal 1 tahun di bidang HR Generalist\n- Menguasai UU Ketenagakerjaan & proses seleksi karyawan\n- Mahir Ms. Office (Excel, Word, PowerPoint)",
            'kuota' => 2,
            'status' => 'published',
            'tanggal_buka' => now()->subDays(7),
            'tanggal_tutup' => now()->addDays(23),
        ]);

        $job3 = Lowongan::create([
            'judul_posisi' => 'Sales Executive Generator Set',
            'slug' => 'sales-executive-generator-set',
            'departemen' => 'Sales & Marketing',
            'deskripsi' => 'Melakukan penetrasi pasar B2B (Kontraktor, Pabrik, Rumah Sakit, Gedung), presentasi produk genset, penawaran harga, dan negosiasi penjualan.',
            'kualifikasi' => "- Pria/Wanita, Usia Maksimal 35 Tahun\n- Pendidikan minimal D3/S1 Semua Jurusan\n- Memiliki pengalaman sales B2B / teknik minimal 2 tahun\n- Berpenampilan menarik, komunikatif, dan berorientasi pada target sales\n- Memiliki jaringan klien sektor industri merupakan nilai plus",
            'kuota' => 5,
            'status' => 'published',
            'tanggal_buka' => now()->subDays(5),
            'tanggal_tutup' => now()->addDays(25),
        ]);

        $job4 = Lowongan::create([
            'judul_posisi' => 'Mechanical & Electrical Engineer',
            'slug' => 'mechanical-electrical-engineer',
            'departemen' => 'Engineering',
            'deskripsi' => 'Merancang wiring diagram panel ATS/AMF, kalkulasi kebutuhan daya genset, dan inspeksi teknis sebelum pengiriman unit.',
            'kualifikasi' => "- Pria, Usia Maksimal 30 Tahun\n- S1 Teknik Elektro / Teknik Mesin\n- Menguasai AutoCAD, MATLAB, & Sistem Kelistrikan 3 Phase",
            'kuota' => 2,
            'status' => 'draft',
            'tanggal_buka' => now(),
            'tanggal_tutup' => now()->addDays(30),
        ]);

        // 3. Seed Lamaran Pelamar
        $lamaran1 = Lamaran::create([
            'kode_pendaftaran' => 'SARILING-202608-001',
            'user_id' => $pelamar1->id,
            'lowongan_id' => $job1->id,
            'path_cv' => 'berkas_pelamar/sample_cv.pdf',
            'path_ijazah' => 'berkas_pelamar/sample_ijazah.pdf',
            'path_ktp' => 'berkas_pelamar/sample_ktp.jpg',
            'path_pendukung' => null,
            'status_lamaran' => 'lolos_administrasi',
            'catatan_admin' => 'Dokumen CV dan Ijazah sangat lengkap. Kualifikasi sesuai dengan kebutuhan posisi teknisi.',
        ]);

        $lamaran2 = Lamaran::create([
            'kode_pendaftaran' => 'SARILING-202608-002',
            'user_id' => $pelamar2->id,
            'lowongan_id' => $job2->id,
            'path_cv' => 'berkas_pelamar/sample_cv.pdf',
            'path_ijazah' => 'berkas_pelamar/sample_ijazah.pdf',
            'path_ktp' => 'berkas_pelamar/sample_ktp.jpg',
            'path_pendukung' => null,
            'status_lamaran' => 'jadwal_tes',
            'catatan_admin' => 'Lolos administrasi. Terjadwal untuk Wawancara HRD.',
        ]);

        $lamaran3 = Lamaran::create([
            'kode_pendaftaran' => 'SARILING-202608-003',
            'user_id' => $pelamar3->id,
            'lowongan_id' => $job3->id,
            'path_cv' => 'berkas_pelamar/sample_cv.pdf',
            'path_ijazah' => 'berkas_pelamar/sample_ijazah.pdf',
            'path_ktp' => 'berkas_pelamar/sample_ktp.jpg',
            'path_pendukung' => null,
            'status_lamaran' => 'diterima',
            'catatan_admin' => 'Performa wawancara user dan tes sales sangat memuaskan.',
        ]);

        // 4. Seed Jadwal Seleksi
        JadwalSeleksi::create([
            'lamaran_id' => $lamaran2->id,
            'tahap_seleksi' => 'wawancara_hrd',
            'tanggal_waktu' => now()->addDays(2)->setHour(10)->setMinute(0),
            'lokasi_atau_link' => 'Ruang Rapat Utama A - HQ PT Sariling Aneka Energi Cikupa',
            'instruksi_tambahan' => 'Membawa berkas cetak CV dan KTP asli untuk verifikasi fisik.',
        ]);

        JadwalSeleksi::create([
            'lamaran_id' => $lamaran3->id,
            'tahap_seleksi' => 'wawancara_user',
            'tanggal_waktu' => now()->subDays(2)->setHour(14)->setMinute(0),
            'lokasi_atau_link' => 'Ruang Direksi Sariling / Google Meet: meet.google.com/abc-defg-hij',
            'instruksi_tambahan' => 'Presentasi strategi marketing B2B.',
        ]);

        // 5. Seed Hasil Seleksi
        HasilSeleksi::create([
            'lamaran_id' => $lamaran3->id,
            'nilai_tes' => 88.50,
            'nilai_wawancara' => 92.00,
            'keputusan_akhir' => 'diterima',
            'catatan_evaluasi' => 'Kandidat memiliki pengetahuan mendalam seputar pasar genset industri dan track record penjualan yang terbukti.',
            'tanggal_pengumuman' => now()->subDay(),
        ]);
    }
}
