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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id_transaksi')->primary();
            $table->uuid('siswa_id')->nullable();
            $table->uuid('tagihan_id')->nullable();
            $table->integer('jumlah_bayar');
            $table->date('tanggal_bayar');
            $table->enum('status', ['sukses', 'gagal']);
            $table->timestamps();

            $table->foreign('tagihan_id')->references('id_tagihan')->on('tagihan')->onDelete('no action')->onUpdate('no action');
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
