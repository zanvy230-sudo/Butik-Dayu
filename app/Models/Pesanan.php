<?php

namespace App\Models;

use App\Models\Notifikasi;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_slug',
        'nama_produk',
        'gambar_produk',
        'size',
        'color',
        'nama_penerima',
        'telepon',
        'alamat_lengkap',
        'total_pembayaran',
        'metode_pembayaran',
        'bukti_transfer',
        'status',
        'tanggal_sewa_mulai',
        'tanggal_sewa_selesai',
        'order_group',
        'stok_dikurangi_at',
        'stok_dikembalikan_at',
    ];

    protected $casts = [
        'total_pembayaran' => 'integer',
        'tanggal_sewa_mulai' => 'date',
        'tanggal_sewa_selesai' => 'date',
        'stok_dikurangi_at' => 'datetime',
        'stok_dikembalikan_at' => 'datetime',
    ];

    /**
     * Model event: otomatis kirim notifikasi setiap kali pesanan baru
     * dibuat, ATAU statusnya berubah (misalnya nanti diubah dari halaman
     * admin). Jadi tidak perlu manggil kode notifikasi manual di
     * CheckoutController atau di mana pun -- cukup di sini SEKALI.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function (Pesanan $pesanan) {
            Notifikasi::kirim(
                userId: $pesanan->user_id,
                judul: 'Pesanan Berhasil Dibuat',
                pesan: "Pesanan \"{$pesanan->nama_produk}\" sedang menunggu konfirmasi.",
                icon: 'pesanan',
                url: route('profile.settings', ['tab' => 'riwayat'])
            );
        });

        static::updated(function (Pesanan $pesanan) {
            if ($pesanan->wasChanged('status')) {
                Notifikasi::kirim(
                    userId: $pesanan->user_id,
                    judul: 'Status Pesanan Diperbarui',
                    pesan: "Pesanan \"{$pesanan->nama_produk}\" sekarang: {$pesanan->labelStatus()}.",
                    icon: $pesanan->status === 'dibatalkan' ? 'batal' : 'pengiriman',
                    url: route('profile.settings', ['tab' => 'riwayat'])
                );
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function confirmPaymentAndDecreaseStock(): void
    {
        DB::transaction(function () {
            $pesanan = self::query()->lockForUpdate()->findOrFail($this->id);

            if (! $pesanan->stok_dikurangi_at) {
                $this->reserveStockForLockedOrder($pesanan);
            }

            $pesanan->status = 'pembayaran_berhasil';
            $pesanan->save();
        });
    }

    public function completeAndRestoreStock(): void
    {
        DB::transaction(function () {
            $pesanan = self::query()->lockForUpdate()->findOrFail($this->id);
            $this->restoreStockForLockedOrder($pesanan);
            $pesanan->status = 'selesai';
            $pesanan->save();
        });
    }

    public function cancelAndRestoreStock(): void
    {
        DB::transaction(function () {
            $pesanan = self::query()->lockForUpdate()->findOrFail($this->id);
            $this->restoreStockForLockedOrder($pesanan);
            $pesanan->status = 'dibatalkan';
            $pesanan->save();
        });
    }

    public function reserveStock(): void
    {
        DB::transaction(function () {
            $pesanan = self::query()->lockForUpdate()->findOrFail($this->id);
            $this->reserveStockForLockedOrder($pesanan);
        });
    }

    private function reserveStockForLockedOrder(Pesanan $pesanan): void
    {
        if ($pesanan->stok_dikurangi_at) {
            return;
        }

        $produk = Produk::query()
            ->where('slug', $pesanan->produk_slug)
            ->lockForUpdate()
            ->first();

        $stokUkuran = $produk?->stok_ukuran ?? [];
        if (! $produk || ! array_key_exists($pesanan->size, $stokUkuran) || $stokUkuran[$pesanan->size] < 1) {
            throw ValidationException::withMessages([
                'status' => 'Stok ukuran ' . $pesanan->size . ' sudah tidak tersedia.',
            ]);
        }

        $stokUkuran[$pesanan->size]--;
        $produk->update(['stok_ukuran' => $stokUkuran]);
        $pesanan->stok_dikurangi_at = now();
        $pesanan->save();
    }

    private function restoreStockForLockedOrder(Pesanan $pesanan): void
    {
        if (! $pesanan->stok_dikurangi_at || $pesanan->stok_dikembalikan_at) {
            return;
        }

        $produk = Produk::query()
            ->where('slug', $pesanan->produk_slug)
            ->lockForUpdate()
            ->first();

        if ($produk) {
            $stokUkuran = $produk->stok_ukuran ?? [];
            $stokUkuran[$pesanan->size] = ($stokUkuran[$pesanan->size] ?? 0) + 1;
            $produk->update(['stok_ukuran' => $stokUkuran]);
        }

        $pesanan->stok_dikembalikan_at = now();
    }

    /**
     * Label status yang enak dibaca untuk ditampilkan ke user.
     */
    public function labelStatus(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'pembayaran_berhasil' => 'Pembayaran Berhasil',
            'selesai'             => 'Pesanan Selesai',
            'dibatalkan'          => 'Dibatalkan',
            default               => ucfirst($this->status),
        };
    }

    /**
     * Kelas warna badge Tailwind sesuai status, dipakai di Blade.
     */
    public function badgeClass(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'bg-amber-50 text-amber-600 border border-amber-200',
            'pembayaran_berhasil' => 'bg-blue-50 text-blue-600 border border-blue-200',
            'selesai'             => 'bg-emerald-50 text-emerald-600 border border-emerald-200',
            'dibatalkan'          => 'bg-red-50 text-red-600 border border-red-200',
            default               => 'bg-gray-50 text-gray-600 border border-gray-200',
        };
    }
}