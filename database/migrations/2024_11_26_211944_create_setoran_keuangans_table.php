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
        Schema::create('setoran_keuangan', function (Blueprint $table) {
            $table->uuid('id_setoran_keuangan')->primary(); // Primary key menggunakan UUID, sebagai identifikasi unik untuk setoran keuangan
            $table->integer('bulan'); // Bulan setoran (contoh: "1" untuk Januari, "2" untuk Februari, dst.)
            $table->year('tahun'); // Tahun setoran (contoh: 2024)
            $table->string('nama_bulan'); // Nama bulan untuk setoran (contoh: "Januari", "Februari", dst.)
            $table->integer('total_tagihan_setoran'); // Total jumlah tagihan yang harus dibayar pada bulan ini (jumlah total transaksi/tagihan yang harus dibayar)
            $table->integer('total_setoran'); // Total uang yang sudah disetor pada bulan ini
            $table->integer('sisa_setoran'); // Sisa uang yang belum disetor pada bulan ini (selisih antara total_tagihan_setoran dan total_setoran)
            $table->text('keterangan')->nullable(); // Keterangan tambahan mengenai setoran keuangan, bersifat opsional
            $table->enum('status', ['lunas', 'belum lunas']); // Status setoran keuangan untuk bulan ini ("lunas" jika sudah penuh disetor, "belum lunas" jika masih ada yang belum disetor)
            $table->timestamps(); // Tanggal dan waktu pencatatan entri setoran keuangan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran_keuangan');
    }
};
