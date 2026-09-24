<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUlasanController extends Controller
{
    public function index(): View
    {
        return view('admin.pelanggan.index', [
            'ulasanList' => Ulasan::latest()->get(),
        ]);
    }

    public function approve(Ulasan $ulasan): RedirectResponse
    {
        $ulasan->update(['status' => 'disetujui']);

        return back()->with('status', 'Ulasan disetujui. Pilih "Tampilkan" jika ingin menampilkannya di beranda.');
    }

    public function reject(Ulasan $ulasan): RedirectResponse
    {
        $ulasan->update([
            'status' => 'ditolak',
            'ditampilkan' => false,
        ]);

        return back()->with('status', 'Ulasan ditolak dan tidak akan tampil di beranda.');
    }

    public function toggleHomepage(Ulasan $ulasan): RedirectResponse
    {
        if ($ulasan->status !== 'disetujui') {
            return back()->with('status', 'Ulasan harus disetujui terlebih dahulu.');
        }

        $ulasan->update(['ditampilkan' => ! $ulasan->ditampilkan]);

        return back()->with('status', $ulasan->ditampilkan
            ? 'Ulasan sekarang tampil di beranda.'
            : 'Ulasan disembunyikan dari beranda.');
    }
}