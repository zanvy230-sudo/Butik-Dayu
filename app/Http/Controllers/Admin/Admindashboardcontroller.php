<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Pesanan;
use App\Models\PemesananRias;
use App\Support\ProdukData;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ============ STATISTIK ============

        $totalProduk = count(ProdukData::semua());

        // "Produk disewa" = jumlah BARIS pesanan produk yang statusnya masih aktif
        // (belum selesai/dibatalkan). Karena 1 baris Pesanan = 1 produk (lihat
        // fitur checkout multi-produk), ini otomatis menghitung per produk.
        $statusSelesaiAtauBatal = ['selesai', 'dibatalkan'];

        $produkDisewa = Pesanan::whereNotIn('status', $statusSelesaiAtauBatal)->count();

        // "Pesanan Aktif" = jumlah TRANSAKSI aktif (dikelompokkan lewat order_group),
        // beda dengan "Produk disewa" di atas kalau 1 transaksi berisi > 1 produk.
        // COALESCE dipakai supaya baris lama (sebelum fitur order_group ada,
        // order_group masih NULL) tetap terhitung sebagai transaksi terpisah.
        // Dipakai selectRaw + value() (bukan ->count()) supaya SQL COUNT(DISTINCT ...)
        // dieksekusi langsung, bukan dibungkus ulang oleh Eloquent yang mencari kolom asli.
        $pesananAktif = (int) Pesanan::whereNotIn('status', $statusSelesaiAtauBatal)
            ->selectRaw('COUNT(DISTINCT COALESCE(order_group, CONCAT("single-", id))) as total')
            ->value('total');

        // Total Pendapatan = jumlah semua pesanan yang statusnya "selesai"
        $totalPendapatan = Pesanan::where('status', 'selesai')->sum('total_pembayaran')
            + PemesananRias::where('status', 'selesai')->sum('paket_harga');

        $totalPesanan = Pesanan::count() + PemesananRias::count();
        $pesananMenunggu = Pesanan::whereIn('status', ['menunggu_konfirmasi'])
            ->count()
            + PemesananRias::whereIn('status', ['menunggu_transfer', 'menunggu_verifikasi', 'menunggu_konfirmasi'])
                ->count();
        $pesananSelesai = Pesanan::where('status', 'selesai')->count()
            + PemesananRias::where('status', 'selesai')->count();
        $pesananAktifGabungan = Pesanan::whereNotIn('status', ['selesai', 'dibatalkan'])->count()
            + PemesananRias::whereNotIn('status', ['selesai', 'dibatalkan'])->count();

        // ============ PESANAN TERBARU (gabungan Pesanan Produk + Pesanan Rias) ============

        $pesananProduk = Pesanan::latest()->take(10)->get()->map(function ($p) {
            return (object) [
                'kode'            => '#BTK' . str_pad((string) $p->id, 4, '0', STR_PAD_LEFT),
                'nama_pemesan'    => $p->nama_penerima ?? '-',
                'produk_layanan'  => $p->nama_produk,
                'gambar'          => $p->gambar_produk,
                'tanggal'         => $p->created_at,
                'total'           => $p->total_pembayaran,
                'status_label'    => method_exists($p, 'labelStatus') ? $p->labelStatus() : ucfirst(str_replace('_', ' ', $p->status)),
                'status_badge'    => method_exists($p, 'badgeClass') ? $p->badgeClass() : 'bg-brand-50 text-brand-600',
            ];
        });

        $pesananRias = PemesananRias::latest()->take(10)->get()->map(function ($r) {
            return (object) [
                'kode'            => '#BTK-R' . str_pad((string) $r->id, 4, '0', STR_PAD_LEFT),
                'nama_pemesan'    => $r->nama_lengkap,
                'produk_layanan'  => $r->paket_nama,
                'gambar'          => null,
                'tanggal'         => $r->created_at,
                'total'           => $r->paket_harga,
                'status_label'    => method_exists($r, 'labelStatus') ? $r->labelStatus() : ucfirst(str_replace('_', ' ', $r->status)),
                'status_badge'    => method_exists($r, 'badgeClass') ? $r->badgeClass() : 'bg-brand-50 text-brand-600',
            ];
        });

        $pesananTerbaru = $pesananProduk
            ->concat($pesananRias)
            ->sortByDesc('tanggal')
            ->take(6)
            ->values();

        return view('admin.dashboard', [
            'totalProduk'     => $totalProduk,
            'produkDisewa'    => $produkDisewa,
            'pesananAktif'    => $pesananAktif,
            'totalPendapatan' => $totalPendapatan,
            'totalPesanan'    => $totalPesanan,
            'pesananMenunggu' => $pesananMenunggu,
            'pesananSelesai'  => $pesananSelesai,
            'pesananAktifGabungan' => $pesananAktifGabungan,
            'pesananTerbaru'  => $pesananTerbaru,
        ]);
    }
        /**
     * Ubah status pesanan PRODUK oleh admin, lalu kirim notifikasi ke user.
     */
    public function updateStatusPesanan(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu_konfirmasi,pembayaran_berhasil,selesai,dibatalkan'],
        ]);

        if ($validated['status'] === 'pembayaran_berhasil') {
            $pesanan->confirmPaymentAndDecreaseStock();
        } elseif ($validated['status'] === 'selesai') {
            $pesanan->completeAndRestoreStock();
        } elseif ($validated['status'] === 'dibatalkan') {
            $pesanan->cancelAndRestoreStock();
        } else {
            $pesanan->update(['status' => $validated['status']]);
        }

        return back()->with('status', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Ubah status pemesanan LAYANAN RIAS oleh admin, lalu kirim notifikasi ke user.
     */
    public function updateStatusRias(Request $request, PemesananRias $pemesananRias)
    {
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $pemesananRias->update(['status' => $validated['status']]);

        Notifikasi::kirim(
            $pemesananRias->user_id,
            'koleksi',
            'Status Pemesanan Rias Diperbarui',
            'Pemesanan ' . $pemesananRias->paket_nama . ' sekarang berstatus "' . (method_exists($pemesananRias, 'labelStatus') ? $pemesananRias->labelStatus() : $pemesananRias->status) . '".',
            route('profile.settings', ['tab' => 'riwayat'])
        );

        return back()->with('status', 'Status pemesanan rias berhasil diperbarui.');
    }
}