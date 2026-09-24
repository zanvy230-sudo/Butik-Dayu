<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\PemesananRias;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminPesananController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * Tab "Semua" -> gabungan pesanan produk (sewa baju) + pemesanan Layanan Rias.
     */
    public function index(Request $request)
    {
        return $this->render($request, 'semua');
    }

    /**
     * Tab "Produk" -> cuma dari tabel pesanans.
     */
    public function produk(Request $request)
    {
        return $this->render($request, 'produk');
    }

    /**
     * Tab "MUA" -> cuma dari tabel pemesanan_rias.
     */
    public function rias(Request $request)
    {
        return $this->render($request, 'mua');
    }

    /**
     * Hapus 1 pesanan produk (baris tabel pesanans).
     */
    public function destroyProduk(Pesanan $pesanan)
    {
        if ($pesanan->status !== 'dibatalkan' && $pesanan->status !== 'selesai') {
            $pesanan->cancelAndRestoreStock();
        }
        $pesanan->delete();

        return back()->with('status', 'Pesanan produk berhasil dihapus.');
    }

    /**
     * Hapus 1 pemesanan layanan rias (baris tabel pemesanan_rias).
     */
    public function destroyRias(PemesananRias $pemesananRias)
    {
        $pemesananRias->delete();

        return back()->with('status', 'Pemesanan layanan rias berhasil dihapus.');
    }

    private function render(Request $request, string $jenisAktif)
    {
        $cari = trim((string) $request->query('cari'));

        $daftarProduk = collect();
        $daftarRias = collect();

        if ($jenisAktif !== 'mua') {
            $daftarProduk = Pesanan::with('user')
                ->when($cari !== '', function ($query) use ($cari) {
                    $query->where(function ($q) use ($cari) {
                        $q->where('nama_produk', 'like', "%{$cari}%")
                          ->orWhere('nama_penerima', 'like', "%{$cari}%")
                          ->orWhere('id', 'like', "%{$cari}%");
                    });
                })
                ->get()
                ->map(fn (Pesanan $p) => $this->normalisasiProduk($p));
        }

        if ($jenisAktif !== 'produk') {
            $daftarRias = PemesananRias::with('user')
                ->when($cari !== '', function ($query) use ($cari) {
                    $query->where(function ($q) use ($cari) {
                        $q->where('nama_lengkap', 'like', "%{$cari}%")
                          ->orWhere('paket_nama', 'like', "%{$cari}%")
                          ->orWhere('id', 'like', "%{$cari}%");
                    });
                })
                ->get()
                ->map(fn (PemesananRias $r) => $this->normalisasiRias($r));
        }

        // Gabung dua sumber data yang beda tabel, urutkan dari yang terbaru.
        // Karena datanya digabung manual di PHP (bukan query DB tunggal),
        // paginasinya juga harus dibuat manual lewat LengthAwarePaginator.
        $gabungan = $daftarProduk->concat($daftarRias)
            ->sortByDesc('tanggal_urut')
            ->values();

        $halaman = LengthAwarePaginator::resolveCurrentPage();
        $items = $gabungan->forPage($halaman, self::PER_PAGE)->values();

        $pesananList = new LengthAwarePaginator(
            $items,
            $gabungan->count(),
            self::PER_PAGE,
            $halaman,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pesanan.index', [
            'pesananList' => $pesananList,
            'jenisAktif'  => $jenisAktif,
            'cari'        => $cari,
        ]);
    }

    /**
     * Ubah 1 baris Pesanan jadi bentuk seragam untuk ditampilkan di tabel.
     *
     * Catatan: "kode" di sini DIBUAT OTOMATIS dari ID, bukan kolom
     * tersimpan di database (belum ada kolom kode pesanan). Offset 2000
     * cuma supaya tidak kebetulan sama angkanya dengan kode dari
     * PemesananRias di bawah -- murni kosmetik tampilan.
     */
    private function normalisasiProduk(Pesanan $p): array
    {
        return [
            'id'           => $p->id,
            'jenis_raw'    => 'produk',
            'kode'         => 'BTK' . (2000 + $p->id),
            'nama_pemesan' => $p->nama_penerima ?: optional($p->user)->name ?: '-',
            'jenis'        => 'Produk',
            'tanggal'      => $p->created_at,
            'tanggal_urut' => $p->created_at,
            'total'        => $p->total_pembayaran,
            'status_raw'   => $p->status,
            'label_status' => $p->labelStatus(),
            'badge_status' => $p->badgeClass(),
        ];
    }

    private function normalisasiRias(PemesananRias $r): array
    {
        return [
            'id'           => $r->id,
            'jenis_raw'    => 'rias',
            'kode'         => 'BTK' . (5000 + $r->id),
            'nama_pemesan' => $r->nama_lengkap ?: optional($r->user)->name ?: '-',
            'jenis'        => 'MUA',
            'tanggal'      => $r->created_at,
            'tanggal_urut' => $r->created_at,
            'total'        => $r->paket_harga,
            'label_status' => $r->labelStatus(),
            'badge_status' => $r->badgeClass(),
        ];
    }
}