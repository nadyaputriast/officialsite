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
        Schema::create('lampiran_komentar', function (Blueprint $table) {
            $table->id('id_lampiran_komentar');
            $table->string('lampiran_komentar');
            $table->unsignedBigInteger('id_komentar_portofolio');
            $table->timestamps();

            // foreign key
            $table->foreign('id_komentar_portofolio')->references('id_komentar_portofolio')->on('komentar_portofolio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran_komentar');
    }
};
