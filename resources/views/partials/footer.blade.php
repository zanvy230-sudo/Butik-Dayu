<footer class="bg-white border-t border-brand-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-14 grid grid-cols-1 md:grid-cols-4 gap-10">

        {{-- Kolom 1: logo, tagline, sosial media --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                @if ($logoFooter)
                    <img src="{{ asset('storage/' . $logoFooter) }}" alt="Butik Dayu" class="w-9 h-9 rounded-full object-cover">
                @endif
                <span class="font-serif text-lg font-semibold text-brand-600">Butik Dayu</span>
            </div>
            <p class="text-sm text-ink/60 leading-relaxed max-w-xs mb-5">
                {{ __('messages.footer_tagline') }}
            </p>
            <div class="flex gap-3">
                <a href="{{ $contactSettings['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram" class="w-9 h-9 rounded-full border border-brand-200 text-brand-500 flex items-center justify-center hover:bg-brand-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <rect x="3" y="3" width="18" height="18" rx="5" />
                        <circle cx="12" cy="12" r="3.5" />
                        <circle cx="17.2" cy="6.8" r="0.6" fill="currentColor" stroke="none" />
                    </svg>
                </a>
                <a href="{{ $contactSettings['whatsapp_url'] }}" target="_blank" rel="noopener" aria-label="WhatsApp" class="w-9 h-9 rounded-full border border-brand-200 text-brand-500 flex items-center justify-center hover:bg-brand-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.09l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97a1.125 1.125 0 00.417-1.173L6.963 3.102a1.125 1.125 0 00-1.09-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                </a>
                <a href="#" aria-label="TikTok" class="w-9 h-9 rounded-full border border-brand-200 text-brand-500 flex items-center justify-center hover:bg-brand-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3v9.75a3.75 3.75 0 11-3-3.675M16.5 3a5.25 5.25 0 004.5 3v3a8.235 8.235 0 01-4.5-1.32V3z" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Kolom 2: menu --}}
        <div>
            <h4 class="text-xs font-semibold tracking-wide text-ink mb-4">{{ __('messages.footer_menu_title') }}</h4>
            <ul class="space-y-2.5 text-sm text-ink/60">
                <li><a href="{{ route('home') }}" class="hover:text-brand-500">{{ __('messages.nav_beranda') }}</a></li>
                <li><a href="{{ route('katalog.index') }}" class="hover:text-brand-500">{{ __('messages.nav_katalog') }}</a></li>
                <li><a href="{{ route('layanan.index') }}" class="hover:text-brand-500">{{ __('messages.nav_layanan') }}</a></li>
                <li><a href="{{ Route::has('tentang') ? route('tentang') : '#' }}" class="hover:text-brand-500">{{ __('messages.nav_tentang') }}</a></li>
            </ul>
        </div>

        {{-- Kolom 3: kategori --}}
        <div>
            <h4 class="text-xs font-semibold tracking-wide text-ink mb-4">{{ __('messages.footer_kategori_title') }}</h4>
            <ul class="space-y-2.5 text-sm text-ink/60">
                <li><a href="{{ route('katalog.index') }}" class="hover:text-brand-500">{{ __('messages.kategori_jawa') }}</a></li>
                <li><a href="{{ route('katalog.index') }}" class="hover:text-brand-500">{{ __('messages.kategori_sunda') }}</a></li>
                <li><a href="{{ route('katalog.index') }}" class="hover:text-brand-500">{{ __('messages.kategori_bali') }}</a></li>
                <li><a href="{{ route('katalog.index') }}" class="hover:text-brand-500">{{ __('messages.kategori_sumatera') }}</a></li>
                <li><a href="{{ route('katalog.index') }}" class="hover:text-brand-500">{{ __('messages.kategori_sulawesi') }}</a></li>
            </ul>
        </div>

        {{-- Kolom 4: hubungi kami --}}
        <div>
            <h4 class="text-xs font-semibold tracking-wide text-ink mb-4">{{ __('messages.footer_hubungi_title') }}</h4>
            <ul class="space-y-4 text-sm text-ink/60">
                <li class="flex gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    <span>
                        <span class="block text-xs font-semibold tracking-wide text-brand-500 mb-0.5">{{ __('messages.footer_toko_label') }}</span>
                        {{ $contactSettings['alamat_toko'] }}
                    </span>
                </li>
                <li class="flex gap-2.5 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.09l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97a1.125 1.125 0 00.417-1.173L6.963 3.102a1.125 1.125 0 00-1.09-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <span>{{ $contactSettings['whatsapp'] }}</span>
                </li>
                <li class="flex gap-2.5 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <span>{{ $contactSettings['instagram_username'] }}</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-brand-100 py-5 text-center text-xs text-ink/50">
        &copy; {{ date('Y') }} Butik Dayu. {{ __('messages.footer_copyright_tagline') }}
    </div>
</footer>