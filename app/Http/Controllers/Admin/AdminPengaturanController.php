<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminPengaturanController extends Controller
{
    private const DEFAULTS = [
        'logo_footer' => '',
        'logo_navbar' => '',
        'hero_banner' => '',
        'portfolio_1' => '',
        'portfolio_2' => '',
        'portfolio_3' => '',
        'portfolio_4' => '',
        'portfolio_5' => '',
        'portfolio_6' => '',
        'portfolio_7' => '',
        'portfolio_8' => '',
        'hero_judul' => 'Tampil Anggun di Hari Istimewa.',
        'hero_deskripsi' => 'Temukan busana adat dan layanan rias terbaik untuk momen berharga Anda.',
        'whatsapp' => '085298608032',
        'instagram_username' => '@rentbydayu',
        'instagram' => 'https://instagram.com/rentbydayu',
        'email' => 'info@butikdayu.com',
        'alamat_toko' => 'Ruko Perumahan, Jl. Tambora Land III, Tamanyeleng, Barombong, Kabupaten Gowa, Sulawesi Selatan 90225',
        'jam_operasional' => 'Senin - Sabtu, 09.00 - 17.00',
        'kebijakan_pembayaran' => 'Pembayaran dilakukan sesuai instruksi pada halaman checkout.',
        'kebijakan_pemesanan' => 'Pastikan data acara dan alamat sudah benar sebelum mengirim pesanan.',
    ];

    public function index(): View
    {
        $settings = collect(self::DEFAULTS)->mapWithKeys(function (string $default, string $key) {
            return [$key => SiteSetting::get($key, $default)];
        });

        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'logo_footer' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo_navbar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hero_banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'hero_judul' => ['required', 'string', 'max:255'],
            'hero_deskripsi' => ['nullable', 'string', 'max:1000'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'instagram_username' => ['nullable', 'string', 'max:100'],
            'instagram' => ['nullable', 'url', 'max:500'],
            'email' => ['nullable', 'email', 'max:255'],
            'alamat_toko' => ['nullable', 'string', 'max:1000'],
            'jam_operasional' => ['nullable', 'string', 'max:255'],
            'kebijakan_pembayaran' => ['nullable', 'string', 'max:2000'],
            'kebijakan_pemesanan' => ['nullable', 'string', 'max:2000'],
        ]);

        $imageKeys = ['logo_footer', 'logo_navbar', 'hero_banner'];
        for ($slot = 1; $slot <= 8; $slot++) {
            $imageKeys[] = 'portfolio_' . $slot;
            $request->validate([
                'portfolio_' . $slot => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            ]);
        }

        foreach ($imageKeys as $imageKey) {
            if ($request->hasFile($imageKey)) {
                $oldPath = SiteSetting::get($imageKey);
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }

                $validated[$imageKey] = $request->file($imageKey)->store('site-settings', 'public');
            } else {
                unset($validated[$imageKey]);
            }
        }

        SiteSetting::putMany($validated);

        return back()->with('status', 'Pengaturan website berhasil disimpan.');
    }

    public function uploadImage(Request $request, string $imageKey): RedirectResponse
    {
        $rules = [
            'logo_footer' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo_navbar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hero_banner' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];

        for ($slot = 1; $slot <= 8; $slot++) {
            $rules['portfolio_' . $slot] = ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
        }

        abort_unless(isset($rules[$imageKey]), 404);
        $request->validate([$imageKey => $rules[$imageKey]]);

        $oldPath = SiteSetting::get($imageKey);
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        SiteSetting::putMany([
            $imageKey => $request->file($imageKey)->store('site-settings', 'public'),
        ]);

        return back()->with('status', 'Foto berhasil diupload dan digunakan di website.');
    }

    public function removeImage(string $imageKey): RedirectResponse
    {
        $allowedKeys = ['logo_footer', 'logo_navbar', 'hero_banner'];
        for ($slot = 1; $slot <= 8; $slot++) {
            $allowedKeys[] = 'portfolio_' . $slot;
        }

        abort_unless(in_array($imageKey, $allowedKeys, true), 404);

        $path = SiteSetting::get($imageKey);
        if ($path) {
            Storage::disk('public')->delete($path);
            SiteSetting::where('key', $imageKey)->delete();
        } else {
            return back()->with('status', 'Gambar tersebut masih menggunakan gambar dari folder website, jadi tidak dihapus agar halaman lain tetap aman.');
        }

        return back()->with('status', 'Foto berhasil dihapus. Tampilan bawaan akan digunakan kembali.');
    }
}
