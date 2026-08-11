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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
