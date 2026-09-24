@extends('layouts.app')

@section('title', __('messages.layanan_rias') . ' - Butik Dayu')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative h-[560px] flex items-center overflow-hidden">
        @if ($heroBanner)
            <img src="{{ asset('storage/' . $heroBanner) }}" alt="Proses rias wajah pengantin" class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 bg-brand-900"></div>
        @endif
        <div class="absolute inset-0 bg-ink/55"></div>

        @include('partials.navbar', ['active' => 'layanan'])

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-10 w-full flex justify-center text-center">
            <div class="max-w-2xl mx-auto">
                <p class="text-xs tracking-[0.2em] text-white font-semibold mb-3">{{ __('messages.elegansi_tradisi') }}</p>
                <h1 class="text-4xl md:text-5xl font-semibold text-white leading-tight mb-5">
                    {!! __('messages.seni_rias_title') !!}
                </h1>
                <p class="text-sm md:text-base text-white/80 leading-relaxed max-w-xl mx-auto mb-8">
                    {{ __('messages.seni_rias_desc') }}
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="#portofolio" class="inline-block bg-white border border-brand-400 text-brand-600 text-sm font-semibold px-6 py-3 rounded-md hover:bg-brand-50 transition-colors">
                        {{ __('messages.lihat_koleksi_btn') }}
                    </a>
                    <a href="{{ $contactSettings['whatsapp_url'] }}?text={{ urlencode('Halo, saya ingin konsultasi gratis untuk rias pengantin') }}" target="_blank" rel="noopener"
                       class="inline-block bg-white/10 border border-white/30 text-white text-sm font-semibold px-6 py-3 rounded-md hover:bg-white/20 transition-colors">
                        {{ __('messages.konsultasi_gratis_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="pt-16">

        {{-- ============ PILIH PAKET RIAS ============ --}}
        <section class="max-w-6xl mx-auto px-6 pb-20">
            <div class="text-center mb-14">
                <h2 class="text-2xl md:text-3xl font-semibold text-ink">{{ __('messages.pilih_paket_rias') }}</h2>
                <div class="section-underline"></div>
                <p class="text-ink/60 max-w-xl mx-auto mt-4 leading-relaxed">
                    {{ __('messages.pilih_paket_desc') }}
                </p>
            </div>

            @php
                $paketRias = [
                    [
                        'slug' => 'akad',
                        'nama' => __('messages.paket_akad_nama'),
                        'harga' => __('messages.paket_akad_harga'),
                        'icon' => 'diamond',
                        'fitur' => [
                            __('messages.akad_fitur_1'),
                            __('messages.akad_fitur_2'),
                            __('messages.akad_fitur_3'),
                            __('messages.akad_fitur_4'),
                        ],
                    ],
                    [
                        'slug' => 'resepsi',
                        'nama' => __('messages.paket_resepsi_nama'),
                        'harga' => __('messages.paket_resepsi_harga'),
                        'icon' => 'sparkle',
                        'fitur' => [
                            __('messages.resepsi_fitur_1'),
                            __('messages.resepsi_fitur_2'),
                            __('messages.resepsi_fitur_3'),
                            __('messages.resepsi_fitur_4'),
                            __('messages.resepsi_fitur_5'),
                        ],
                    ],
                    [
                        'slug' => 'pre-wedding',
                        'nama' => __('messages.paket_prewed_nama'),
                        'harga' => __('messages.paket_prewed_harga'),
                        'icon' => 'camera',
                        'fitur' => [
                            __('messages.prewed_fitur_1'),
                            __('messages.prewed_fitur_2'),
                            __('messages.prewed_fitur_3'),
                            __('messages.prewed_fitur_4'),
                        ],
                    ],
                ];

                $iconSvg = [
                    'diamond' => 'M6 3h12l4 6-10 12L2 9l4-6z',
                    'sparkle' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z',
                    'camera' => 'M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.174C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z',
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                @foreach ($paketRias as $paket)
                    <div class="bg-white border border-brand-100 rounded-2xl p-8 text-center h-full flex flex-col">
                        @if (!empty($paket['icon']))
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-brand-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconSvg[$paket['icon']] }}" />
                            </svg>
                        @endif
                        <h3 class="font-serif text-xl font-semibold text-ink mb-1">{{ $paket['nama'] }}</h3>
                        <p class="text-xs font-semibold text-brand-500 mb-6">{{ $paket['harga'] }}</p>
                        <ul class="space-y-3 mb-8 border-t border-brand-100 pt-6 text-left flex-1">
                            @foreach ($paket['fitur'] as $fitur)
                                <li class="flex items-start gap-2.5 text-sm text-ink/65">
                                    <span class="w-1.5 h-1.5 rounded-full border border-ink/30 mt-1.5 shrink-0"></span>
                                    {{ $fitur }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('rias.pesan.create', $paket['slug']) }}"
                           class="w-full border border-brand-400 text-brand-600 text-sm font-semibold rounded-md py-3.5 hover:bg-brand-50 transition-colors">
                            {{ __('messages.pilih_paket_btn') }}
                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ============ GALERI PORTOFOLIO ============ --}}
        <section id="portofolio" class="scroll-mt-24 max-w-7xl mx-auto px-6 lg:px-10 pb-20">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="text-xs tracking-[0.15em] text-brand-500 font-semibold mb-2">{{ __('messages.portofolio_label') }}</p>
                    <h2 class="text-2xl md:text-3xl font-semibold text-ink">{{ __('messages.galeri_judul') }}</h2>
                </div>
                <a href="{{ route('katalog.index') }}" class="hidden sm:inline text-xs font-semibold tracking-wide text-brand-600 hover:text-brand-700 underline underline-offset-4">
                    {{ __('messages.lihat_semua_koleksi') }}
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($portfolioImages as $foto)
                    <div class="rounded-xl overflow-hidden h-56">
                        <img src="{{ asset('storage/' . $foto) }}" alt="Hasil riasan Butik Dayu" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                @endforeach
            </div>
        </section>

    </div>

@endsection