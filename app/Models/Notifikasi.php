<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'icon',
        'url',
        'dibaca_at',
    ];

    protected function casts(): array
    {
        return [
            'dibaca_at' => 'datetime',
        ];
    }

    public static function kirim($userId, $icon, $judul, $pesan, $url = null): self
    {
        return self::create([
            'user_id' => $userId,
            'icon' => $icon,
            'judul' => $judul,
            'pesan' => $pesan,
            'url' => $url,
            'dibaca_at' => null,
        ]);
    }

    public function scopeBelumDibaca($query)
    {
        return $query->whereNull('dibaca_at');
    }

    // --- ACCESSOR UNTUK MENERJEMAHKAN JUDUL OTOMATIS ---
    public function getJudulAttribute($value)
    {
        if (App::getLocale() === 'en') {
            if ($this->icon === 'koleksi' || str_contains($value, 'Pemesanan Layanan Rias')) {
                return 'Makeup Service Booking Received';
            }
            if (str_contains($value, 'Pesanan Berhasil Dibuat')) {
                return 'Order Successfully Created';
            }
        }
        return $value;
    }

    // --- ACCESSOR UNTukan MENERJEMAHKAN PESAN OTOMATIS ---
    public function getPesanAttribute($value)
    {
        if (App::getLocale() === 'en') {
            if (str_contains($value, 'Pemesanan Layanan Rias Diterima')) {
                return 'Your makeup service booking has been accepted.';
            }
            // Contoh untuk pesan yang dinamis mengandung nama produk
            if (str_contains($value, 'sedang menunggu konfirmasi')) {
                // Mengubah format "Pesanan "Baju Adat Toraja" sedang menunggu konfirmasi."
                return str_replace('sedang menunggu konfirmasi.', 'is awaiting confirmation.', $value);
            }
        }
        return $value;
    }
}