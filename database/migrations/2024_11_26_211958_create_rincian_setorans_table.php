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
        Schema::create('rincian_setoran', function (Blueprint $table) {
            $table->uuid('id_rincian_setoran')->primary(); // Primary key menggunakan UUID, sebagai identifikasi unik untuk rincian setoran
            $table->uuid('setoran_keuangan_id'); // Foreign key ke tabel 'setoran_keuangan', menghubungkan rincian setoran dengan setoran keuangan utama
            $table->uuid('iuran_id'); // Foreign key ke tabel 'iuran', menghubungkan rincian setoran dengan jenis iuran
            $table->integer('total_tagihan_setoran'); // Total jumlah tagihan yang harus dibayar untuk jenis iuran ini pada bulan setoran tersebut
            $table->integer('total_setoran'); // Total jumlah uang yang telah disetor untuk jenis iuran ini pada bulan setoran tersebut
            $table->integer('sisa_setoran'); // Sisa uang yang belum disetor untuk jenis iuran ini (selisih antara total_tagihan_setoran dan total_setoran_diterima)
            $table->enum('status', ['lunas', 'belum lunas']); // Status setoran untuk jenis iuran ini ("lunas" jika sudah penuh disetor, "belum lunas" jika masih ada yang belum disetor)
            $table->timestamps(); // Tanggal dan waktu pencatatan rincian setoran untuk jenis iuran ini

            // Foreign key untuk relasi dengan setoran_keuangan
            $table->foreign('setoran_keuangan_id')->references('id_setoran_keuangan')->on('setoran_keuangan')
                ->onDelete('no action')->onUpdate('no action');

            // Foreign key untuk relasi dengan iuran
            $table->foreign('iuran_id')->references('id_iuran')->on('iuran')
                ->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_setoran');
    }
};
