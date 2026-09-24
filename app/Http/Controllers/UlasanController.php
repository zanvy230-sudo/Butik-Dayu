<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    private const KATA_TERLARANG = [
        'anjing', 'bangsat', 'brengsek', 'bodoh', 'babi', 'goblok', 'kontol',
        'memek', 'ngentot', 'perek', 'tolol', 'kampret', 'asu',
    ];

    /**
     * Simpan ulasan/permintaan yang dikirim dari form di halaman Layanan Rias.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'whatsapp'      => ['required', 'string', 'max:20'],
            'tanggal_acara' => ['nullable', 'date'],
            'paket'         => ['nullable', 'in:akad,resepsi,pre-wedding'],
            'ulasan'        => ['required', 'string', 'max:2000'],
        ], [
            'nama.required'     => 'Nama wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'ulasan.required'   => 'Ulasan tidak boleh kosong.',
        ]);

        $teksUlasan = mb_strtolower($validated['ulasan']);
        foreach (self::KATA_TERLARANG as $kata) {
            if (preg_match('/\b' . preg_quote($kata, '/') . '\b/u', $teksUlasan)) {
                return back()
                    ->withInput()
                    ->withErrors(['ulasan' => 'Ulasan mengandung kata yang tidak diperbolehkan.']);
            }
        }

        Ulasan::create($validated + [
            'status' => 'menunggu',
            'ditampilkan' => false,
        ]);

        return back()
            ->with('ulasan_success', 'Terima kasih! Ulasan/permintaan kamu sudah kami terima.');
    }
}
