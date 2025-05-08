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
        Schema::create('portofolio_votes', function (Blueprint $table) {
            $table->id('id_vote');
            $table->unsignedBigInteger('id_portofolio');
            $table->unsignedBigInteger('id_pengguna');
            $table->enum('jenis_vote', ['upvote', 'downvote']);
            $table->timestamps();

            // foreign key
            $table->foreign('id_portofolio')->references('id_portofolio')->on('portofolio')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');

            // Unique constraint to ensure one user can vote only once per portofolio
            $table->unique(['id_portofolio', 'id_pengguna']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_votes');
    }
};