<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\PemesananRias;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'menunggu');

        $pesananQuery = Pesanan::query();
        $riasQuery = PemesananRias::query();

        if ($tab === 'menunggu') {
            $pesananQuery->where('status', 'menunggu_konfirmasi');
            $riasQuery->where('status', 'menunggu_verifikasi');
        }

        $pesanan = $pesananQuery->get()->each(function (Pesanan $pesanan) {
            $pesanan->jenis_pembayaran = 'produk';
            $pesanan->nama_pemesan_display = $pesanan->nama_penerima;
            $pesanan->total_display = $pesanan->total_pembayaran;
        });
        $rias = $riasQuery->get()->each(function (PemesananRias $pemesanan) {
            $pemesanan->jenis_pembayaran = 'rias';
            $pemesanan->nama_pemesan_display = $pemesanan->nama_lengkap;
            $pemesanan->total_display = $pemesanan->paket_harga;
        });

        $semuaPembayaran = $pesanan->concat($rias)->sortByDesc('created_at')->values();
        $jumlahMenunggu = Pesanan::where('status', 'menunggu_konfirmasi')->count()
            + PemesananRias::where('status', 'menunggu_verifikasi')->count();

        $perPage = 6;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pembayaranList = new LengthAwarePaginator(
            $semuaPembayaran->forPage($currentPage, $perPage)->values(),
            $semuaPembayaran->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pembayaran.index', [
            'pembayaranList' => $pembayaranList,
            'jumlahMenunggu' => $jumlahMenunggu,
            'tab'            => $tab,
        ]);
    }

    /**
     * Admin menekan tombol "Konfirmasi" — status pesanan langsung berubah
     * jadi "pembayaran_berhasil", otomatis kelihatan di Riwayat Pesanan
     * user, dan user dikirimi notifikasi.
     */
    public function confirm(Pesanan $pesanan)
    {
        $pesanan->confirmPaymentAndDecreaseStock();

        return back()->with('status', 'Pembayaran pesanan ' . $pesanan->nama_produk . ' berhasil dikonfirmasi.');
    }

    public function confirmRias(PemesananRias $pemesananRias)
    {
        $pemesananRias->update(['status' => 'dikonfirmasi']);

        Notifikasi::kirim(
            $pemesananRias->user_id,
            'koleksi',
            'Pembayaran Dikonfirmasi',
            'Pembayaran untuk pemesanan ' . $pemesananRias->paket_nama . ' sudah kami konfirmasi.',
            route('profile.settings', ['tab' => 'riwayat'])
        );

        return back()->with('status', 'Pembayaran pemesanan rias ' . $pemesananRias->paket_nama . ' berhasil dikonfirmasi.');
    }
}