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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->uuid('id_tagihan')->primary();
            $table->uuid('tahun_akademik_id')->nullable();
            $table->uuid('siswa_id')->nullable();
            $table->integer('besar_tagihan');
            $table->integer('besar_potongan');
            $table->integer('total_tagihan');
            $table->enum('status', ['lunas', 'belum lunas']);
            $table->timestamps();

            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik')->onDelete('no action')->onUpdate('no action');
            $table->foreign('siswa_id')->references('id_siswa')->on('siswa')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
