@extends('layouts.app')

{{-- ======== Header ========== --}}
@section('title', __('messages.tentang_kami_judul') . ' - Butik Dayu')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative h-[600px] flex items-center justify-center text-center overflow-hidden">
        @if ($heroBanner)
            <img src="{{ asset('storage/' . $heroBanner) }}" alt="Proses rias pengantin Butik Dayu" class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 bg-brand-900"></div>
        @endif
        <div class="absolute inset-0 bg-ink/50"></div>

        @include('partials.navbar', ['active' => 'tentang'])

        <div class="relative z-10 max-w-2xl px-6 text-white">
            <p class="tracking-[0.2em] text-xs md:text-sm text-white mb-4">{{ __('messages.perjalanan_indah_kami') }}</p>
            <h1 class="text-3xl md:text-5xl font-semibold leading-tight mb-8">
                {{ __('messages.tentang_kami_heading') }}<br class="hidden md:block"></h1>
            <p class="text-sm md:text-base text-white/80 leading-relaxed mb-8">
                {{ __('messages.tentang_kami_hero_desc') }}
            </p>
        </div>

        <a href="#keunggulan" class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/80 animate-bounce" aria-label="Gulir ke bawah">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </a>
    </section>

    <div id="keunggulan" class="pt-20 md:pt-28 lg:pt-32"></div>

    {{-- ============ SEJARAH KAMI ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div>
                <p class="text-xs tracking-[0.15em] text-brand-500 font-semibold mb-2">{{ __('messages.tentang_kami_label') }}</p>
                <h2 class="text-2xl md:text-3xl font-semibold text-ink mb-5">{{ __('messages.melestarikan_warisan_budaya') }}</h2>
                <p class="text-ink/60 leading-relaxed">
                    {{ __('messages.sejarah_kami_desc') }}
                </p>
            </div>
            <div class="rounded-xl overflow-hidden h-80">
                <img src="{{ asset('images/Baju_1           .jpg') }}"
                     alt="Interior butik Butik Dayu" class="w-full h-full object-cover">
            </div>
        </div>
    </section>

    {{-- ============ VISI & MISI ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 pb-20">
        <div class="bg-brand-100/50 rounded-2xl text-center px-8 py-16">
            <p class="text-xs tracking-[0.15em] text-brand-500 font-semibold mb-3">{{ __('messages.visi_misi_label') }}</p>
            <h2 class="text-2xl md:text-3xl font-semibold text-ink mb-5">{{ __('messages.elegansi_dalam_tradisi') }}</h2>
            <p class="text-ink/60 leading-relaxed max-w-2xl mx-auto">
                {{ __('messages.visi_misi_desc') }}
            </p>
        </div>
    </section>

    {{-- ============ PILAR KEUNGGULAN ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 pb-20 text-center">
        <p class="text-xs tracking-[0.15em] text-brand-500 font-semibold mb-3">{{ __('messages.nilai_kami_label') }}</p>
        <h2 class="text-2xl md:text-3xl font-semibold text-ink mb-12">{{ __('messages.pilar_keunggulan') }}</h2>

        @php
            $nilai = [
                [
                    'icon' => 'M6 3h12l4 6-10 12L2 9l4-6z',
                    'judul' => __('messages.keahlian_berkualitas_judul'),
                    'deskripsi' => __('messages.keahlian_berkualitas_desc'),
                ],
                [
                    'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
                    'judul' => __('messages.gaya_autentik_judul'),
                    'deskripsi' => __('messages.gaya_autentik_desc'),
                ],
                [
                    'icon' => 'M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z',
                    'judul' => __('messages.layanan_personal_judul'),
                    'deskripsi' => __('messages.layanan_personal_desc'),
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($nilai as $item)
                <div class="bg-white border border-brand-100 rounded-xl p-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-brand-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                    <h3 class="font-serif text-lg font-semibold text-ink mb-3">{{ $item['judul'] }}</h3>
                    <p class="text-sm text-ink/60 leading-relaxed">{{ $item['deskripsi'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ LOKASI KAMI ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-10 pb-20">
        <div class="text-center mb-10">
            <p class="text-xs tracking-[0.15em] text-brand-500 font-semibold mb-3">{{ __('messages.kunjungi_butik_label') }}</p>
            <h2 class="text-2xl md:text-3xl font-semibold text-ink">{{ __('messages.lokasi_kami_judul') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            {{-- Peta asli Google Maps --}}
            <div class="rounded-2xl overflow-hidden h-72">
                <iframe
                    src="https://www.google.com/maps?q={{ urlencode($contactSettings['alamat_toko']) }}&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <div class="space-y-6">
                <div class="flex gap-4">
                    <span class="shrink-0 w-11 h-11 rounded-full bg-brand-100 text-brand-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-serif font-semibold text-brand-600 mb-1">{{ __('messages.alamat_label') }}</h3>
                        <p class="text-sm text-ink/65 leading-relaxed">
                            {{ $contactSettings['alamat_toko'] }}
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <span class="shrink-0 w-11 h-11 rounded-full bg-brand-100 text-brand-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.09l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97a1.125 1.125 0 00.417-1.173L6.963 3.102a1.125 1.125 0 00-1.09-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-serif font-semibold text-brand-600 mb-1">{{ __('messages.kontak_label') }}</h3>
                        <p class="text-sm text-ink/65 leading-relaxed">
                            WhatsApp: {{ $contactSettings['whatsapp'] }}<br>
                            Email: {{ $contactSettings['email'] }}
                        </p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <span class="shrink-0 w-11 h-11 rounded-full bg-brand-100 text-brand-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-serif font-semibold text-brand-600 mb-1">{{ __('messages.jam_operasional_label') }}</h3>
                        <p class="text-sm text-ink/65 leading-relaxed">
                            {{ $contactSettings['jam_operasional'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection