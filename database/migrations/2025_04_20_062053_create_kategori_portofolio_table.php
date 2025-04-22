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
        Schema::create('kategori_portofolio', function (Blueprint $table) {
            $table->id('id_kategori_portofolio');
            $table->enum('kategori_portofolio', ['UI/UX Design', 'Website Development', 'Mobile Development', 'Game Development', 'Internet of Things', 'Machine Learning', 'Data']);
            $table->unsignedBigInteger('id_portofolio');
            $table->timestamps();
            
            $table->foreign('id_portofolio')->references('id_portofolio')->on('portofolio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_portofolio');
    }
};
