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
        Schema::create('komentar_portofolio', function (Blueprint $table) {
            $table->id('id_komentar_portofolio');
            $table->text('komentar');
            $table->unsignedBigInteger('id_portofolio');
            $table->unsignedBigInteger('id_pengguna');
            $table->timestamps();

            // foreign key
            $table->foreign('id_portofolio')->references('id_portofolio')->on('portofolio')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_portofolio');
    }
};
