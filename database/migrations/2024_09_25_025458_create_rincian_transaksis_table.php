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
        Schema::create('rincian_transaksi', function (Blueprint $table) {
            $table->uuid('id_rincian_transaksi')->primary();
            $table->uuid('transaksi_id')->nullable();
            $table->uuid('rincian_tagihan_id')->nullable();
            $table->integer('total_bayar');
            $table->timestamps();

            $table->foreign('transaksi_id')->references('id_transaksi')->on('transaksi')->onDelete('no action')->onUpdate('no action');
            $table->foreign('rincian_tagihan_id')->references('id_rincian_tagihan')->on('rincian_tagihan')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_transaksi');
    }
};
