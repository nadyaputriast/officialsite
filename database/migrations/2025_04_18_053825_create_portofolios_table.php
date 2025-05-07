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
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id('id_portofolio');
            $table->unsignedBigInteger('id_pengguna');
            $table->string('nama_portofolio');
            $table->text('deskripsi_portofolio');
            $table->boolean('status_portofolio')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('banyak_upvote')->default(0);
            $table->integer('banyak_downvote')->default(0);
            $table->string('dokumen_portofolio')->nullable();
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
        Schema::dropIfExists('portofolio');
    }
};
