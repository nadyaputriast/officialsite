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
            $table->enum('status_prestasi', ['valid', 'nonvalid']);
            $table->date('tanggal_perolehan');
            $table->enum('tingkatan_prestasi', ['Regional', 'Nasional', 'Internasional']);
            $table->enum('jenis_prestasi', ['Akademik', 'Non-Akademik']);
            $table->timestamps();
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
