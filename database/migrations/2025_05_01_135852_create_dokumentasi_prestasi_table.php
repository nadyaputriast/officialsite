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
        Schema::create('dokumentasi_prestasi', function (Blueprint $table) {
            $table->id('id_dokumentasi_prestasi');
            $table->string('dokumentasi_prestasi');
            $table->unsignedBigInteger('id_prestasi');
            $table->timestamps();

            $table->foreign('id_prestasi')->references('id_prestasi')->on('prestasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_prestasi');
    }
};
