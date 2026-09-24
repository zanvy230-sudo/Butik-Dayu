@extends('layouts.app')

@section('title', ($siteSettings['nama_toko'] ?? 'Butik Dayu') . ' - ' . __('messages.beranda'))

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative h-[600px] flex items-center justify-center text-center overflow-hidden">
        @if (!empty($siteSettings['hero_banner']))
            <img src="{{ asset('storage/' . $siteSettings['hero_banner']) }}" alt="Proses rias pengantin Butik Dayu"
                 class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 bg-brand-900"></div>
        @endif
        <div class="absolute inset-0 bg-ink/50"></div>

        @include('partials.navbar', ['active' => 'beranda'])

        <div class="relative z-10 max-w-2xl px-6 text-white">
            <p class="tracking-[0.2em] text-xs md:text-sm text-white mb-4">{{ $siteSettings['tagline'] ?? __('messages.hero_tag') }}</p>
            <h1 class="text-3xl md:text-5xl font-semibold leading-tight mb-8">
                {{ $siteSettings['hero_judul'] ?? __('messages.hero_title') }}
            </h1>
            @if (!empty($siteSettings['hero_deskripsi']))
                <p class="text-sm md:text-base text-white/85 leading-relaxed max-w-xl mx-auto mb-8">
                    {{ $siteSettings['hero_deskripsi'] }}
                </p>
            @endif
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ Route::has('katalog.index') ? route('katalog.index') : '#' }}" class="btn-primary">
                    {{ __('messages.lihat_katalog') }}
                </a>
                <a href="{{ Route::has('layanan.index') ? route('layanan.index') : '#' }}" class="btn-outline">
                    {{ __('messages.pesan_layanan') }}
                </a>
            </div>
        </div>

        <a href="#keunggulan" class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/80 animate-bounce" aria-label="Gulir ke bawah">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </a>
    </section>

    {{-- ============ MENGAPA MEMILIH BUTIK DAYU ============ --}}
    <section id="keunggulan" class="scroll-mt-24 max-w-7xl mx-auto px-6 lg:px-10 py-20">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-semibold text-ink">{{ __('messages.mengapa_judul') }}</h2>
            <div class="section-underline"></div>
        </div>

        {{-- Baris 1: dua foto --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @php
                $fotoKeunggulan = [
                    [
                        'gambar' => asset('images/Baju_1.jpg'),
                        'judul' => __('messages.koleksi_judul'),
                        'deskripsi' => __('messages.koleksi_desc'),
                    ],
                    [
                        'gambar' => asset('images/Baju_2.jpg'),
                        'judul' => __('messages.perias_judul'),
                        'deskripsi' => __('messages.perias_desc'),
                    ],
                ];
            @endphp

            @foreach ($fotoKeunggulan as $item)
                <div class="relative rounded-xl overflow-hidden h-72 group">
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['judul'] }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/10 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <h3 class="font-semibold text-lg mb-1">{{ $item['judul'] }}</h3>
                        <p class="text-sm text-white/80 max-w-sm">{{ $item['deskripsi'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Baris 2: kartu kualitas premium + konsultasi personal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-brand-500 text-white rounded-xl p-8">
                <div class="w-11 h-11 rounded-full bg-white/15 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-lg mb-2">{{ __('messages.premium_judul') }}</h3>
                <p class="text-sm text-white/85 leading-relaxed">
                    {{ __('messages.premium_desc') }}
                </p>
            </div>

            <div class="bg-white border border-brand-100 rounded-xl p-8 flex items-center justify-between gap-6">
                <div>
                    <h3 class="font-semibold text-lg mb-2">{{ __('messages.konsultasi_judul') }}</h3>
                    <p class="text-sm text-ink/60 leading-relaxed max-w-sm">
                        {{ __('messages.konsultasi_desc') }}
                    </p>
                </div>
                <div class="hidden sm:flex flex-col gap-3 shrink-0">
                    <span class="w-11 h-11 rounded-full border border-brand-200 flex items-center justify-center text-brand-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </span>
                    <span class="w-11 h-11 rounded-full border border-brand-200 flex items-center justify-center text-brand-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CARA PEMESANAN ============ --}}
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink">{{ __('messages.cara_pemesanan') }}</h2>
            </div>

            @php
                $langkahPesan = [
                    [
                        'nomor' => '1',
                        'judul' => __('messages.langkah_1_judul'),
                        'deskripsi' => __('messages.langkah_1_desc'),
                        'icon' => 'M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z',
                    ],
                    [
                        'nomor' => '2',
                        'judul' => __('messages.langkah_2_judul'),
                        'deskripsi' => __('messages.langkah_2_desc'),
                        'icon' => 'M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z',
                    ],
                    [
                        'nomor' => '3',
                        'judul' => __('messages.langkah_3_judul'),
                        'deskripsi' => __('messages.langkah_3_desc'),
                        'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    ],
                ];
                $totalLangkah = count($langkahPesan);
            @endphp

            <div class="grid mb-6" style="grid-template-columns: repeat({{ $totalLangkah }}, minmax(0, 1fr));">
                @foreach ($langkahPesan as $i => $langkah)
                    <div class="relative flex justify-center">
                        @if (!$loop->last)
                            <div class="absolute top-1/2 left-1/2 w-full h-px bg-brand-200 -translate-y-1/2"></div>
                        @endif
                        <div class="relative z-10 w-16 h-16 rounded-full bg-brand-700 text-white font-serif font-semibold text-xl flex items-center justify-center">
                            {{ $langkah['nomor'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid gap-6" style="grid-template-columns: repeat({{ $totalLangkah }}, minmax(0, 1fr));">
                @foreach ($langkahPesan as $langkah)
                    <div class="text-center px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-ink/50 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $langkah['icon'] }}" />
                        </svg>
                        <h3 class="font-serif text-lg text-ink mb-2">{{ $langkah['judul'] }}</h3>
                        <p class="text-sm text-ink/50 leading-relaxed">{{ $langkah['deskripsi'] }}</p>

                        @if ($langkah['judul'] === __('messages.langkah_2_judul'))
                            <div class="mt-4 space-y-2 inline-block text-left">
                                <p class="flex items-center gap-2 text-sm text-ink/70 border-b border-brand-100 pb-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5m-15 10.5V10.5M3 21h18M3 10.5h18" />
                                    </svg>
                                    {{ __('messages.transfer_bank') }}
                                </p>
                                <p class="flex items-center gap-2 text-sm text-ink/70 border-b border-brand-100 pb-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v10.5m0-10.5h19.5m0 0v.75a.75.75 0 01-.75.75h-.75m1.5-1.5h.75m0 0v10.5m0-10.5h-.75M3.75 19.5h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z" />
                                    </svg>
                                    {{ __('messages.cod_label') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONI ============ --}}
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">
            <p class="text-brand-300 text-4xl font-serif mb-2">&ldquo;&rdquo;</p>
            <h2 class="text-2xl md:text-3xl font-semibold text-ink mb-12">{{ __('messages.ulasan_pelanggan') }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($testimoni as $index => $t)
                    <div class="rounded-xl p-7 text-left {{ $index === 1 ? 'bg-brand-500 text-white' : 'bg-white border border-brand-100' }}">
                        <p class="text-sm italic leading-relaxed mb-6 {{ $index === 1 ? 'text-white/90' : 'text-ink/70' }}">
                            &ldquo;{{ $t->ulasan }}&rdquo;
                        </p>
                        <p class="font-semibold {{ $index === 1 ? 'text-white' : 'text-brand-600' }}">{{ $t->nama }}</p>
                        <p class="text-xs tracking-wide {{ $index === 1 ? 'text-white/70' : 'text-ink/50' }}">{{ $t->labelPaket() }}</p>
                    </div>
                @empty
                    <div class="md:col-span-3 py-8 text-center text-sm text-ink/50">
                        Belum ada ulasan pelanggan yang ditampilkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection