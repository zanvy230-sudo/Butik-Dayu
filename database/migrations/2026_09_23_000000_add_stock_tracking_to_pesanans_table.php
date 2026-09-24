<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->timestamp('stok_dikurangi_at')->nullable()->after('status');
            $table->timestamp('stok_dikembalikan_at')->nullable()->after('stok_dikurangi_at');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['stok_dikurangi_at', 'stok_dikembalikan_at']);
        });
    }
};
