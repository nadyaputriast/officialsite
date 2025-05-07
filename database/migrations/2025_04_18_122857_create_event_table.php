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
            $table->string('tautan_event')->nullable();
            $table->string('thumbnail_event');
            $table->integer('kuota_event')->nullable();
            $table->boolean('status_event')->default(false);
            $table->bigInteger('harga_event');
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
        Schema::dropIfExists('event');
    }
};