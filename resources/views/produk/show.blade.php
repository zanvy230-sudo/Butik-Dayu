@extends('layouts.app')

@section('title', $produk['nama'] . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => 'katalog'])

    <div class="pt-28 md:pt-32 max-w-7xl mx-auto px-6 lg:px-10 pb-20">

        {{-- ============ FOTO + INFO PRODUK ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">

            <div>
                <div id="foto-utama-wrapper" class="rounded-xl overflow-hidden h-[480px] mb-4">
                    <img id="foto-utama" src="{{ $produk['gambar_utama'] }}" alt="{{ $produk['nama'] }}"
                         class="w-full h-full object-cover"
                         style="object-position: {{ $produk['fokus_gambar'] ?? '50% 50%' }};">
                </div>
                <div class="flex gap-3">
                    @foreach ($produk['gambar_galeri'] as $i => $thumb)
                        <button type="button"
                                class="thumb-btn w-20 h-20 rounded-lg overflow-hidden border-2 {{ $i === 0 ? 'border-brand-500' : 'border-transparent' }}"
                                data-full="{{ $i === 0 ? $produk['gambar_utama'] : $thumb }}">
                            <img src="{{ $thumb }}" alt="Galeri {{ $i + 1 }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-brand-500 mb-2">{{ $produk['kategori_label'] }}</p>
                <h1 class="text-3xl md:text-4xl font-semibold text-ink mb-3">{{ $produk['nama'] }}</h1>

                <div class="flex items-center gap-2 mb-6">
                    <div class="flex text-brand-500">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="{{ $i <= round($produk['rating']) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-ink/50">({{ $produk['jumlah_ulasan'] }} {{ __('messages.ulasan_label') }})</span>
                </div>

                <div class="border-t border-brand-100 pt-5 mb-5">
                    <p class="text-xs font-semibold tracking-wide text-ink/50 mb-1">{{ __('messages.biaya_sewa') }}</p>
                    <p class="text-2xl font-semibold text-brand-600">
                        IDR {{ number_format($produk['harga'], 0, ',', '.') }}
                        <span class="text-sm font-normal text-ink/50">/ {{ __('messages.per_hari') }}</span>
                    </p>
                </div>

                <p class="text-ink/65 leading-relaxed border-t border-brand-100 pt-5 mb-5">
                    {{ $produk['deskripsi'] }}
                </p>

                @php
                  $ukuranDefault = array_key_first($produk['stok_ukuran'] ?? []);
                    $ukuranDipilih = request()->query('size', $ukuranDefault);
                @endphp

                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-semibold text-ink">{{ __('messages.pilih_ukuran') }}</p>
                        <span class="text-xs font-medium text-ink/50">{{ __('messages.stok_tersedia') }}</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        @foreach ($produk['stok_ukuran'] ?? [] as $ukuran => $stok)
                            @php
                                $selected = $ukuranDipilih === $ukuran;
                                $tersedia = $stok > 0;
                            @endphp
                            <button type="button"
                                    class="size-option rounded-xl border px-3 py-2 text-left transition-colors {{ $selected ? 'border-brand-500 bg-brand-50 text-brand-700' : 'border-brand-200 bg-white text-ink hover:border-brand-300' }} {{ $tersedia ? '' : 'opacity-50 grayscale' }}"
                                    data-size="{{ $ukuran }}"
                                    data-stock="{{ $stok }}"
                                    {{ $tersedia ? '' : 'disabled' }}>
                                <span class="block text-base font-bold">{{ $ukuran }}</span>
                                <span class="block text-[10px] {{ $tersedia ? 'text-ink/60' : 'text-red-500' }}">
                                    {{ $tersedia ? __('messages.stok_label') . ' ' . $stok : __('messages.habis_label') }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ $contactSettings['instagram'] }}" target="_blank" rel="noopener"
                       class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-brand-500 to-pink-500 text-white text-sm font-semibold rounded-lg py-3.5 hover:opacity-90 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 2.163c-3.15 0-3.52.012-4.76.069-2.126.097-3.135 1.123-3.232 3.232-.057 1.24-.068 1.61-.068 4.76 0 3.151.011 3.521.068 4.761.097 2.107 1.104 3.135 3.232 3.232 1.24.058 1.61.069 4.76.069 3.151 0 3.522-.011 4.76-.069 2.125-.097 3.135-1.122 3.233-3.232.057-1.24.068-1.61.068-4.761 0-3.15-.011-3.52-.068-4.76-.098-2.108-1.105-3.135-3.233-3.232-1.238-.057-1.609-.069-4.76-.069zm0 3.678a5.995 5.995 0 110 11.99 5.995 5.995 0 010-11.99zm0 9.884a3.89 3.89 0 100-7.78 3.89 3.89 0 000 7.78zm7.629-10.14a1.401 1.401 0 11-2.803 0 1.401 1.401 0 012.803 0z"/>
                        </svg>
                        {{ __('messages.pesan_ig') }}
                    </a>
                    <a href="{{ $contactSettings['whatsapp_url'] }}?text={{ urlencode('Halo, saya tertarik menyewa ' . $produk['nama']) }}" target="_blank" rel="noopener"
                       class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg py-3.5 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.77.46 3.5 1.34 5.02L2 22l5.13-1.35a9.96 9.96 0 004.91 1.3h.01c5.52 0 10-4.48 10-10s-4.48-10-10-10zm0 18.15h-.01a8.14 8.14 0 01-4.15-1.14l-.3-.18-3.05.8.82-2.98-.2-.31a8.15 8.15 0 01-1.25-4.34c0-4.5 3.66-8.16 8.16-8.16 4.5 0 8.16 3.66 8.16 8.16 0 4.5-3.67 8.15-8.18 8.15zm4.47-6.12c-.24-.12-1.44-.71-1.66-.79-.22-.08-.39-.12-.55.12-.16.24-.63.79-.77.95-.14.16-.28.18-.52.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42-.14-.01-.3-.01-.46-.01-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.13 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.44-.59 1.64-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z"/>
                        </svg>
                        {{ __('messages.pesan_wa') }}
                    </a>
                    @if (session('status'))
                        <div class="rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="flex gap-3">
                        <a id="checkout-link" href="{{ route('checkout.show', ['slug' => $slug, 'size' => $ukuranDipilih]) }}"
                           class="flex-1 text-center bg-brand-700 hover:bg-brand-800 text-white text-sm font-semibold rounded-lg py-3.5 transition-colors">
                            {{ __('messages.checkout_sekarang') }}
                        </a>
                        <form id="cart-form" action="{{ route('cart.store', $slug) }}" method="POST">
                            @csrf
                            <input type="hidden" name="size" id="selected-size" value="{{ $ukuranDipilih }}">
                            <button type="submit" aria-label="Tambahkan ke keranjang"
                                    class="w-14 h-full flex items-center justify-center border border-brand-300 rounded-lg text-brand-500 hover:bg-brand-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.766-4.79 1.766-7.25 0-.51-.114-.998-.32-1.437H5.106m2.394 8.687L5.106 6.75m2.394 8.687-.398 1.5m9.19-1.5v.001M9 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm9.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ MUNGKIN KAMU SUKA ============ --}}
        <section>
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-semibold text-ink">{{ __('messages.mungkin_kamu_suka') }}</h2>
                    <div class="w-10 h-[3px] bg-brand-500 mt-2"></div>
                </div>
                <a href="{{ route('katalog.index') }}" class="text-xs font-semibold tracking-wide text-brand-600 hover:text-brand-700">
                    {{ __('messages.lihat_semua') }}
                </a>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($produkTerkait as $slugTerkait => $item)
                    <a href="{{ route('katalog.show', $slugTerkait) }}" class="block group">
                        <div class="rounded-lg overflow-hidden h-64 mb-3">
                            <img src="{{ $item['gambar_utama'] }}" alt="{{ $item['nama'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <p class="text-xs font-semibold tracking-wide text-ink/50 mb-1">{{ strtoupper($item['daerah']) }}</p>
                        <h3 class="font-medium text-ink group-hover:text-brand-500 mb-1">{{ $item['nama'] }}</h3>
                        <p class="text-sm font-semibold text-brand-600">IDR {{ number_format($item['harga'], 0, ',', '.') }}</p>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- ============ ULASAN PRODUK ============ --}}
        <section class="mt-20 pt-16 border-t border-brand-100">
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-ink">{{ __('messages.ulasan_pembeli') }}</h2>
                <div class="w-10 h-[3px] bg-brand-500 mt-2"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[440px_1fr] gap-10 items-start">
                <div>
                    <div class="bg-white border border-brand-100 rounded-2xl p-6 sticky top-28">
                        <h3 class="font-serif text-lg font-semibold text-ink mb-4">{{ __('messages.tulis_ulasan') }}</h3>

                        @if (session('status'))
                            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-600 text-xs px-3 py-2.5">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-xs px-3 py-2.5">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @auth
                            <form method="POST" action="{{ route('ulasan-produk.store', $slug) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="nama" class="block text-xs font-semibold text-ink/60 mb-2">{{ __('messages.nama_label') }}</label>
                                        <input type="text" name="nama" id="nama" value="{{ old('nama', auth()->user()->name) }}"
                                               class="w-full rounded-lg border border-brand-100 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300">
                                    </div>
                                    <div>
                                        <label for="whatsapp" class="block text-xs font-semibold text-ink/60 mb-2">{{ __('messages.whatsapp_label') }}</label>
                                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', auth()->user()->phone) }}"
                                               class="w-full rounded-lg border border-brand-100 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-semibold text-ink/60 mb-2">Rating</label>
                                    <div class="flex gap-1" id="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" data-value="{{ $i }}"
                                                    class="rating-star w-7 h-7 text-brand-300 hover:text-brand-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                                </svg>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-value" value="{{ old('rating') }}">
                                </div>

                                <div class="mb-4">
                                    <label for="komentar" class="block text-xs font-semibold text-ink/60 mb-2">{{ __('messages.komentar_label') }}</label>
                                    <textarea name="komentar" id="komentar" rows="5"
                                              class="w-full rounded-lg border border-brand-100 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300">{{ old('komentar') }}</textarea>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-xs font-semibold text-ink/60 mb-2">{{ __('messages.foto_label') }}</label>
                                    <label for="foto"
                                           class="flex items-center gap-3 border border-dashed border-brand-200 rounded-lg px-3 py-3 cursor-pointer hover:bg-brand-50/40 transition-colors">
                                        <span id="foto-label" class="text-xs text-ink/50">{{ __('messages.pilih_foto_klik') }}</span>
                                    </label>
                                    <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                                </div>

                                <button type="submit"
                                        class="w-full bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg py-3 transition-colors">
                                    {{ __('messages.kirim_ulasan') }}
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-ink/60 leading-relaxed">
                                <a href="{{ route('login') }}" class="text-brand-600 font-semibold hover:underline">{{ __('messages.masuk') }}</a>
                                {{ __('messages.login_dulu_ulasan') }}
                            </p>
                        @endauth
                    </div>
                </div>

                <div class="space-y-5">
                    @forelse ($ulasanProdukList as $ulasan)
                        <div class="border border-brand-100 rounded-xl p-5">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold text-ink text-sm">{{ $ulasan->user->name ?? 'Pengguna' }}</p>
                                <span class="text-xs text-ink/40">{{ $ulasan->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex text-brand-500 mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="{{ $i <= $ulasan->rating ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-sm text-ink/70 leading-relaxed mb-3">{{ $ulasan->komentar }}</p>
                            @if ($ulasan->fotoUrl())
                                <img src="{{ $ulasan->fotoUrl() }}" alt="Foto ulasan" class="w-28 h-28 rounded-lg object-cover border border-brand-100">
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-ink/50">{{ __('messages.belum_ada_ulasan') }}</p>
                    @endforelse
                </div>
            </div>
        </section>

    </div>

    <script>
        (function () {
            const fotoUtama = document.getElementById('foto-utama');
            const thumbs = document.querySelectorAll('.thumb-btn');

            thumbs.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    fotoUtama.src = btn.getAttribute('data-full');
                    thumbs.forEach(t => t.classList.remove('border-brand-500'));
                    thumbs.forEach(t => t.classList.add('border-transparent'));
                    btn.classList.remove('border-transparent');
                    btn.classList.add('border-brand-500');
                });
            });

            const checkoutLink = document.getElementById('checkout-link');
            const selectedSizeInput = document.getElementById('selected-size');
            const sizeOptions = document.querySelectorAll('.size-option');

            sizeOptions.forEach(function (button) {
                button.addEventListener('click', function () {
                    const size = button.getAttribute('data-size');
                    selectedSizeInput.value = size;

                    sizeOptions.forEach(item => {
                        item.classList.remove('border-brand-500', 'bg-brand-50', 'text-brand-700');
                        item.classList.add('border-brand-200', 'bg-white', 'text-ink');
                    });

                    button.classList.remove('border-brand-200', 'bg-white', 'text-ink');
                    button.classList.add('border-brand-500', 'bg-brand-50', 'text-brand-700');

                    if (checkoutLink) {
                        const url = new URL(checkoutLink.href, window.location.origin);
                        url.searchParams.set('size', size);
                        checkoutLink.href = url.toString();
                    }
                });
            });

            const ratingStars = document.querySelectorAll('.rating-star');
            const ratingValueInput = document.getElementById('rating-value');

            ratingStars.forEach(function (star) {
                star.addEventListener('click', function () {
                    const value = parseInt(star.getAttribute('data-value'));
                    ratingValueInput.value = value;

                    ratingStars.forEach(function (s) {
                        const val = parseInt(s.getAttribute('data-value'));
                        const svg = s.querySelector('svg');
                        if (val <= value) {
                            svg.setAttribute('fill', 'currentColor');
                            s.classList.add('text-brand-500');
                            s.classList.remove('text-brand-300');
                        } else {
                            svg.setAttribute('fill', 'none');
                            s.classList.remove('text-brand-500');
                            s.classList.add('text-brand-300');
                        }
                    });
                });
            });

            const fotoInput = document.getElementById('foto');
            const fotoLabel = document.getElementById('foto-label');
            if (fotoInput) {
                fotoInput.addEventListener('change', function () {
                    fotoLabel.textContent = fotoInput.files.length > 0 ? fotoInput.files[0].name : 'Klik untuk pilih foto';
                });
            }
        })();
    </script>

@endsection