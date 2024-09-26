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
        Schema::create('tagihan_siswa', function (Blueprint $table) {
            $table->uuid('id_tagihan_siswa')->primary();
            $table->uuid('siswa_id')->nullable();
            $table->uuid('iuran_id')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif']);
            $table->timestamps();

            $table->foreign('siswa_id')->references('id_siswa')->on('siswa')->onDelete('no action')->onUpdate('no action');
            $table->foreign('iuran_id')->references('id_iuran')->on('iuran')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_siswa');
    }
};
