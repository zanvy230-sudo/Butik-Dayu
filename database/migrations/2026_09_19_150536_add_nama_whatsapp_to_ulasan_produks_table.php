<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ulasan_produks', function (Blueprint $table) {
            $table->string('nama')->after('user_id');
            $table->string('whatsapp')->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('ulasan_produks', function (Blueprint $table) {
            $table->dropColumn(['nama', 'whatsapp']);
        });
    }
};