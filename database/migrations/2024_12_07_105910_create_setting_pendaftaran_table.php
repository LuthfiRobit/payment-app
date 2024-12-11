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
        Schema::create('setting_pendaftaran', function (Blueprint $table) {
            $table->uuid('id_setting')->primary();
            $table->uuid('tahun_akademik_id')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('biaya_pendaftaran');
            $table->enum('status', ['aktif', 'tidak aktif']);
            $table->timestamps();

            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_pendaftaran');
    }
};
