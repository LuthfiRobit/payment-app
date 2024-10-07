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
        Schema::create('rincian_tagihan', function (Blueprint $table) {
            $table->uuid('id_rincian_tagihan')->primary();
            $table->uuid('tagihan_id')->nullable();
            $table->uuid('tagihan_siswa_id')->nullable();
            $table->uuid('potongan_siswa_id')->nullable();
            $table->integer('besar_tagihan');
            $table->integer('besar_potongan');
            $table->integer('total_tagihan');
            $table->integer('sisa_tagihan');
            $table->enum('status', ['lunas', 'belum lunas']);
            $table->timestamps();

            $table->foreign('tagihan_id')->references('id_tagihan')->on('tagihan')->onDelete('no action')->onUpdate('no action');
            $table->foreign('tagihan_siswa_id')->references('id_tagihan_siswa')->on('tagihan_siswa')->onDelete('no action')->onUpdate('no action');
            $table->foreign('potongan_siswa_id')->references('id_potongan_siswa')->on('potongan_siswa')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_tagihan');
    }
};
