@extends('layouts.app')

@section('title', 'Edit Pesanan - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-2xl mx-auto px-4 sm:px-6 pb-24">

        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-serif font-semibold text-brand-600 mb-2">Edit Pesanan</h1>
            <p class="text-sm text-ink/60">Perbarui detail pesanan Anda sebelum dikonfirmasi tim kami</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pesanan.update', $pesanan) }}" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- ============ KARTU PRODUK (hanya info, tidak bisa diedit) ============ --}}
            <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6 flex items-center gap-4">
                <img src="{{ $pesanan->gambar_produk ?: asset('images/Logo_butik.png') }}"
                     alt="{{ $pesanan->nama_produk }}"
                     class="w-20 h-20 rounded-xl object-cover shrink-0">
                <div class="min-w-0">
                    <p class="font-serif text-base sm:text-lg font-semibold text-ink truncate">{{ $pesanan->nama_produk }}</p>
                    <p class="text-sm font-semibold text-brand-700 mt-1">
                        Rp{{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- ============ DATA PESANAN ============ --}}
            <div class="bg-white border border-brand-100 rounded-2xl p-6 space-y-5">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Ukuran</label>
                        <select name="size" class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink">
                            @foreach (['S (Anak)', 'M (Anak)', 'S', 'M', 'L', 'XL'] as $ukuran)
                                <option value="{{ $ukuran }}" {{ $pesanan->size === $ukuran ? 'selected' : '' }}>
                                    {{ $ukuran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Warna</label>
                        <input type="text" name="color" value="{{ old('color', $pesanan->color) }}"
                               class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Nama Penerima</label>
                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima', $pesanan->nama_penerima) }}"
                           class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-2">No. Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $pesanan->telepon) }}"
                           class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="3"
                              class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">{{ old('alamat_lengkap', $pesanan->alamat_lengkap) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Dari Tanggal</label>
                        <input type="text" name="tanggal_sewa_mulai" id="tanggal_sewa_mulai" readonly
                               value="{{ old('tanggal_sewa_mulai', optional($pesanan->tanggal_sewa_mulai)->format('Y-m-d')) }}"
                               class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Sampai Tanggal</label>
                        <input type="text" name="tanggal_sewa_selesai" id="tanggal_sewa_selesai" readonly
                               value="{{ old('tanggal_sewa_selesai', optional($pesanan->tanggal_sewa_selesai)->format('Y-m-d')) }}"
                               class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                    </div>
                </div>

            </div>

            {{-- ============ METODE PEMBAYARAN (bisa diganti) ============ --}}
            <div class="bg-white border border-brand-100 rounded-2xl p-6">
                <h2 class="font-serif text-lg font-bold text-ink mb-4">Metode Pembayaran</h2>

                <input type="hidden" name="metode_pembayaran" id="selected-metode-pembayaran"
                       value="{{ old('metode_pembayaran', $pesanan->metode_pembayaran) }}">

                <div class="space-y-3" id="pembayaran-container">
                    {{-- Opsi 1: Transfer Bank --}}
                    <div class="pembayaran-item rounded-xl p-4 transition-all cursor-pointer flex flex-col sm:flex-row sm:items-center justify-between gap-3 border
                                {{ $pesanan->metode_pembayaran === 'transfer' ? 'bg-brand-50/60 border-brand-200' : 'bg-white border-[#E5E7EB] hover:border-brand-200' }}"
                         data-metode="transfer">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="radio-circle w-4 h-4 rounded-full border flex items-center justify-center shrink-0 transition-colors
                                         {{ $pesanan->metode_pembayaran === 'transfer' ? 'border-brand-600' : 'border-[#D1D5DB]' }}">
                                <span class="radio-dot w-2 h-2 rounded-full bg-brand-600 {{ $pesanan->metode_pembayaran === 'transfer' ? '' : 'hidden' }}"></span>
                            </span>
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-500 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5m-15 10.5V10.5M3 21h18M3 10.5h18" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-ink text-sm">Transfer Bank</p>
                                <p class="text-xs text-ink/50 mt-0.5 truncate">BCA, BNI, BRI, Mandiri, dan bank lainnya</p>
                            </div>
                        </div>
                    </div>

                    {{-- Opsi 2: COD --}}
                    <div class="pembayaran-item rounded-xl p-4 transition-all cursor-pointer flex items-center justify-between gap-3 border
                                {{ $pesanan->metode_pembayaran === 'cod' ? 'bg-brand-50/60 border-brand-200' : 'bg-white border-[#E5E7EB] hover:border-brand-200' }}"
                         data-metode="cod">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="radio-circle w-4 h-4 rounded-full border flex items-center justify-center shrink-0 transition-colors
                                         {{ $pesanan->metode_pembayaran === 'cod' ? 'border-brand-600' : 'border-[#D1D5DB]' }}">
                                <span class="radio-dot w-2 h-2 rounded-full bg-brand-600 {{ $pesanan->metode_pembayaran === 'cod' ? '' : 'hidden' }}"></span>
                            </span>
                            <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-500 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v10.5m0-10.5h19.5m0 0v.75a.75.75 0 01-.75.75h-.75m1.5-1.5h.75m0 0v10.5m0-10.5h-.75M3.75 19.5h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM12 15a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-ink text-sm">COD (Bayar di Tempat)</p>
                                <p class="text-xs text-ink/50 mt-0.5 truncate">Hanya berlaku untuk daerah Jakarta dan sekitarnya</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('profile.settings', ['tab' => 'riwayat']) }}"
                   class="flex-1 text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-xl py-3.5 hover:bg-brand-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3.5 rounded-xl text-sm transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .flatpickr-day.selected, .flatpickr-day.selected:hover,
        .flatpickr-day.startRange, .flatpickr-day.endRange { background: #9d174d; border-color: #9d174d; }
        .flatpickr-day.today { border-color: #9d174d; }
        .flatpickr-day:hover { background: #fce7f0; }
        .flatpickr-calendar { box-shadow: 0 10px 30px -5px rgba(0,0,0,0.15); border-radius: 0.75rem; border: 1px solid #EBE3E5; }
    </style>
    <script>
        (function () {
            var inputMulai = document.getElementById('tanggal_sewa_mulai');
            var inputSelesai = document.getElementById('tanggal_sewa_selesai');

            function initTanggal() {
                if (typeof flatpickr === 'function') {
                    var pickerSelesai = flatpickr(inputSelesai, {
                        dateFormat: 'Y-m-d', altInput: true, altFormat: 'd F Y', minDate: 'today',
                    });
                    flatpickr(inputMulai, {
                        dateFormat: 'Y-m-d', altInput: true, altFormat: 'd F Y', minDate: 'today',
                        onChange: function (selectedDates, dateStr) {
                            pickerSelesai.set('minDate', dateStr);
                        },
                    });
                } else {
                    [inputMulai, inputSelesai].forEach(function (input) {
                        input.type = 'date';
                        input.readOnly = false;
                    });
                }
            }

            if (typeof flatpickr === 'function') { initTanggal(); }
            else { window.addEventListener('load', initTanggal); setTimeout(initTanggal, 1500); }
        })();

        // Interaksi pemilihan metode pembayaran
        (function () {
            const pembayaranItems = document.querySelectorAll('.pembayaran-item');
            const selectedMetodeInput = document.getElementById('selected-metode-pembayaran');

            pembayaranItems.forEach(function (item) {
                item.addEventListener('click', function () {
                    pembayaranItems.forEach(function (el) {
                        el.classList.remove('bg-brand-50/60', 'border-brand-200');
                        el.classList.add('bg-white', 'border-[#E5E7EB]');
                        const radio = el.querySelector('.radio-circle');
                        const dot = el.querySelector('.radio-dot');
                        if (radio) {
                            radio.classList.remove('border-brand-600');
                            radio.classList.add('border-[#D1D5DB]');
                        }
                        if (dot) dot.classList.add('hidden');
                    });

                    item.classList.add('bg-brand-50/60', 'border-brand-200');
                    item.classList.remove('bg-white', 'border-[#E5E7EB]');
                    const radio = item.querySelector('.radio-circle');
                    const dot = item.querySelector('.radio-dot');
                    if (radio) {
                        radio.classList.add('border-brand-600');
                        radio.classList.remove('border-[#D1D5DB]');
                    }
                    if (dot) dot.classList.remove('hidden');

                    if (selectedMetodeInput) {
                        selectedMetodeInput.value = item.getAttribute('data-metode');
                    }
                });
            });
        })();
    </script>

@endsection