<?php

namespace App\Support;

class PaketRiasData
{
    /**
     * Data statis 3 paket Layanan Rias (sama seperti mockup di halaman
     * /layanan-rias). Nanti kalau mau dipindah ke database, cukup ganti
     * isi method semua() ini jadi query ke tabel, pemanggilnya tidak
     * perlu berubah.
     */
    public static function semua(): array
    {
        return [
            'akad' => [
                'slug'  => 'akad',
                'nama'  => 'Paket Akad',
                'harga' => 2500000,
            ],
            'resepsi' => [
                'slug'  => 'resepsi',
                'nama'  => 'Paket Resepsi',
                'harga' => 5500000,
            ],
            'pre-wedding' => [
                'slug'  => 'pre-wedding',
                'nama'  => 'Pre-Wedding',
                'harga' => 2000000,
            ],
        ];
    }

    public static function cari(string $slug): ?array
    {
        return self::semua()[$slug] ?? null;
    }
}
