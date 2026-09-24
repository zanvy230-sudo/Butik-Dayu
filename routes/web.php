<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UlasanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RiasBookingController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\UlasanProdukController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Admin\AdminProdukController;
use App\Http\Controllers\admin\AdminPesananController;
use App\Http\Controllers\Admin\AdminPembayaranController;
use App\Http\Controllers\Admin\AdminUlasanController;
use App\Http\Controllers\Admin\AdminPengaturanController;
use App\Models\Ulasan;
use App\Models\SiteSetting;
// Halaman Beranda - bisa diakses siapa saja
Route::get('/', function () {
    $settingDefaults = [
        'nama_toko' => 'Butik Dayu',
        'tagline' => 'Tradisi Berpadu Elegansi.',
        'hero_judul' => 'Tampil Anggun di Hari Istimewa.',
        'hero_deskripsi' => 'Temukan busana adat dan layanan rias terbaik untuk momen berharga Anda.',
        'hero_banner' => '',
    ];

    return view('home', [
        'siteSettings' => collect($settingDefaults)->mapWithKeys(function (string $default, string $key) {
            return [$key => SiteSetting::get($key, $default)];
        }),
        'testimoni' => Ulasan::where('status', 'disetujui')
            ->where('ditampilkan', true)
            ->latest()
            ->take(3)
            ->get(),
    ]);
})->name('home');

// Halaman Login & Register HANYA untuk yang BELUM login.
// Kalau user yang sudah login coba buka /login atau /register,
// middleware 'guest' otomatis mengarahkan dia ke halaman Beranda.
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Logout HANYA untuk yang SUDAH login.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Halaman Katalog - bisa diakses siapa saja
Route::get('/katalog', function () {
    return view('katalog');
})->name('katalog.index');
//Detail Produk - bisa diakses siapa saja
Route::get('/katalog/{slug}', [ProdukController::class, 'show'])->name('katalog.show');
//layanan rias
Route::get('/layanan-rias', function () {
    return view('layanan');
})->name('layanan.index');
Route::post('/layanan-rias/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
//tentang kami
Route::get('/tentang-kami', function () {
    return view('tentang');
})->name('tentang');
//halaman profil user
Route::middleware('auth')->group(function () {
    Route::get('/notifikasi/data', [NotifikasiController::class, 'data'])->name('notifikasi.data');
    Route::patch('/notifikasi/{notifikasi}/baca', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::delete('/notifikasi/{notifikasi}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
    Route::post('/katalog/{slug}/ulasan', [UlasanProdukController::class, 'store'])->name('ulasan-produk.store');
    Route::get('/pengaturan', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::get('/pengaturan/riwayat', function () {
        return redirect()->route('profile.settings', ['tab' => 'riwayat']);
    })->name('profile.riwayat');
    Route::patch('/pengaturan', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pengaturan/alamat/tambah', [AlamatController::class, 'create'])->name('alamat.create');
    Route::post('/pengaturan/alamat', [AlamatController::class, 'store'])->name('alamat.store');
    Route::get('/pengaturan/alamat/{alamat}/ubah', [AlamatController::class, 'edit'])->name('alamat.edit');
    Route::patch('/pengaturan/alamat/{alamat}', [AlamatController::class, 'update'])->name('alamat.update');
    Route::patch('/pengaturan/alamat/{alamat}/utama', [AlamatController::class, 'setUtama'])->name('alamat.set-utama');
    Route::get('/pengaturan/keamanan/ubah-password', [SecurityController::class, 'editPassword'])->name('keamanan.edit-password');
    Route::patch('/pengaturan/keamanan/ubah-password', [SecurityController::class, 'updatePassword'])->name('keamanan.update-password');
    Route::patch('/pengaturan/keamanan/dua-langkah', [SecurityController::class, 'toggleTwoFactor'])->name('keamanan.toggle-2fa');

    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');

    // PENTING: cart.checkout HARUS didaftarkan SEBELUM cart.store, cart.update,
    // dan cart.remove, karena semuanya berpola "/keranjang/{sesuatu}" dengan
    // method yang sama (POST). Kalau cart.store didaftar duluan, request ke
    // /keranjang/checkout akan salah ditangkap sebagai {slug} = "checkout".
    Route::post('/keranjang/checkout', [CartController::class, 'proceedToCheckout'])->name('cart.checkout');

    Route::post('/keranjang/{slug}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/keranjang/{slug}', [CartController::class, 'updateQty'])->name('cart.update');
    Route::delete('/keranjang/{slug}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/layanan-rias/pesan/{paket}', [RiasBookingController::class, 'create'])->name('rias.pesan.create');
    Route::post('/layanan-rias/pesan', [RiasBookingController::class, 'store'])->name('rias.pesan.store');
    Route::get('/pemesanan-rias/{pemesananRias}', [RiasBookingController::class, 'show'])->name('rias.pemesanan.show');
    Route::get('/layanan-rias/transfer', [RiasBookingController::class, 'transfer'])->name('rias.transfer');
    Route::post('/layanan-rias/transfer/konfirmasi', [RiasBookingController::class, 'confirmTransfer'])->name('rias.transfer.confirm');
    Route::get('/layanan-rias/struk', [RiasBookingController::class, 'struk'])->name('rias.struk');

    // Detail pesanan hanya bisa dibuka oleh pemiliknya.
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');

    // Edit & Batalkan Pesanan (hanya untuk pemilik pesanan, status masih Menunggu Konfirmasi)
    Route::get('/pesanan/{pesanan}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
    Route::put('/pesanan/{pesanan}', [PesananController::class, 'update'])->name('pesanan.update');
    Route::patch('/pesanan/{pesanan}/batalkan', [PesananController::class, 'batalkan'])->name('pesanan.batalkan');
});
Route::middleware('auth')->group(function () {
    // 1. Route SPESIFIK dulu:
    Route::get('/checkout/transfer', [CheckoutController::class, 'transfer'])->name('checkout.transfer');
    Route::post('/checkout/transfer/konfirmasi', [CheckoutController::class, 'confirmTransfer'])->name('checkout.transfer.confirm');
    Route::get('/checkout/cod', [CheckoutController::class, 'cod'])->name('checkout.cod');

    // 2. BARU route wildcard-nya:
    Route::get('/checkout/{slug?}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});
Route::get('/bahasa/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('change.locale');

// ======================================================================
// ADMIN
// ======================================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Login admin - boleh diakses siapa saja (form-nya sendiri yang
    // menolak kalau role bukan admin, lihat AdminAuthController::login())
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');

    // Halaman admin yang WAJIB login DAN role = admin
   Route::middleware('admin')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/pesanan/{pesanan}/status', [AdminDashboardController::class, 'updateStatusPesanan'])->name('pesanan.update-status');
    Route::patch('/pemesanan-rias/{pemesananRias}/status', [AdminDashboardController::class, 'updateStatusRias'])->name('rias.update-status');
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/tambah', [AdminProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{produk}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{produk}', [AdminProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{produk}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/produk', [AdminPesananController::class, 'produk'])->name('pesanan.produk');
    Route::get('/pesanan/mua', [AdminPesananController::class, 'rias'])->name('pesanan.rias');
    Route::delete('/pesanan/produk/{pesanan}', [AdminPesananController::class, 'destroyProduk'])->name('pesanan.destroy-produk');
    Route::delete('/pesanan/mua/{pemesananRias}', [AdminPesananController::class, 'destroyRias'])->name('pesanan.destroy-rias');
    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
Route::patch('/pembayaran/{pesanan}/konfirmasi', [AdminPembayaranController::class, 'confirm'])->name('pembayaran.confirm');
    Route::patch('/pembayaran/rias/{pemesananRias}/konfirmasi', [AdminPembayaranController::class, 'confirmRias'])->name('pembayaran.rias.confirm');
    Route::get('/pelanggan', [AdminUlasanController::class, 'index'])->name('pelanggan.index');
    Route::patch('/pelanggan/ulasan/{ulasan}/setujui', [AdminUlasanController::class, 'approve'])->name('pelanggan.ulasan.approve');
    Route::patch('/pelanggan/ulasan/{ulasan}/tolak', [AdminUlasanController::class, 'reject'])->name('pelanggan.ulasan.reject');
    Route::patch('/pelanggan/ulasan/{ulasan}/beranda', [AdminUlasanController::class, 'toggleHomepage'])->name('pelanggan.ulasan.homepage');
    Route::get('/pengaturan', [AdminPengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [AdminPengaturanController::class, 'update'])->name('pengaturan.update');
    Route::post('/pengaturan/foto/{imageKey}', [AdminPengaturanController::class, 'uploadImage'])->name('pengaturan.image.upload');
    Route::delete('/pengaturan/foto/{imageKey}', [AdminPengaturanController::class, 'removeImage'])->name('pengaturan.image.remove');
});
});