<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamaran');
    }
};
