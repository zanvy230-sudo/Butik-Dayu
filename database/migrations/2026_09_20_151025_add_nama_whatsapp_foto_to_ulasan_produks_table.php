<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Catatan: migration awal tabel ulasan_produks ternyata belum punya
     * kolom `nama` dan `whatsapp`, padahal Controller & Model sudah
     * mencoba menyimpan ke situ (akan error "Unknown column" kalau
     * belum ditambahkan). Sekalian ditambahkan di sini bareng kolom
     * `foto` yang baru diminta.
     */
    public function up(): void
    {
        Schema::table('ulasan_produks', function (Blueprint $table) {
            if (! Schema::hasColumn('ulasan_produks', 'nama')) {
                $table->string('nama')->after('user_id');
            }
            if (! Schema::hasColumn('ulasan_produks', 'whatsapp')) {
                $table->string('whatsapp')->after('nama');
            }
            if (! Schema::hasColumn('ulasan_produks', 'foto')) {
                $table->string('foto')->nullable()->after('komentar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ulasan_produks', function (Blueprint $table) {
            $table->dropColumn(['nama', 'whatsapp', 'foto']);
        });
    }
};