<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function show(Request $request, Pesanan $pesanan)
    {
        abort_if($pesanan->user_id !== $request->user()->id, 404);

        return view('pesanan.show', [
            'pesanan' => $pesanan,
        ]);
    }

    /**
     * Pastikan pesanan ini milik user yang sedang login, dan statusnya
     * masih "Menunggu Konfirmasi" (belum diproses tim).
     */
    private function pastikanBolehDiubah(Request $request, Pesanan $pesanan): void
    {
        abort_if($pesanan->user_id !== $request->user()->id, 403);
        abort_if(
            $pesanan->status !== 'menunggu_konfirmasi',
            403,
            'Pesanan ini sudah diproses dan tidak bisa diubah lagi.'
        );
    }

    public function edit(Request $request, Pesanan $pesanan)
    {
        $this->pastikanBolehDiubah($request, $pesanan);

        return view('pesanan.edit', [
            'pesanan' => $pesanan,
        ]);
    }

 public function update(Request $request, Pesanan $pesanan)
{
    $this->pastikanBolehDiubah($request, $pesanan);

    $validated = $request->validate([
        'size'                  => ['nullable', 'string', 'max:20'],
        'color'                 => ['nullable', 'string', 'max:50'],
        'nama_penerima'         => ['required', 'string', 'max:255'],
        'telepon'               => ['required', 'string', 'max:20'],
        'alamat_lengkap'        => ['required', 'string'],
        'tanggal_sewa_mulai'    => ['required', 'date'],
        'tanggal_sewa_selesai'  => ['required', 'date', 'after_or_equal:tanggal_sewa_mulai'],
        'metode_pembayaran'     => ['required', 'in:transfer,cod'],
    ]);

    // Simpan metode lama SEBELUM di-update, untuk dibandingkan nanti
    $metodeSebelumnya = $pesanan->metode_pembayaran;

    $pesanan->update($validated);

    // Kalau metode pembayaran TIDAK berubah, kembali ke Riwayat Pesanan seperti biasa
    if ($validated['metode_pembayaran'] === $metodeSebelumnya) {
        return redirect()
            ->route('profile.settings', ['tab' => 'riwayat'])
            ->with('status', 'Pesanan berhasil diperbarui.');
    }

    // Kalau metode BERUBAH, siapkan session 'checkout_data' (format yang sama
    // dipakai halaman Instruksi Transfer & Struk COD) lalu arahkan ke sana.
    session(['checkout_data' => [
        'pesanan_id'           => $pesanan->id,
        'items'                => [[
            'nama'   => $pesanan->nama_produk,
            'gambar' => $pesanan->gambar_produk,
            'size'   => $pesanan->size,
            'color'  => $pesanan->color,
            'harga'  => $pesanan->total_pembayaran,
            'qty'    => 1,
        ]],
        'total_pembayaran'     => $pesanan->total_pembayaran,
        'nama_penerima'        => $pesanan->nama_penerima,
        'telepon'              => $pesanan->telepon,
        'alamat_lengkap'       => $pesanan->alamat_lengkap,
        'tanggal_sewa_mulai'   => optional($pesanan->tanggal_sewa_mulai)->format('Y-m-d'),
        'tanggal_sewa_selesai' => optional($pesanan->tanggal_sewa_selesai)->format('Y-m-d'),
    ]]);

    return $validated['metode_pembayaran'] === 'transfer'
        ? redirect()->route('checkout.transfer')
        : redirect()->route('checkout.cod');
}
    public function batalkan(Request $request, Pesanan $pesanan)
    {
        $this->pastikanBolehDiubah($request, $pesanan);

        $pesanan->cancelAndRestoreStock();

        return redirect()
            ->route('profile.settings', ['tab' => 'riwayat'])
            ->with('status', 'Pesanan berhasil dibatalkan.');
    }
}