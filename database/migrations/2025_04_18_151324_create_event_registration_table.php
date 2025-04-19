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
        Schema::create('event_registration', function (Blueprint $table) {
            $table->id('id_event_registration');
            $table->unsignedBigInteger('id_event');
            $table->unsignedBigInteger('id_pengguna');
            $table->timestamps();

            // foreign key
            $table->foreign('id_event')->references('id_event')->on('event')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registration');
    }
};
