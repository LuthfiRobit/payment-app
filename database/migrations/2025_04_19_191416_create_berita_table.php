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
        Schema::create('berita', function (Blueprint $table) {
            $table->uuid('id_berita')->primary();

            // Relasi ke users
            $table->uuid('user_id')->nullable();

            // Kolom berita
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi');
            $table->string('gambar')->nullable();

            // Status berita dan waktu publish
            $table->enum('status', ['aktif', 'tidak aktif']);

            // Counter
            $table->unsignedInteger('dilihat')->default(0);

            // Timestamps
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                ->references('id_user')
                ->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
