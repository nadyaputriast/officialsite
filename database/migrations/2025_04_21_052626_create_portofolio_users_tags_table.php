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
        Schema::create('portofolio_user_tags', function (Blueprint $table) {
            $table->id('id_tag_portofolio');
            $table->unsignedBigInteger('id_portofolio');
            $table->unsignedBigInteger('id_pengguna');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_portofolio')->references('id_portofolio')->on('portofolio')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio_users_tag');
    }
};
