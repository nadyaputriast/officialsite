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
        Schema::create('kualifikasi_oprek', function (Blueprint $table) {
            $table->id('id_kualifikasi_oprek');
            $table->string('kualifikasi_oprek');
            $table->unsignedBigInteger('id_oprek')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('id_oprek')->references('id_oprek')->on('oprek_loker_project')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kualifikasi_oprek');
    }
};
