<?php

namespace App\Http\Controllers;

use App\Support\ProdukData;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Data contoh, dipakai hanya kalau session cart masih kosong
     * (supaya halaman ini langsung bisa dicoba). Harga di sini
     * SENGAJA disamakan dengan mockup, bisa beda sedikit dari
     * ProdukData.php.
     */
    private const CONTOH_ISI_KERANJANG = [
        'sunda-siger' => [
            'nama' => 'Kebaya Siger Sunda',
            'gambar' => '/images/Logo_butik.png',
            'size' => 'M',
            'color' => 'White',
            'harga' => 8500000,
            'qty' => 1,
        ],
        'payas-agung' => [
            'nama' => 'Payas Agung Royal',
            'gambar' => '/images/Logo_butik.png',
            'size' => 'XL',
            'color' => 'Gold',
            'harga' => 10500000,
            'qty' => 1,
        ],
        'minang-suntiang' => [
            'nama' => 'Minang Suntiang',
            'gambar' => '/images/Logo_butik.png',
            'size' => 'M',
            'color' => 'Maroon',
            'harga' => 9000000,
            'qty' => 1,
        ],
    ];

    /**
     * Tambahkan 1 produk ke keranjang dari tombol keranjang
     * di halaman Detail Produk. Kalau produk sudah ada di
     * keranjang, tinggal tambah qty-nya.
     */
    public function store(Request $request, string $slug)
    {
        $produk = ProdukData::cari($slug);

        if (! $produk) {
            return back()->with('status', 'Produk tidak ditemukan.');
        }

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$slug])) {
            $cart[$slug]['qty']++;
        } else {
            $cart[$slug] = [
                'nama'  => $produk['nama'],
                'gambar' => $produk['gambar_utama'],
                'size'  => 'One Size',
                'color' => '-',
                'harga' => $produk['harga'],
                'qty'   => 1,
            ];
        }

        $request->session()->put('cart', $cart);

        return back()->with('status', $produk['nama'] . ' berhasil ditambahkan ke keranjang.');
    }

    /**
     * Tampilkan halaman Keranjang Belanja.
     */
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart');

        // Session belum pernah diisi sama sekali -> pakai data contoh.
        if ($cart === null) {
            $cart = self::CONTOH_ISI_KERANJANG;
            $request->session()->put('cart', $cart);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return view('keranjang.index', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    /**
     * Tambah / kurangi jumlah salah satu item.
     */
    public function updateQty(Request $request, string $slug)
    {
        $request->validate([
            'action' => ['required', 'in:tambah,kurang'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$slug])) {
            if ($request->action === 'tambah') {
                $cart[$slug]['qty']++;
            } else {
                $cart[$slug]['qty'] = max(1, $cart[$slug]['qty'] - 1);
            }
        }

        $request->session()->put('cart', $cart);

        return back();
    }

    /**
     * Hapus salah satu item dari keranjang.
     */
    public function remove(Request $request, string $slug)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$slug]);
        $request->session()->put('cart', $cart);

        return back()->with('status', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * User klik "Lanjutkan ke Pembayaran" -> baca produk mana saja yang
     * dicentang (dikirim lewat input produk[] dari JS di halaman keranjang),
     * lalu kirim SEMUANYA (boleh lebih dari 1) ke halaman Checkout sekaligus.
     */
    public function proceedToCheckout(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('katalog.index');
        }

        $dipilih = $request->input('produk', []);

        if (empty($dipilih)) {
            return back()->with('status', 'Pilih minimal 1 produk terlebih dahulu.');
        }

        // Susun daftar produk yang dicentang, lengkap dengan size/color/harga/qty
        // dari session cart, untuk dibawa ke halaman Checkout.
        $items = [];
        foreach ($dipilih as $slug) {
            if (! isset($cart[$slug])) {
                continue; // jaga-jaga kalau ada slug aneh yang tidak ada di keranjang
            }

            $items[] = [
                'slug'  => $slug,
                'nama'  => $cart[$slug]['nama'],
                'gambar' => $cart[$slug]['gambar'],
                'size'  => $cart[$slug]['size'],
                'color' => $cart[$slug]['color'],
                'harga' => $cart[$slug]['harga'],
                'qty'   => $cart[$slug]['qty'],
            ];
        }

        if (empty($items)) {
            return back()->with('status', 'Produk yang dipilih tidak ditemukan di keranjang.');
        }

        // Simpan daftar produk terpilih (bisa lebih dari 1) di session,
        // dibaca oleh CheckoutController::show().
        $request->session()->put('checkout_items', $items);

        $firstSlug = $items[0]['slug'] ?? null;

        if ($firstSlug) {
            return redirect()->route('checkout.show', ['slug' => $firstSlug]);
        }

        return redirect()->route('checkout.show');
    }
}
