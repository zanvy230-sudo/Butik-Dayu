<?php

namespace App\Providers;

use App\Models\Notifikasi;
use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Semua ->links() di seluruh aplikasi (Daftar Produk, Pembayaran,
        // Pesanan, dll) otomatis pakai tampilan paginasi custom bertema
        // brand ini, tidak perlu diubah satu-satu di tiap file Blade.
        Paginator::defaultView('vendor.pagination.custom');

        // View Composer: setiap kali partials.navbar dirender, otomatis
        // suntik data notifikasi (5 terbaru + jumlah yang belum dibaca)
        // tanpa perlu ditambahkan manual di tiap controller/route.
        View::composer('partials.navbar', function ($view) {
            if (Auth::check()) {
                $notifikasiList = Notifikasi::where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $notifikasiUnreadCount = Notifikasi::where('user_id', Auth::id())
                    ->belumDibaca()
                    ->count();
            } else {
                $notifikasiList = collect();
                $notifikasiUnreadCount = 0;
            }

            $view->with([
                'notifikasiList' => $notifikasiList,
                'notifikasiUnreadCount' => $notifikasiUnreadCount,
                'logoNavbar' => SiteSetting::get('logo_navbar'),
            ]);
        });

        View::composer('partials.footer', function ($view) {
            $view->with('logoFooter', SiteSetting::get('logo_footer'));
        });

        View::share('heroBanner', SiteSetting::get('hero_banner'));
        View::share('portfolioImages', collect(range(1, 8))
            ->map(fn (int $slot) => SiteSetting::get('portfolio_' . $slot))
            ->filter()
            ->values());

        $whatsapp = SiteSetting::get('whatsapp', '085298608032');
        $whatsappNumber = preg_replace('/\D+/', '', $whatsapp);
        if (str_starts_with($whatsappNumber, '0')) {
            $whatsappNumber = '62' . substr($whatsappNumber, 1);
        }

        View::share('contactSettings', [
            'whatsapp' => $whatsapp,
            'whatsapp_url' => 'https://wa.me/' . $whatsappNumber,
            'instagram_username' => SiteSetting::get('instagram_username', '@rentbydayu'),
            'instagram' => SiteSetting::get('instagram', 'https://instagram.com/rentbydayu'),
            'email' => SiteSetting::get('email', 'info@butikdayu.com'),
            'alamat_toko' => SiteSetting::get('alamat_toko', 'Ruko Perumahan, Jl. Tambora Land III, Tamanyeleng, Barombong, Kabupaten Gowa, Sulawesi Selatan 90225'),
            'jam_operasional' => SiteSetting::get('jam_operasional', 'Senin - Sabtu, 09.00 - 17.00'),
        ]);
    }
}