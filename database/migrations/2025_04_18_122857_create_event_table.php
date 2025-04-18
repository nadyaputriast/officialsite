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
        Schema::create('event', function (Blueprint $table) {
            $table->id('id_event');
            $table->string('nama_event');
            $table->enum('jenis_event', ['seminar', 'workshop', 'bootcamp', 'pameran', 'konferensi']);
            $table->date('tanggal_event');
            $table->time('waktu_event');
            $table->text('deskripsi_event');
            $table->enum('penyelenggara_event', ['internal', 'eksternal']);
            $table->string('nama_penyelenggara');
            $table->string('tautan_event');
            $table->string('thumbnail_event');
            $table->unsignedBigInteger('kode_admin');
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
        Schema::dropIfExists('event');
    }
};