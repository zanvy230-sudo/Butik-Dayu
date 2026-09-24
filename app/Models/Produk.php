<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'nama',
        'kategori_label',
        'daerah',
        'region',
        'harga',
        'rating',
        'jumlah_ulasan',
        'deskripsi',
        'catatan_pengerjaan',
        'gambar_utama',
        'gambar_galeri',
        'fokus_gambar',
        'stok_ukuran',
    ];

    protected $casts = [
        'gambar_galeri' => 'array',
        'stok_ukuran'   => 'array',
        'harga'         => 'integer',
    ];

    /**
     * Status sewa dihitung otomatis: "Sedang Disewa" kalau ada pesanan
     * untuk produk ini yang sudah dikonfirmasi admin (status
     * pembayaran_berhasil) dan hari ini masih dalam rentang tanggal sewa.
     */
    public function statusSewa(): string
    {
        $sedangDisewa = Pesanan::where('produk_slug', $this->slug)
            ->where('status', 'pembayaran_berhasil')
            ->whereDate('tanggal_sewa_mulai', '<=', now())
            ->whereDate('tanggal_sewa_selesai', '>=', now())
            ->exists();

        return $sedangDisewa ? 'Sedang Disewa' : 'Produk Tersedia';
    }
}