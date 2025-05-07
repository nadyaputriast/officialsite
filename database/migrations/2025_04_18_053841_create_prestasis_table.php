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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            $table->string('nama_prestasi');
            $table->text('deskripsi_prestasi');
            $table->boolean('status_prestasi')->default(false);
            $table->date('tanggal_perolehan');
            $table->enum('tingkatan_prestasi', ['Regional', 'Nasional', 'Internasional']);
            $table->enum('jenis_prestasi', ['Akademik', 'Non Akademik']);
            $table->unsignedBigInteger('id_pengguna');
            $table->timestamps();

            // foreign key
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
