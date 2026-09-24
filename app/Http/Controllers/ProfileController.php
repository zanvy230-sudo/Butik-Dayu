<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\PemesananRias;
use App\Models\Pesanan;
use App\Support\PesananData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman Pengaturan Akun.
     */
    public function settings(Request $request)
    {
        $alamatList = Alamat::where('user_id', $request->user()->getAuthIdentifier())
            ->orderByDesc('is_utama')
            ->orderByDesc('created_at')
            ->get();

        $pesananList = Pesanan::where('user_id', $request->user()->getAuthIdentifier())
            ->where('status', '!=', 'dibatalkan')
            ->latest()
            ->get();

        if ($pesananList->isEmpty()) {
            $pesananList = collect(PesananData::semua())->map(function (array $item) {
                $statusKey = match ($item['status']) {
                    'Pesanan dalam Perjalanan' => 'pembayaran_berhasil',
                    'Pesanan Selesai' => 'selesai',
                    default => 'menunggu_konfirmasi',
                };

                return new class($item, $statusKey) {
                    public string $kode;
                    public string $nama_produk;
                    public string $size;
                    public string $color;
                    public string $gambar_produk;
                    public int $total_pembayaran;
                    public string $status;
                    public Carbon $created_at;

                    public function __construct(array $item, string $statusKey)
                    {
                        $this->kode = $item['kode'];
                        $this->nama_produk = $item['nama'];
                        $this->size = $item['ukuran'];
                        $this->color = $item['warna'];
                        $this->gambar_produk = $item['gambar'];
                        $this->total_pembayaran = (int) $item['harga'];
                        $this->status = $statusKey;
                        $this->created_at = Carbon::now();
                    }

                    public function labelStatus(): string
                    {
                        return match ($this->status) {
                            'pembayaran_berhasil' => 'Pesanan dalam Perjalanan',
                            'selesai' => 'Pesanan Selesai',
                            default => 'Menunggu Konfirmasi',
                        };
                    }

                    public function badgeClass(): string
                    {
                        return match ($this->status) {
                            'pembayaran_berhasil' => 'bg-blue-50 text-blue-600 border border-blue-200',
                            'selesai' => 'bg-emerald-50 text-emerald-600 border border-emerald-200',
                            default => 'bg-amber-50 text-amber-600 border border-amber-200',
                        };
                    }
                };
            });
        }

        // Data pemesanan Layanan Rias, ditampilkan di sub-kategori
        // "Layanan Rias" pada tab Riwayat Pesanan.
        $pemesananRiasList = PemesananRias::where('user_id', $request->user()->getAuthIdentifier())
            ->latest()
            ->get();

        // Tab aktif ditentukan dari (urutan prioritas):
        // 1. Parameter URL ?tab=... (dipakai link "Edit alamat" dari halaman Checkout)
        // 2. Session 'active_tab' (dipakai redirect setelah tambah alamat)
        // 3. Default: 'informasi'
        $activeTab = $request->query('tab', session('active_tab', 'informasi'));

        return view('profile.settings', [
            'alamatList' => $alamatList,
            'pesananList' => $pesananList,
            'pemesananRiasList' => $pemesananRiasList,
            'activeTab' => $activeTab,
        ]);
    }

    /**
     * Simpan perubahan dari form "Informasi Akun".
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:perempuan,laki-laki'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'gender' => $validated['gender'],
        ]);

        return back()->with('status', 'Perubahan berhasil disimpan.');
    }
}
