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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_seleksi');
    }
};
