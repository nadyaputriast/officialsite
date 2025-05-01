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
        Schema::create('oprek_loker_project', function (Blueprint $table) {
            $table->id('id_oprek');
            $table->string('nama_project');
            $table->text('deskripsi_project');
            $table->date('deadline_project');
            $table->enum('penyelenggara', ['Dosen', 'Mahasiswa', 'Organisasi', 'Eksternal']);
            $table->string('nama_penyelenggara');
            $table->enum('kategori_project', ['Penelitian', 'Pengembangan Aplikasi', 'Pengabdian Masyarakat', 'Inisiatif Pribadi']);
            $table->enum('output_project', ['Website', 'Mobile Apps', 'API Development', 'Game', 'Machine Learning/AI Project', 'Cyber Security', 'Automation', 'Embedded System']);
            $table->string('tautan_project');
            $table->string('flyer_informasi')->nullable();
            $table->boolean('status_project')->default(0);
            $table->unsignedBigInteger('id_pengguna')->nullable();
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
        Schema::dropIfExists('oprek_loker_project');
    }
};