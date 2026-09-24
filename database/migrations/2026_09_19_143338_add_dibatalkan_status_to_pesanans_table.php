<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE pesanans MODIFY status ENUM(
            'menunggu_konfirmasi',
            'pembayaran_berhasil',
            'selesai',
            'dibatalkan'
        ) NOT NULL DEFAULT 'menunggu_konfirmasi'");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE pesanans MODIFY status ENUM(
            'menunggu_konfirmasi',
            'pembayaran_berhasil',
            'selesai'
        ) NOT NULL DEFAULT 'menunggu_konfirmasi'");
    }
};