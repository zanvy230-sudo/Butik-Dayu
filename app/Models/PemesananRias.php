<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemesananRias extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_rias';

    protected $fillable = [
        'user_id',
        'paket_slug',
        'paket_nama',
        'paket_harga',
        'nama_lengkap',
        'telepon',
        'alamat_acara',
        'tanggal_acara',
        'jam_acara',
        'catatan',
        'metode_pembayaran',
        'bukti_transfer',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_acara' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Label status berwarna, dipakai konsisten di Blade.
     * Sama pola dengan Pesanan::labelStatus() / badgeClass().
     *
     * menunggu_transfer    -> khusus metode transfer, sebelum upload bukti
     * menunggu_verifikasi  -> transfer sudah upload bukti, nunggu admin cek
     * menunggu_konfirmasi  -> COD, atau status lama sebelum ada metode pembayaran
     */
    public function labelStatus(): string
    {
        return match ($this->status) {
            'menunggu_transfer'   => 'Menunggu Transfer',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'dikonfirmasi'        => 'Dikonfirmasi',
            'selesai'             => 'Selesai',
            'dibatalkan'          => 'Dibatalkan',
            default               => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function badgeClass(): string
    {
        return match ($this->status) {
            'menunggu_transfer', 'menunggu_verifikasi', 'menunggu_konfirmasi' => 'bg-amber-50 text-amber-600',
            'dikonfirmasi'        => 'bg-blue-50 text-blue-600',
            'selesai'             => 'bg-green-50 text-green-600',
            'dibatalkan'          => 'bg-red-50 text-red-600',
            default               => 'bg-brand-50 text-brand-600',
        };
    }
}