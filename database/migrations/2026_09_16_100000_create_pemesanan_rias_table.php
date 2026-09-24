<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan_rias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('paket_slug');
            $table->string('paket_nama');
            $table->unsignedBigInteger('paket_harga');
            $table->string('nama_lengkap');
            $table->string('telepon');
            $table->text('alamat_acara');
            $table->date('tanggal_acara');
            $table->time('jam_acara');
            $table->text('catatan')->nullable();
            // menunggu_konfirmasi -> dikonfirmasi -> selesai -> dibatalkan
            $table->string('status')->default('menunggu_konfirmasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_rias');
    }
};
