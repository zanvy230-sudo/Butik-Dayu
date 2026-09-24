<?php

namespace App\Http\Controllers;

use App\Models\UlasanProduk;
use App\Support\ProdukData;

class ProdukController extends Controller
{
    public function show(string $slug)
    {
        $produk = ProdukData::cari($slug);

        abort_if(! $produk, 404);

        $produkTerkait = ProdukData::terkait($slug);

        $ulasanProdukList = UlasanProduk::where('produk_slug', $slug)
            ->with('user')
            ->latest()
            ->get();

        return view('produk.show', [
            'produk' => $produk,
            'slug' => $slug,
            'produkTerkait' => $produkTerkait,
            'ulasanProdukList' => $ulasanProdukList,
        ]);
    }
}