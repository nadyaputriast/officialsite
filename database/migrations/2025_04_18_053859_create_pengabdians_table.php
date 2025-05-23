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
        Schema::create('pengabdian', function (Blueprint $table) {
            $table->id('id_pengabdian');
            $table->string('judul_pengabdian');
            $table->text('deskripsi_pengabdian');
            $table->boolean('status_pengabdian')->default(false);
            $table->date('tanggal_pengabdian');
            $table->string('pelaksana');
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
        Schema::dropIfExists('pengabdian');
    }
};
