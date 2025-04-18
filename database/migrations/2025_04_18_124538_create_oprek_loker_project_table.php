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
            $table->string('penyelenggara');
            $table->string('tautan_oprek');
            $table->unsignedBigInteger('kode_admin');
            $table->unsignedBigInteger('nip');
            $table->unsignedBigInteger('nim');
            $table->timestamps();

            // foreign key
            $table->foreign('kode_admin')->references('kode_admin')->on('admin')->onDelete('cascade');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
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