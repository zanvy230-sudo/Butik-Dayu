<?php

namespace App\Http\Controllers;

use App\Models\UlasanProduk;
use App\Support\ProdukData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UlasanProdukController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        abort_if(! ProdukData::cari($slug), 404);

        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'rating'   => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['required', 'string', 'max:1000'],
            'foto'     => ['nullable', 'image', 'max:5120'], // maksimal 5MB
        ], [
            'nama.required'     => 'Nama wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'rating.required'   => 'Mohon beri rating bintang.',
            'komentar.required' => 'Ulasan tidak boleh kosong.',
            'foto.image'        => 'File yang diupload harus berupa gambar (JPG/PNG).',
            'foto.max'          => 'Ukuran foto maksimal 5MB.',
        ]);

        // Simpan foto ke storage/app/public/ulasan-produk kalau user melampirkan.
        // Butuh "php artisan storage:link" (sekali saja) supaya bisa diakses browser.
        $pathFoto = $request->hasFile('foto')
            ? $request->file('foto')->store('ulasan-produk', 'public')
            : null;

        UlasanProduk::create([
            'user_id'     => $request->user()->id,
            'nama'        => $validated['nama'],
            'whatsapp'    => $validated['whatsapp'],
            'produk_slug' => $slug,
            'rating'      => $validated['rating'],
            'komentar'    => $validated['komentar'],
            'foto'        => $pathFoto,
        ]);

        return back()->with('status', 'Terima kasih! Ulasan kamu sudah dikirim.');
    }
}