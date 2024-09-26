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
        Schema::create('potongan_siswa', function (Blueprint $table) {
            $table->uuid('id_potongan_siswa')->primary();
            $table->uuid('siswa_id')->nullable();
            $table->uuid('tagihan_siswa_id')->nullable();
            $table->uuid('potongan_id')->nullable();
            $table->integer('potongan_persen');
            $table->enum('status', ['aktif', 'tidak aktif']);
            $table->timestamps();

            $table->foreign('siswa_id')->references('id_siswa')->on('siswa')->onDelete('no action')->onUpdate('no action');
            $table->foreign('tagihan_siswa_id')->references('id_tagihan_siswa')->on('tagihan_siswa')->onDelete('no action')->onUpdate('no action');
            $table->foreign('potongan_id')->references('id_potongan')->on('potongan')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potongan_siswa');
    }
};
