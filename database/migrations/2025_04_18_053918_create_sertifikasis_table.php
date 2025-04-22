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
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id('id_sertifikasi');
            $table->string('nama_sertifikasi');
            $table->text('deskripsi_sertifikasi');
            $table->boolean('status_sertifikasi')->default(false);
            $table->string('penyelenggara');
            $table->date('tanggal_sertifikasi');
            $table->integer('masa_berlaku')->nullable();
            $table->string('file_sertifikasi');
            $table->unsignedBigInteger('nip');
            $table->timestamps();

            // foreign key
            $table->foreign('nip')->references('nip')->on('dosen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikasi');
    }
};
