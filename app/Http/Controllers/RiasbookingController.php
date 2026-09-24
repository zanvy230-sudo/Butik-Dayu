<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Notifikasi;
use App\Models\PemesananRias;
use App\Support\PaketRiasData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiasBookingController extends Controller
{
    /**
     * Rekening tujuan transfer. Samakan dengan REKENING di
     * CheckoutController supaya konsisten (ganti keduanya sekaligus
     * kalau nomor rekening asli sudah ada).
     */
    private const REKENING = [
        ['bank' => 'BCA', 'nomor' => '1234567890', 'atas_nama' => 'Butik Dayu Indonesia'],
    ];

    public function show(Request $request, PemesananRias $pemesananRias)
    {
        abort_if($pemesananRias->user_id !== $request->user()->id, 404);

        return view('rias.show', [
            'pemesanan' => $pemesananRias,
        ]);
    }

    /**
     * Tampilkan form pemesanan untuk 1 paket tertentu.
     */
    public function create(string $paket)
    {
        $paketData = PaketRiasData::cari($paket);

        if (!$paketData) {
            return redirect()->route('layanan.index')
                ->with('status', 'Paket yang dipilih tidak ditemukan.');
        }

        $user = Auth::user();

        return view('layanan.layanan-pesan', [
            'paket' => $paketData,
            'namaLengkap' => $user?->name,
            'telepon' => $user?->phone,
            'alamatList' => Alamat::where('user_id', $user->id)
                ->orderByDesc('is_utama')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    /**
     * Simpan pemesanan ke database. Kalau metode Transfer Bank,
     * arahkan ke instruksi transfer. Kalau COD, langsung ke struk.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paket_slug' => ['required', 'string'],
            'alamat_id' => ['required', 'integer'],
            'tanggal_acara' => ['required', 'date', 'after_or_equal:today'],
            'jam_acara' => ['required'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'metode_pembayaran' => ['required', 'in:transfer,cod'],
        ], [
            'tanggal_acara.after_or_equal' => 'Tanggal acara tidak boleh sebelum hari ini.',
        ]);

        $alamat = Alamat::where('user_id', $request->user()->id)
            ->whereKey($validated['alamat_id'])
            ->first();

        if (! $alamat) {
            return back()
                ->withErrors(['alamat_id' => 'Silakan pilih alamat yang tersimpan di akun Anda.'])
                ->withInput();
        }

        $paketData = PaketRiasData::cari($validated['paket_slug']);

        if (!$paketData) {
            return back()->with('status', 'Paket yang dipilih tidak ditemukan.')->withInput();
        }

        $pemesanan = PemesananRias::create([
            'user_id' => $request->user()->id,
            'paket_slug' => $paketData['slug'],
            'paket_nama' => $paketData['nama'],
            'paket_harga' => $paketData['harga'],
            'nama_lengkap' => $alamat->nama_penerima,
            'telepon' => $alamat->telepon,
            'alamat_acara' => $alamat->alamat_lengkap,
            'tanggal_acara' => $validated['tanggal_acara'],
            'jam_acara' => $validated['jam_acara'],
            'catatan' => $validated['catatan'] ?? null,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status' => $validated['metode_pembayaran'] === 'transfer' ? 'menunggu_transfer' : 'menunggu_konfirmasi',
        ]);

        Notifikasi::kirim(
            $pemesanan->user_id,
            'koleksi',
            'Pemesanan Layanan Rias Diterima',
            'Pemesanan ' . $pemesanan->paket_nama . ' sedang kami proses.',
            route('profile.settings', ['tab' => 'riwayat'])
        );

        if ($validated['metode_pembayaran'] === 'transfer') {
            $request->session()->put('rias_pesanan_id', $pemesanan->id);

            return redirect()->route('rias.transfer');
        }

        // Metode COD: langsung tampilkan struk pemesanan.
        $request->session()->put('rias_pesanan_id', $pemesanan->id);

        return redirect()->route('rias.struk');
    }

    /**
     * Tampilkan halaman instruksi transfer bank untuk pemesanan rias.
     */
    public function transfer(Request $request)
    {
        $pemesanan = $this->ambilPemesananDariSession($request);

        if (!$pemesanan) {
            return redirect()->route('layanan.index');
        }

        return view('rias.transfer', [
            'pemesanan' => $pemesanan,
            'rekeningList' => self::REKENING,
        ]);
    }

    /**
     * User menekan tombol "Saya Sudah Transfer" beserta upload bukti transfer.
     */
    public function confirmTransfer(Request $request)
    {
        $pemesanan = $this->ambilPemesananDariSession($request);

        if (!$pemesanan) {
            return redirect()->route('layanan.index');
        }

        $request->validate([
            'bukti_transfer' => ['required', 'image', 'max:5120'],
        ], [
            'bukti_transfer.required' => 'Silakan upload screenshot bukti transfer terlebih dahulu.',
            'bukti_transfer.image' => 'File yang diupload harus berupa gambar (JPG/PNG).',
            'bukti_transfer.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');

        $pemesanan->update([
            'bukti_transfer' => $path,
            'status' => 'menunggu_verifikasi',
        ]);

        $request->session()->forget('rias_pesanan_id');

        return redirect()->route('layanan.index')
            ->with('status', 'Bukti transfer berhasil dikirim. Pemesanan Anda sedang kami verifikasi.');
    }

    /**
     * Tampilkan struk pemesanan (untuk metode COD).
     */
    public function struk(Request $request)
    {
        $pemesanan = $this->ambilPemesananDariSession($request);

        if (!$pemesanan) {
            return redirect()->route('layanan.index');
        }

        return view('rias.cod', [
            'pemesanan' => $pemesanan,
        ]);
    }

    /**
     * Helper: ambil record PemesananRias milik user yang login dari
     * ID yang tersimpan di session, pastikan itu benar-benar miliknya.
     */
    private function ambilPemesananDariSession(Request $request): ?PemesananRias
    {
        $id = $request->session()->get('rias_pesanan_id');

        if (!$id) {
            return null;
        }

        return PemesananRias::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();
    }
}