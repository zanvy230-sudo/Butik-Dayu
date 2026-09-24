<?php

namespace App\Support;

/**
 * Data riwayat pesanan sementara (belum dari database).
 * Jika nantinya sudah dibuatkan tabel "pesanan" / "orders" di database,
 * class ini dapat digantikan atau dimigrasi ke Model Eloquent.
 */
class PesananData
{
    /**
     * Mengambil seluruh daftar riwayat pesanan pengguna.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function semua(): array
    {
        return [
            [
                'kode' => 'BTK1019',
                'tanggal' => '14:32, 24 Juni 2026',
                'nama' => 'Kebaya Siger Sunda',
                'warna' => 'White',
                'ukuran' => 'M',
                'jumlah' => 1,
                'harga' => 8500000,
                'status' => 'Pesanan dalam Perjalanan',
                'status_type' => 'in_delivery',
                'gambar' => '/images/Logo_butik.png',
            ],
            [
                'kode' => 'BTK1018',
                'tanggal' => '18:07, 13 April 2026',
                'nama' => 'Payas Agung Royal',
                'warna' => 'Gold',
                'ukuran' => 'XL',
                'jumlah' => 1,
                'harga' => 10500000,
                'status' => 'Pesanan Selesai',
                'status_type' => 'completed',
                'gambar' => '/images/Logo_butik.png',
            ],
            [
                'kode' => 'BTK1017',
                'tanggal' => '13:24, 9 Maret 2026',
                'nama' => 'Minang Suntiang',
                'warna' => 'Maroon',
                'ukuran' => 'L',
                'jumlah' => 1,
                'harga' => 9000000,
                'status' => 'Pesanan Selesai',
                'status_type' => 'completed',
                'gambar' => '/images/Logo_butik.png',
            ],
            [
                'kode' => 'BTK1016',
                'tanggal' => '16:45, 30 Januari 2026',
                'nama' => 'Baju Bodo Modern',
                'warna' => 'Dusty Pink',
                'ukuran' => 'M',
                'jumlah' => 1,
                'harga' => 7500000,
                'status' => 'Pesanan Selesai',
                'status_type' => 'completed',
                'gambar' => '/images/Logo_butik.png',
            ],
        ];
    }
}
