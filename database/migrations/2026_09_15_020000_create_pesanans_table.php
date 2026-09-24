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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Snapshot data produk saat checkout (bukan relasi langsung ke
            // ProdukData karena produk masih berupa array statis, belum tabel).
            $table->string('produk_slug')->nullable();
            $table->string('nama_produk');
            $table->string('gambar_produk')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();

            $table->unsignedBigInteger('total_pembayaran');
            $table->enum('metode_pembayaran', ['transfer', 'cod']);
            $table->string('bukti_transfer')->nullable();

            // menunggu_konfirmasi -> pembayaran_berhasil -> selesai
            // (diubah manual oleh admin lewat halaman admin nanti)
            $table->enum('status', [
                'menunggu_konfirmasi',
                'pembayaran_berhasil',
                'selesai',
            ])->default('menunggu_konfirmasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
