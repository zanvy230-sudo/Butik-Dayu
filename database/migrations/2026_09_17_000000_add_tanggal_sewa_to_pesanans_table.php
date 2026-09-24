<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->date('tanggal_sewa_mulai')->nullable()->after('alamat_lengkap');
            $table->date('tanggal_sewa_selesai')->nullable()->after('tanggal_sewa_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['tanggal_sewa_mulai', 'tanggal_sewa_selesai']);
        });
    }
};
