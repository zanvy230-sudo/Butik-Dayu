@extends('layouts.app')

@section('title', __('messages.katalog_baju_adat') . ' - Butik Dayu')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative h-[420px] md:h-[480px] flex items-center justify-center text-center overflow-hidden">
        @if ($heroBanner)
            <img src="{{ asset('storage/' . $heroBanner) }}" alt="Koleksi baju adat Butik Dayu" class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 bg-brand-900"></div>
        @endif
        <div class="absolute inset-0 bg-ink/55"></div>

        @include('partials.navbar', ['active' => 'katalog'])

        <div class="relative z-10 max-w-2xl px-6 text-white">
            <p class="text-xs tracking-[0.2em] text-white font-semibold mb-3">{{ __('messages.koleksi_eksklusif') }}</p>
            <h1 class="text-4xl md:text-5xl font-semibold mb-5">{{ __('messages.katalog_baju_adat') }}</h1>
            <p class="text-white/80 leading-relaxed">
                {{ __('messages.katalog_desc') }}
            </p>
        </div>
    </section>

    <div>

        {{-- ============ PENCARIAN ============ --}}
        <section class="max-w-7xl mx-auto px-6 lg:px-10 pt-14">
            <div class="max-w-lg mx-auto relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-ink/30 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <input type="text" id="koleksi-search" placeholder="{{ __('messages.cari_placeholder') }}"
                       class="w-full rounded-full border border-brand-100 bg-white pl-12 pr-4 py-3.5 text-sm text-ink placeholder:text-ink/40 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
            </div>
        </section>

        {{-- ============ FILTER DAERAH ============ --}}
        <section class="max-w-7xl mx-auto px-6 lg:px-10 pt-8">
            <div id="filter-tabs" class="flex items-center justify-center gap-8 border-b border-brand-100 pb-4 mb-10 overflow-x-auto">
                @php
                    $daerahList = [
                        'semua'    => __('messages.filter_semua'),
                        'jawa'     => 'Jawa',
                        'sunda'    => 'Sunda',
                        'bali'     => 'Bali',
                        'sumatera' => 'Sumatera',
                        'sulawesi' => 'Sulawesi',
                    ];
                @endphp
                @foreach ($daerahList as $key => $label)
                    <button type="button" data-filter="{{ $key }}"
                            class="filter-tab whitespace-nowrap text-xs font-semibold tracking-wide pb-4 -mb-4 border-b-2 transition-colors
                                   {{ $key === 'semua' ? 'text-brand-500 border-brand-500' : 'text-ink/50 border-transparent hover:text-brand-500' }}">
                        {{ strtoupper($label) }}
                    </button>
                @endforeach
            </div>

            {{-- ============ GRID KOLEKSI ============ --}}
            @php
                $koleksi = \App\Support\ProdukData::semua();
            @endphp

            <div id="koleksi-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 pb-20">
                @foreach ($koleksi as $slug => $item)
                    <div class="koleksi-card" data-region="{{ $item['region'] }}" data-nama="{{ strtolower($item['nama']) }}">
                        <a href="{{ route('katalog.show', $slug) }}" class="block rounded-xl overflow-hidden h-80 mb-4 group">
                            <img src="{{ $item['gambar_utama'] }}" alt="{{ $item['nama'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 style="object-position: {{ $item['fokus_gambar'] ?? '50% 50%' }};">
                        </a>
                        <h3 class="font-serif text-xl font-semibold text-ink mb-1">{{ $item['nama'] }}</h3>
                        <p class="text-xs tracking-wide text-ink/50 font-semibold mb-4">{{ strtoupper($item['daerah']) }}</p>
                        <a href="{{ route('katalog.show', $slug) }}"
                           class="block text-center border border-brand-400 text-brand-500 text-xs font-semibold tracking-wide py-3 rounded-md hover:bg-brand-500 hover:text-white transition-colors">
                            {{ __('messages.detail_sewa') }}
                        </a>
                    </div>
                @endforeach
            </div>

            <p id="koleksi-empty" class="hidden text-center text-ink/50 text-sm pb-20">
                {{ __('messages.koleksi_kosong') }}
            </p>
        </section>

        {{-- ============ CTA KONSULTASI ============ --}}
        <section class="bg-brand-100/70">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 py-20 text-center">
                <div class="max-w-2xl mx-auto">
                    <h2 class="text-2xl md:text-3xl font-semibold text-ink mb-4">{{ __('messages.konsul_judul') }}</h2>
                    <p class="text-ink/60 leading-relaxed mb-8">
                        {{ __('messages.konsul_desc') }}
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ $contactSettings['whatsapp_url'] }}" target="_blank" rel="noopener"
                           class="btn-primary bg-brand-700 hover:bg-brand-800">
                            {{ __('messages.hubungi_wa') }}
                        </a>
                        <a href="#" class="inline-block bg-white border border-brand-300 text-brand-700 text-sm font-semibold tracking-wide px-7 py-3.5 rounded-md hover:bg-brand-50 transition-colors">
                            {{ __('messages.lihat_katalog_pdf') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <script>
        (function () {
            const tabs = document.querySelectorAll('.filter-tab');
            const cards = document.querySelectorAll('.koleksi-card');
            const emptyState = document.getElementById('koleksi-empty');
            const searchInput = document.getElementById('koleksi-search');

            let currentFilter = 'semua';

            function applyFilters() {
                const keyword = searchInput.value.trim().toLowerCase();
                let visibleCount = 0;

                cards.forEach(function (card) {
                    const cocokDaerah = currentFilter === 'semua' || card.getAttribute('data-region') === currentFilter;
                    const cocokNama = keyword === '' || card.getAttribute('data-nama').includes(keyword);
                    const tampil = cocokDaerah && cocokNama;

                    card.classList.toggle('hidden', !tampil);
                    if (tampil) visibleCount++;
                });

                emptyState.textContent = keyword
                    ? 'Tidak ada busana yang cocok dengan pencarian "' + searchInput.value.trim() + '".'
                    : 'Belum ada koleksi untuk daerah ini.';
                emptyState.classList.toggle('hidden', visibleCount > 0);
            }

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    currentFilter = tab.getAttribute('data-filter');

                    tabs.forEach(function (t) {
                        t.classList.remove('text-brand-500', 'border-brand-500');
                        t.classList.add('text-ink/50', 'border-transparent');
                    });
                    tab.classList.remove('text-ink/50', 'border-transparent');
                    tab.classList.add('text-brand-500', 'border-brand-500');

                    applyFilters();
                });
            });

            searchInput.addEventListener('input', applyFilters);
        })();
    </script>

@endsection