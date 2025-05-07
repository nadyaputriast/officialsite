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
        Schema::create('pembayaran_event', function (Blueprint $table) {
            $table->id('id_pembayaran_event');
            $table->string('bukti_pembayaran');
            $table->unsignedBigInteger('id_promo_event')->nullable();
            $table->unsignedBigInteger('id_event_registration');
            $table->timestamps();

            // foreign key
            $table->foreign('id_promo_event')->references('id_promo_event')->on('promo_event_internal')->onDelete('cascade');
            $table->foreign('id_event_registration')->references('id_event_registration')->on('event_registration')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_event_internal');
    }
};
