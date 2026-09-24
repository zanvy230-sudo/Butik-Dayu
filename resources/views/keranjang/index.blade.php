@extends('layouts.app')

@section('title', __('messages.keranjang_judul') . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-5xl mx-auto px-4 sm:px-6 pb-24">

        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-serif font-semibold text-brand-600 mb-2">{{ __('messages.keranjang_judul') }}</h1>
            <p class="text-sm text-ink/60">{{ __('messages.keranjang_subjudul') }}</p>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        @if (empty($cart))
            {{-- ============ KERANJANG KOSONG ============ --}}
            <div class="bg-white border border-brand-100 rounded-2xl py-20 text-center">
                <p class="text-ink/50 mb-5">{{ __('messages.keranjang_kosong') }}</p>
                <a href="{{ route('katalog.index') }}"
                   class="inline-block bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg px-6 py-3 transition-colors">
                    {{ __('messages.mulai_belanja') }}
                </a>
            </div>
        @else
            <div class="bg-white border border-brand-100 rounded-2xl overflow-hidden">

                {{-- Header tabel, disembunyikan di layar kecil --}}
                <div class="hidden md:grid grid-cols-[auto_2fr_1fr_1fr_1fr_auto] gap-4 px-6 py-4 border-b border-brand-100 text-sm font-semibold text-ink items-center">
                    <input type="checkbox" id="pilih-semua"
                           class="w-4 h-4 rounded text-brand-600 focus:ring-brand-300" checked>
                    <span>{{ __('messages.tabel_produk') }}</span>
                    <span class="text-center">{{ __('messages.tabel_harga') }}</span>
                    <span class="text-center">{{ __('messages.tabel_jumlah') }}</span>
                    <span class="text-center">{{ __('messages.tabel_subtotal') }}</span>
                    <span></span>
                </div>

                {{-- Baris tiap produk --}}
                <div class="divide-y divide-brand-100">
                    @foreach ($cart as $slug => $item)
                        <div class="grid grid-cols-1 md:grid-cols-[auto_2fr_1fr_1fr_1fr_auto] gap-4 px-6 py-5 items-center">

                            {{-- Checkbox pilih produk --}}
                            <div>
                                <input type="checkbox"
                                       class="cart-item-checkbox w-4 h-4 rounded text-brand-600 focus:ring-brand-300"
                                       data-slug="{{ $slug }}"
                                       data-harga="{{ $item['harga'] * $item['qty'] }}"
                                       checked>
                            </div>

                            {{-- Produk --}}
                            <div class="flex items-center gap-4 min-w-0">
                                <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}"
                                     class="w-20 h-20 rounded-xl object-cover shrink-0">
                                <div class="min-w-0">
                                    <p class="font-serif font-semibold text-ink">{{ $item['nama'] }}</p>
                                    <p class="text-xs text-ink/50 mt-1">Size: {{ $item['size'] }}</p>
                                    <p class="text-xs text-ink/50">Color: {{ $item['color'] }}</p>
                                </div>
                            </div>

                            {{-- Harga --}}
                            <div class="text-left md:text-center text-sm font-medium text-ink">
                                <span class="md:hidden text-ink/40 mr-1">{{ __('messages.tabel_harga') }}:</span>
                                Rp{{ number_format($item['harga'], 0, ',', '.') }}
                            </div>

                            {{-- Jumlah --}}
                            <div class="flex md:justify-center">
                                <div class="inline-flex items-center border border-brand-100 rounded-lg overflow-hidden">
                                    <form method="POST" action="{{ route('cart.update', $slug) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="kurang">
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-ink/60 hover:bg-brand-50" aria-label="Kurangi">
                                            &minus;
                                        </button>
                                    </form>
                                    <span class="w-10 text-center text-sm font-semibold text-ink">{{ $item['qty'] }}</span>
                                    <form method="POST" action="{{ route('cart.update', $slug) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="action" value="tambah">
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-ink/60 hover:bg-brand-50" aria-label="Tambah">
                                            +
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-left md:text-center text-sm font-semibold text-ink">
                                <span class="md:hidden text-ink/40 mr-1 font-normal">{{ __('messages.tabel_subtotal') }}:</span>
                                Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                            </div>

                            {{-- Hapus --}}
                            <div class="flex md:justify-center">
                                  <form method="POST" action="{{ route('cart.remove', $slug) }}"
                                      data-confirm="{{ __('messages.konfirmasi_hapus_item', ['nama' => $item['nama']]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Hapus"
                                            class="w-10 h-10 rounded-full bg-brand-50 text-brand-500 hover:bg-brand-100 flex items-center justify-center transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Notice H-7 --}}
                <div class="mx-6 mb-6 bg-brand-50/70 border border-brand-100 rounded-xl px-5 py-3.5 flex items-center justify-center gap-2.5 text-sm font-semibold text-brand-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('messages.notice_h7') }}
                </div>
            </div>

            {{-- ============ RINGKASAN & LANJUT ============ --}}
            <div class="mt-6 bg-white border border-brand-100 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-center sm:text-left">
                    <p id="ringkasan-jumlah" class="text-xs text-ink/50 mb-1" data-text-template="{{ __('messages.total_produk_dipilih') }}">Total ({{ count($cart) }} {{ __('messages.produk_dipilih_suffix') }})</p>
                    <p id="ringkasan-total" class="text-xl font-bold text-brand-600">Rp{{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('katalog.index') }}"
                       class="flex-1 sm:flex-none text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-lg px-6 py-3.5 hover:bg-brand-50 transition-colors">
                        {{ __('messages.lanjut_belanja') }}
                    </a>
                    <form id="form-checkout" method="POST" action="{{ route('cart.checkout') }}" class="flex-1 sm:flex-none">
                        @csrf
                        <button type="submit" id="btn-lanjut-bayar"
                                class="w-full bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg px-6 py-3.5 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                            {{ __('messages.lanjut_ke_pembayaran') }}
                        </button>
                    </form>
                </div>
            </div>
        @endif

    </div>

    <script>
        (function () {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox');
            const pilihSemua = document.getElementById('pilih-semua');
            const ringkasanJumlah = document.getElementById('ringkasan-jumlah');
            const ringkasanTotal = document.getElementById('ringkasan-total');
            const btnLanjut = document.getElementById('btn-lanjut-bayar');
            const formCheckout = document.getElementById('form-checkout');

            if (!checkboxes.length) return;

            function formatRupiah(angka) {
                return 'Rp' + angka.toLocaleString('id-ID');
            }

            function hitungUlang() {
                let total = 0;
                let jumlahDipilih = 0;

                checkboxes.forEach(function (cb) {
                    if (cb.checked) {
                        total += parseInt(cb.getAttribute('data-harga'), 10);
                        jumlahDipilih++;
                    }
                });

                const suffix = "{{ __('messages.produk_dipilih_suffix') }}";
                ringkasanJumlah.textContent = 'Total (' + jumlahDipilih + ' ' + suffix + ')';
                ringkasanTotal.textContent = formatRupiah(total);
                btnLanjut.disabled = jumlahDipilih === 0;

                if (pilihSemua) {
                    pilihSemua.checked = jumlahDipilih === checkboxes.length;
                }
            }

            checkboxes.forEach(function (cb) {
                cb.addEventListener('change', hitungUlang);
            });

            if (pilihSemua) {
                pilihSemua.addEventListener('change', function () {
                    checkboxes.forEach(function (cb) {
                        cb.checked = pilihSemua.checked;
                    });
                    hitungUlang();
                });
            }

            formCheckout.addEventListener('submit', function () {
                formCheckout.querySelectorAll('input[name="produk[]"]').forEach(function (el) {
                    el.remove();
                });

                checkboxes.forEach(function (cb) {
                    if (cb.checked) {
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'produk[]';
                        hidden.value = cb.getAttribute('data-slug');
                        formCheckout.appendChild(hidden);
                    }
                });
            });

            hitungUlang();
        })();
    </script>

@endsection