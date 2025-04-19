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
        Schema::create('dosen_mahasiswa_prestasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prestasi');
            $table->unsignedBigInteger('nip')->nullable();
            $table->unsignedBigInteger('nim')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_prestasi')->references('id_prestasi')->on('prestasi')->onDelete('cascade');
            $table->foreign('nip')->references('nip')->on('dosen')->onDelete('cascade');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
