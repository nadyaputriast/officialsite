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
        Schema::create('download', function (Blueprint $table) {
            $table->id('id_download');
            $table->string('nama_download');
            $table->enum('jenis_konten', ['Materi Kuliah', 'Aplikasi', 'Manual Book', 'Source Code', 'Template', 'Dataset', 'E-book']);
            $table->string('file_konten');
            $table->boolean('status_download')->default(false);
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
        Schema::dropIfExists('download');
    }
};
