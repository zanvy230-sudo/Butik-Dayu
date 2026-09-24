<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Menghubungkan beberapa baris pesanan yang dibuat dari 1x checkout
            // (checkout multi-produk). Untuk checkout produk tunggal, tetap
            // diisi (1 baris = 1 grup berisi 1 pesanan).
            $table->string('order_group')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn('order_group');
        });
    }
};
