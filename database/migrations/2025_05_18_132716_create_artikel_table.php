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
        Schema::create('artikel', function (Blueprint $table) {
            $table->uuid('id_artikel')->primary();
            $table->uuid('user_id')->nullable();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif']);
            $table->unsignedInteger('dilihat')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
