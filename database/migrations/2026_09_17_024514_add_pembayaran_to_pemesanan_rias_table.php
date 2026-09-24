<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanan_rias', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('catatan');
            $table->string('bukti_transfer')->nullable()->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan_rias', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'bukti_transfer']);
        });
    }
};
