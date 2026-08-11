<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Lowongan;
use App\Models\Lamaran;

class RecruitmentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed initial roles & sample data
        $this->seed();
    }

    public function test_public_landing_page_can_be_rendered()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('PT Sariling Aneka Energi');
        $response->assertSee('Teknisi Genset');
    }

    public function test_user_can_register_as_pelamar()
    {
        $response = $this->post('/register', [
            'name' => 'Budi Testing',
            'email' => 'buditest@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'no_hp' => '081299998888',
            'alamat' => 'Tangerang',
        ]);

        $response->assertRedirect('/pelamar/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'buditest@gmail.com',
            'role' => 'pelamar',
        ]);
    }

    public function test_authentication_and_role_redirection_works()
    {
        // Admin Login
        $responseAdmin = $this->post('/login', [
            'email' => 'admin@sariling.co.id',
            'password' => 'password',
        ]);
        $responseAdmin->assertRedirect('/admin/dashboard');

        // Logout
        $this->post('/logout');

        // HRD Login
        $responseHrd = $this->post('/login', [
            'email' => 'hrd@sariling.co.id',
            'password' => 'password',
        ]);
        $responseHrd->assertRedirect('/hrd/dashboard');
    }

    public function test_rbac_middleware_blocks_unauthorized_access()
    {
        $pelamar = User::where('role', 'pelamar')->first();

        // Pelamar tries to access Admin panel -> gets 403 Forbidden
        $response = $this->actingAs($pelamar)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_lowongan()
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/lowongan', [
            'judul_posisi' => 'QA Automation Engineer',
            'departemen' => 'IT & Software',
            'deskripsi' => 'Pengujian otomasi sistem e-rekrutmen.',
            'kualifikasi' => 'Pengalaman Laravel & Pest/PHPUnit.',
            'kuota' => 2,
            'status' => 'published',
            'tanggal_buka' => date('Y-m-d'),
            'tanggal_tutup' => date('Y-m-d', strtotime('+30 days')),
        ]);

        $response->assertRedirect(route('admin.lowongan.index'));
        $this->assertDatabaseHas('lowongan', [
            'judul_posisi' => 'QA Automation Engineer',
            'departemen' => 'IT & Software',
        ]);
    }

    public function test_pelamar_can_apply_job_with_strict_files()
    {
        Storage::fake('public');
        $pelamar = User::where('role', 'pelamar')->first();
        $job = Lowongan::where('status', 'published')->first();

        $cv = UploadedFile::fake()->create('cv.pdf', 500, 'application/pdf');
        $ijazah = UploadedFile::fake()->create('ijazah.pdf', 800, 'application/pdf');
        $ktp = UploadedFile::fake()->image('ktp.jpg', 600, 400);

        $response = $this->actingAs($pelamar)->post("/pelamar/lamar/{$job->id}", [
            'cv' => $cv,
            'ijazah' => $ijazah,
            'ktp' => $ktp,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('lamaran', [
            'user_id' => $pelamar->id,
            'lowongan_id' => $job->id,
        ]);
    }

    public function test_admin_can_verify_applicant_documents_and_schedule()
    {
        $admin = User::where('role', 'admin')->first();
        $lamaran = Lamaran::first();

        // Update verification status to lolos_administrasi
        $responseVerif = $this->actingAs($admin)->patch("/admin/pelamar/{$lamaran->id}/status", [
            'status_lamaran' => 'lolos_administrasi',
            'catatan_admin' => 'Dokumen valid dan sesuai.',
        ]);
        $responseVerif->assertRedirect();
        $this->assertDatabaseHas('lamaran', [
            'id' => $lamaran->id,
            'status_lamaran' => 'lolos_administrasi',
        ]);

        // Schedule test/interview
        $responseSchedule = $this->actingAs($admin)->post('/admin/jadwal', [
            'lamaran_id' => $lamaran->id,
            'tahap_seleksi' => 'wawancara_hrd',
            'tanggal_waktu' => date('Y-m-d H:i:s', strtotime('+2 days')),
            'lokasi_atau_link' => 'Ruang Rapat Utama A',
            'instruksi_tambahan' => 'Membawa CV fisik',
        ]);
        $responseSchedule->assertRedirect(route('admin.jadwal.index'));
    }

    public function test_admin_can_input_scoring_and_final_decision()
    {
        $admin = User::where('role', 'admin')->first();
        $lamaran = Lamaran::first();

        $response = $this->actingAs($admin)->post("/admin/nilai/{$lamaran->id}", [
            'nilai_tes' => 90.00,
            'nilai_wawancara' => 95.00,
            'keputusan_akhir' => 'diterima',
            'catatan_evaluasi' => 'Sangat direkomendasikan.',
            'tanggal_pengumuman' => date('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.nilai.index'));
        $this->assertDatabaseHas('hasil_seleksi', [
            'lamaran_id' => $lamaran->id,
            'keputusan_akhir' => 'diterima',
        ]);
    }

    public function test_hrd_can_export_pdf_report()
    {
        $hrd = User::where('role', 'hrd')->first();

        $response = $this->actingAs($hrd)->get('/hrd/laporan/export-pdf');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
