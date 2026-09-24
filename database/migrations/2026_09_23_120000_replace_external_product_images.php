<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('produks')->select('id', 'gambar_utama', 'gambar_galeri')->get()->each(function ($produk) {
            $gambarUtama = str_contains((string) $produk->gambar_utama, 'unsplash.com')
                ? '/images/Logo_butik.png'
                : $produk->gambar_utama;
            $gambarGaleri = json_decode($produk->gambar_galeri ?: '[]', true) ?: [];
            $gambarGaleri = array_map(
                fn ($gambar) => str_contains((string) $gambar, 'unsplash.com') ? '/images/Logo_butik.png' : $gambar,
                $gambarGaleri
            );

            DB::table('produks')->where('id', $produk->id)->update([
                'gambar_utama' => $gambarUtama,
                'gambar_galeri' => json_encode($gambarGaleri),
            ]);
        });

        DB::table('pesanans')
            ->where('gambar_produk', 'like', '%unsplash.com%')
            ->update(['gambar_produk' => '/images/Logo_butik.png']);
    }

    public function down(): void
    {
        // External image URLs are intentionally not restored.
    }
};
