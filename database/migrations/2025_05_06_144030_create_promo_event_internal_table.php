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
        Schema::create('promo_event_internal', function (Blueprint $table) {
            $table->id('id_promo_event');
            $table->string('kode_promo');
            $table->enum('jenis_promo', ['Persentase', 'Potongan Harga']);
            $table->integer('nilai_promo');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->unsignedBigInteger('id_event');
            $table->timestamps();

            // foreign key
            $table->foreign('id_event')->references('id_event')->on('event')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_event_internal');
    }
};
