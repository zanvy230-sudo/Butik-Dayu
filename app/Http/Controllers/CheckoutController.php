<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Pesanan;
use App\Support\ProdukData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Rekening tujuan transfer. Ganti nomor & nama ini dengan rekening
     * asli Butik Dayu sebelum dipakai sungguhan. Tambahkan entri baru
     * di sini kalau nanti mau menerima transfer ke lebih dari 1 bank.
     */
    private const REKENING = [
        ['bank' => 'BCA', 'nomor' => '1234567890', 'atas_nama' => 'Butik Dayu Indonesia'],
    ];

    /**
     * Ambil daftar alamat user yang tersimpan. Kalau user belum punya
     * alamat di database, return collection kosong supaya halaman checkout
     * menampilkan state "belum ada alamat" dan bukan data dummy.
     */
    private function getAlamatList(?\App\Models\User $user)
    {
        $userId = $user?->id;

        if (! $userId) {
            return collect();
        }

        return Alamat::where('user_id', $userId)
            ->orderByDesc('is_utama')
            ->orderByDesc('created_at')
            ->get();
    }

    private function normalizeCheckoutData(array $checkout): array
    {
        if (! isset($checkout['items'])) {
            $checkout['items'] = [[
                'nama'   => $checkout['nama_produk'] ?? 'Produk Butik Dayu',
                'gambar' => $checkout['gambar_produk'] ?? null,
                'size'   => $checkout['size'] ?? '-',
                'color'  => $checkout['color'] ?? '-',
                'harga'  => $checkout['total_pembayaran'] ?? 0,
                'qty'    => 1,
            ]];
        }

        return $checkout;
    }

    /**
     * Tampilkan halaman Checkout Produk.
     */
    public function show(Request $request, ?string $slug = null)
    {
        $produk = $slug ? ProdukData::cari($slug) : null;

        // Kalau produk tidak ditemukan, pakai produk pertama yang benar-benar
        // ada di database admin. Jangan mengandalkan produk lama / hardcode.
        if (! $produk) {
            $produkList = ProdukData::semua();
            $fallbackProduk = $produkList ? reset($produkList) : null;

            if (! $fallbackProduk) {
                abort(404, 'Produk tidak ditemukan.');
            }

            $slug = $fallbackProduk['slug'] ?? null;
            $produk = $fallbackProduk;
        }

        $user = Auth::user();
        $alamatList = $this->getAlamatList($user);

        // Hitung rincian biaya dari data produk yang benar-benar ada di DB.
        $hargaProduk = (int) ($produk['harga'] ?? 0);
        $biayaTambahanSewa = 0;
        $totalPembayaran = $hargaProduk;

        $ukuranList = is_array($produk['stok_ukuran'] ?? null) ? $produk['stok_ukuran'] : [];

        // Default ukuran: pakai dari query string kalau valid & masih ada
        // stoknya, kalau tidak, pakai ukuran pertama yang stoknya > 0.
        $sizeDariQuery = $request->query('size');
        if ($sizeDariQuery && ($ukuranList[$sizeDariQuery] ?? 0) > 0) {
            $size = $sizeDariQuery;
        } else {
            $size = collect($ukuranList)->filter(fn ($stok) => $stok > 0)->keys()->first();
            if (! $size && ! empty($ukuranList)) {
                $size = array_key_first($ukuranList);
            }
        }

        $color = $request->query('color', 'Gold');

        return view('checkout', [
            'slug'            => $slug,
            'produk'          => $produk,
            'alamatList'      => $alamatList,
            'hargaProduk'     => $hargaProduk,
            'biayaTambahanSewa' => $biayaTambahanSewa,
            'totalPembayaran' => $totalPembayaran,
            'ukuranList'      => $ukuranList,
            'size'            => $size,
            'color'           => $color,
        ]);
    }

    /**
     * Proses checkout pesanan. Kalau metode pembayarannya Transfer Bank,
     * arahkan ke halaman instruksi transfer. Kalau COD, langsung anggap
     * pesanan dibuat (belum ada tabel "pesanan" sungguhan di database).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran'    => ['required', 'in:transfer,cod'],
            'alamat_id'            => ['nullable'],
            'slug'                 => ['nullable', 'string'],
            'nama_produk'          => ['nullable', 'string'],
            'gambar_produk'        => ['nullable', 'string'],
            'size'                 => ['required', 'string'],
            'color'                => ['nullable', 'string'],
            'tanggal_sewa_mulai'   => ['required', 'date', 'after_or_equal:today'],
            'tanggal_sewa_selesai' => ['required', 'date', 'after_or_equal:tanggal_sewa_mulai'],
        ], [
            'size.required'                       => 'Silakan pilih ukuran terlebih dahulu.',
            'tanggal_sewa_mulai.after_or_equal'   => 'Tanggal mulai sewa tidak boleh sebelum hari ini.',
            'tanggal_sewa_selesai.after_or_equal' => 'Tanggal selesai sewa tidak boleh sebelum tanggal mulai sewa.',
        ]);

        // Pastikan ukuran yang dipilih benar-benar ada & stoknya masih
        // tersedia untuk produk ini (jaga-jaga kalau user mengubah value
        // lewat DevTools, atau stok habis persis saat proses checkout).
        $produk = ProdukData::cari($validated['slug'] ?? '');
        $hargaProduk = (int) ($produk['harga'] ?? 0);
        $ukuranList = $produk['stok_ukuran'] ?? [];
        $stokUkuranTerpilih = $ukuranList[$validated['size']] ?? null;

        if ($stokUkuranTerpilih === null || $stokUkuranTerpilih < 1) {
            throw ValidationException::withMessages([
                'size' => 'Ukuran ' . $validated['size'] . ' sudah tidak tersedia. Silakan pilih ukuran lain.',
            ]);
        }

        // Cari detail alamat yang dipilih user di halaman Checkout sebelumnya.
        // Kalau tidak ada alamat yang valid tersimpan, jangan lanjutkan checkout
        // dengan data dummy / kosong karena itu akan menimbulkan pesanan tanpa
        // data penerima yang benar.
        $alamatList = $this->getAlamatList($request->user());
        $alamatTerpilih = $alamatList->first(fn ($a) => (string) $a->id === (string) ($validated['alamat_id'] ?? ''));

        if (! $alamatTerpilih) {
            throw ValidationException::withMessages([
                'alamat_id' => 'Silakan pilih atau tambahkan alamat pengiriman terlebih dahulu.',
            ]);
        }

        $tanggalMulai = Carbon::parse($validated['tanggal_sewa_mulai']);
        $tanggalSelesai = Carbon::parse($validated['tanggal_sewa_selesai']);
        $jumlahHariSewa = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
        $biayaTambahanSewa = max(0, $jumlahHariSewa - 2) * 25000;
        $totalPembayaran = $hargaProduk + $biayaTambahanSewa;

        $pesanan = DB::transaction(function () use ($request, $validated, $totalPembayaran, $alamatTerpilih) {
            $pesanan = Pesanan::create([
                'user_id'              => $request->user()->id,
                'produk_slug'          => $validated['slug'] ?? null,
                'nama_produk'          => $validated['nama_produk'] ?? 'Produk Butik Dayu',
                'gambar_produk'        => $validated['gambar_produk'] ?? null,
                'size'                 => $validated['size'] ?? null,
                'color'                => $validated['color'] ?? null,
                'total_pembayaran'     => $totalPembayaran,
                'metode_pembayaran'    => $validated['metode_pembayaran'],
                'nama_penerima'        => $alamatTerpilih->nama_penerima ?? null,
                'telepon'              => $alamatTerpilih->telepon ?? null,
                'alamat_lengkap'       => $alamatTerpilih->alamat_lengkap ?? null,
                'tanggal_sewa_mulai'   => $validated['tanggal_sewa_mulai'],
                'tanggal_sewa_selesai' => $validated['tanggal_sewa_selesai'],
                'status'               => 'menunggu_konfirmasi',
            ]);

            $pesanan->reserveStock();

            return $pesanan->fresh();
        });

        $checkoutData = [
            'pesanan_id'           => $pesanan->id,
            'nama_produk'          => $pesanan->nama_produk,
            'gambar_produk'        => $pesanan->gambar_produk,
            'items'                => [[
                'nama'   => $pesanan->nama_produk,
                'gambar' => $pesanan->gambar_produk,
                'size'   => $pesanan->size ?? '-',
                'color'  => $pesanan->color ?? '-',
                'harga'  => $hargaProduk,
                'qty'    => 1,
            ]],
            'size'                 => $pesanan->size ?? '-',
            'color'                => $pesanan->color ?? '-',
            'total_pembayaran'     => $pesanan->total_pembayaran,
            'nama_penerima'        => $pesanan->nama_penerima,
            'telepon'              => $pesanan->telepon,
            'alamat_lengkap'       => $pesanan->alamat_lengkap,
            'tanggal_sewa_mulai'   => $validated['tanggal_sewa_mulai'],
            'tanggal_sewa_selesai' => $validated['tanggal_sewa_selesai'],
        ];

        if ($validated['metode_pembayaran'] === 'transfer') {
            // Simpan ID pesanan di session, dibaca lagi oleh halaman
            // instruksi transfer untuk tahu pesanan mana yang diupdate
            // setelah user upload bukti transfer.
            $request->session()->put('checkout_data', $checkoutData);

            return redirect()->route('checkout.transfer');
        }

        // Metode COD: pesanan sudah tersimpan di atas, arahkan ke halaman
        // struk supaya user bisa lihat & download ringkasan pesanannya.
        $request->session()->put('checkout_data', $checkoutData);

        return redirect()->route('checkout.cod');
    }

    /**
     * Tampilkan halaman struk pesanan COD.
     */
    public function cod(Request $request)
    {
        $checkout = $request->session()->get('checkout_data');

        // Kalau user buka halaman ini langsung tanpa checkout dulu,
        // tidak ada data tersimpan → lempar balik ke Katalog.
        if (! $checkout) {
            return redirect()->route('katalog.index');
        }

        $checkout = $this->normalizeCheckoutData($checkout);

        // Data sudah dipakai untuk ditampilkan di halaman struk ini.
        // Dibersihkan dari session supaya tidak "nyangkut" dan
        // kebawa-bawa kalau nanti session_data lama belum sempat
        // ditimpa oleh checkout produk berikutnya.
        $request->session()->forget('checkout_data');

        return view('checkout.cod', [
            'checkout' => $checkout,
        ]);
    }

    /**
     * Tampilkan halaman instruksi transfer bank.
     */
    public function transfer(Request $request)
    {
        $checkout = $request->session()->get('checkout_data');

        // Kalau user buka halaman ini langsung tanpa checkout dulu,
        // tidak ada data tersimpan → lempar balik ke Katalog.
        if (! $checkout) {
            return redirect()->route('katalog.index');
        }

        $checkout = $this->normalizeCheckoutData($checkout);

        return view('checkout.transfer', [
            'checkout' => $checkout,
            'rekeningList' => self::REKENING,
        ]);
    }

    /**
     * User menekan tombol "Saya Sudah Transfer" beserta upload bukti transfer.
     */
    public function confirmTransfer(Request $request)
    {
        $request->validate([
            'bukti_transfer' => ['required', 'image', 'max:5120'], // maksimal 5MB
        ], [
            'bukti_transfer.required' => 'Silakan upload screenshot bukti transfer terlebih dahulu.',
            'bukti_transfer.image' => 'File yang diupload harus berupa gambar (JPG/PNG).',
            'bukti_transfer.max' => 'Ukuran file maksimal 5MB.',
        ]);

        // Simpan file ke storage/app/public/bukti-transfer
        // (butuh "php artisan storage:link" sekali saja supaya bisa diakses lewat browser)
        $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');

        $checkout = $request->session()->get('checkout_data');

        // Tempelkan bukti transfer ke pesanan yang tadi dibuat di store().
        // Statusnya tetap "menunggu_konfirmasi" sampai admin memverifikasi manual.
        if ($checkout && ! empty($checkout['pesanan_id'])) {
            Pesanan::where('id', $checkout['pesanan_id'])
                ->where('user_id', $request->user()->id)
                ->update(['bukti_transfer' => $path]);
        }

        $request->session()->forget('checkout_data');

        return redirect()
            ->route('profile.settings', ['tab' => 'riwayat'])
            ->with('status', 'Bukti transfer berhasil dikirim. Pesanan Anda sedang kami verifikasi.');
    }
}