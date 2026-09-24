<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('nama');
            $table->string('kategori_label');
            $table->string('daerah');
            $table->string('region');
            $table->unsignedBigInteger('harga');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('jumlah_ulasan')->default(0);
            $table->text('deskripsi');
            $table->text('catatan_pengerjaan');
            $table->string('gambar_utama');
            $table->json('gambar_galeri');
            $table->json('stok_ukuran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};