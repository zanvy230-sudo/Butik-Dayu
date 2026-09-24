@extends('layouts.app')

@section('title', __('messages.checkout_judul') . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => 'katalog'])

    <div class="pt-28 md:pt-32 max-w-2xl mx-auto px-4 sm:px-6 pb-24">

        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-8 sm:mb-10">
            <h1 class="text-3xl md:text-4xl font-serif font-semibold text-brand-600 mb-2">{{ __('messages.checkout_judul') }}</h1>
            <p class="text-xs sm:text-sm text-ink/60 max-w-lg mx-auto leading-relaxed">
                {{ __('messages.checkout_subjudul') }}
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
                <p class="font-semibold mb-1">{{ __('messages.error_form_title') }}</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <input type="hidden" name="slug" value="{{ $slug }}">
            <input type="hidden" name="alamat_id" id="selected-alamat-id" value="{{ $alamatList->first()->id ?? '' }}">
            <input type="hidden" name="nama_produk" value="{{ $produk['nama'] }}">
            <input type="hidden" name="gambar_produk" value="{{ $produk['gambar_utama'] }}">
            <input type="hidden" name="size" id="selected-size" value="{{ $size }}">
            <input type="hidden" name="color" value="{{ $color }}">
            <input type="hidden" name="metode_pembayaran" id="selected-metode-pembayaran" value="transfer">

            <div class="space-y-5 sm:space-y-6">

                {{-- ============ 1. DATA PENYEWA ============ --}}
                <div class="bg-white border border-[#EBE3E5] rounded-2xl p-5 sm:p-7 shadow-xs">
                    <div class="flex items-center justify-between gap-4 mb-5">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-[#F3F4F6] border border-[#E5E7EB] text-ink font-sans font-bold text-xs flex items-center justify-center shrink-0">
                                1
                            </span>
                            <h2 class="font-serif text-lg sm:text-xl font-bold text-ink">{{ __('messages.data_penyewa') }}</h2>
                        </div>
                        <a href="{{ route('alamat.create') }}"
                           class="inline-flex items-center gap-1 border border-brand-200 text-brand-600 rounded-lg px-3 py-1 text-xs font-semibold hover:bg-brand-50 transition-colors">
                            {{ __('messages.tambah_data') }}
                        </a>
                    </div>

                    <div class="space-y-3" id="alamat-container">
                        @forelse ($alamatList as $index => $alamat)
                            @php $isSelected = $index === 0; @endphp
                            <div class="alamat-item rounded-xl p-4 transition-all cursor-pointer flex items-start justify-between gap-4
                                        {{ $isSelected ? 'bg-brand-50/60 border-0' : 'bg-white border border-[#E5E7EB] hover:border-brand-200' }}"
                                 data-id="{{ $alamat->id }}">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div class="pt-0.5 shrink-0">
                                        <span class="radio-circle w-4 h-4 rounded-full border flex items-center justify-center transition-colors
                                                     {{ $isSelected ? 'border-brand-600' : 'border-[#D1D5DB]' }}">
                                            <span class="radio-dot w-2 h-2 rounded-full bg-brand-600 {{ $isSelected ? '' : 'hidden' }}"></span>
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-ink text-sm">{{ $alamat->nama_penerima }}</p>
                                        <p class="text-xs text-ink/60 mt-0.5">{{ $alamat->telepon }}</p>
                                        <p class="text-xs text-ink/60 mt-0.5 leading-relaxed">{{ $alamat->alamat_lengkap }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('alamat.edit', $alamat) }}"
                                   class="text-xs font-medium text-brand-600 hover:underline shrink-0 pt-0.5">
                                    {{ __('messages.edit') }}
                                </a>
                            </div>
                        @empty
                            <p class="text-sm text-ink/50">
                                {{ __('messages.belum_ada_alamat') }}
                                <a href="{{ route('alamat.create') }}" class="text-brand-600 font-semibold hover:underline">{{ __('messages.tambah_alamat_sekarang') }}</a>.
                            </p>
                        @endforelse
                    </div>
                </div>

                {{-- ============ 2. TANGGAL SEWA ============ --}}
                <div class="bg-white border border-[#EBE3E5] rounded-2xl p-5 sm:p-7 shadow-xs">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-7 h-7 rounded-full bg-[#F3F4F6] border border-[#E5E7EB] text-ink font-sans font-bold text-xs flex items-center justify-center shrink-0">
                            2
                        </span>
                        <h2 class="font-serif text-lg sm:text-xl font-bold text-ink">{{ __('messages.tanggal_sewa') }}</h2>
                    </div>

                    <p class="text-xs sm:text-sm text-ink/60 mb-4">
                        {{ __('messages.tanggal_sewa_desc') }}
                    </p>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_sewa_mulai" class="block text-xs font-semibold text-ink/60 mb-1.5">{{ __('messages.dari_tanggal') }}</label>
                            <input type="text" name="tanggal_sewa_mulai" id="tanggal_sewa_mulai" required readonly
                                   placeholder="{{ __('messages.pilih_tanggal') }}"
                                   value="{{ old('tanggal_sewa_mulai') }}"
                                   class="tanggal-sewa-input w-full rounded-xl border border-[#E5E7EB] px-4 py-2.5 text-sm text-ink cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                        </div>
                        <div>
                            <label for="tanggal_sewa_selesai" class="block text-xs font-semibold text-ink/60 mb-1.5">{{ __('messages.sampai_tanggal') }}</label>
                            <input type="text" name="tanggal_sewa_selesai" id="tanggal_sewa_selesai" required readonly
                                   placeholder="{{ __('messages.pilih_tanggal') }}"
                                   value="{{ old('tanggal_sewa_selesai') }}"
                                   class="tanggal-sewa-input w-full rounded-xl border border-[#E5E7EB] px-4 py-2.5 text-sm text-ink cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                        </div>
                    </div>
                </div>

                {{-- ============ 3. PILIH UKURAN ============ --}}
                <div class="bg-white border border-[#EBE3E5] rounded-2xl p-5 sm:p-7 shadow-xs">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-7 h-7 rounded-full bg-[#F3F4F6] border border-[#E5E7EB] text-ink font-sans font-bold text-xs flex items-center justify-center shrink-0">
                            3
                        </span>
                        <h2 class="font-serif text-lg sm:text-xl font-bold text-ink">{{ __('messages.pilih_ukuran') }}</h2>
                    </div>

                    <p class="text-xs sm:text-sm text-ink/60 mb-4">
                        {{ __('messages.pilih_ukuran_desc') }}
                    </p>

                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2.5" id="ukuran-container">
                        @foreach ($ukuranList as $ukuran => $stok)
                            @php $habis = $stok < 1; @endphp
                            <button type="button"
                                    data-ukuran="{{ $ukuran }}"
                                    {{ $habis ? 'disabled' : '' }}
                                    class="ukuran-item rounded-xl py-3 px-1.5 text-center transition-all border
                                           {{ $habis
                                                ? 'bg-[#F3F4F6] border-[#E5E7EB] text-ink/30 cursor-not-allowed'
                                                : ($ukuran === $size
                                                    ? 'bg-brand-50/60 border-brand-500 text-brand-700 cursor-pointer'
                                                    : 'bg-white border-[#E5E7EB] text-ink hover:border-brand-200 cursor-pointer') }}">
                                <span class="block text-sm font-semibold leading-tight">{{ $ukuran }}</span>
                                <span class="block text-[10px] mt-1 {{ $habis ? 'text-ink/30' : 'text-ink/50' }}">
                                    {{ $habis ? __('messages.habis_label') : __('messages.stok_label') . ' ' . $stok }}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    @error('size')
                        <p class="text-xs text-red-500 mt-3">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ============ 4. METODE PEMBAYARAN ============ --}}
                <div class="bg-white border border-[#EBE3E5] rounded-2xl p-5 sm:p-7 shadow-xs">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-7 h-7 rounded-full bg-[#F3F4F6] border border-[#E5E7EB] text-ink font-sans font-bold text-xs flex items-center justify-center shrink-0">
                            4
                        </span>
                        <h2 class="font-serif text-lg sm:text-xl font-bold text-ink">{{ __('messages.metode_pembayaran_judul') }}</h2>
                    </div>

                    <div class="space-y-3" id="pembayaran-container">
                        {{-- Opsi 1: Transfer Bank --}}
                        <div class="pembayaran-item rounded-xl p-4 transition-all cursor-pointer flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-[#E5E7EB] hover:border-brand-200"
                             data-metode="transfer">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="radio-circle w-4 h-4 rounded-full border border-[#D1D5DB] flex items-center justify-center shrink-0 transition-colors">
                                    <span class="radio-dot w-2 h-2 rounded-full bg-brand-600 hidden"></span>
                                </span>
                                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-500 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5m-15 10.5V10.5M3 21h18M3 10.5h18" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-ink text-sm">{{ __('messages.transfer_bank') }}</p>
                                    <p class="text-xs text-ink/50 mt-0.5 truncate">{{ __('messages.transfer_bank_desc') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0 pl-7 sm:pl-0 flex-wrap">
                                <span class="h-6 sm:h-7 px-2.5 flex items-center justify-center bg-white border border-[#E5E7EB] rounded-md text-[10px] sm:text-xs font-bold text-ink/70">BCA</span>
                                <span class="h-6 sm:h-7 px-2.5 flex items-center justify-center bg-white border border-[#E5E7EB] rounded-md text-[10px] sm:text-xs font-bold text-ink/70">BNI</span>
                                <span class="h-6 sm:h-7 px-2.5 flex items-center justify-center bg-white border border-[#E5E7EB] rounded-md text-[10px] sm:text-xs font-bold text-ink/70">BRI</span>
                                <span class="h-6 sm:h-7 px-2.5 flex items-center justify-center bg-white border border-[#E5E7EB] rounded-md text-[10px] sm:text-xs font-bold text-ink/70">Mandiri</span>
                            </div>
                        </div>

                        {{-- Opsi 2: COD --}}
                        <div class="pembayaran-item rounded-xl p-4 transition-all cursor-pointer flex items-center justify-between gap-3 border border-[#E5E7EB] hover:border-brand-200"
                             data-metode="cod">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="radio-circle w-4 h-4 rounded-full border border-[#D1D5DB] flex items-center justify-center shrink-0 transition-colors">
                                    <span class="radio-dot w-2 h-2 rounded-full bg-brand-600 hidden"></span>
                                </span>
                                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-500 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6H2.25m0 0v10.5m0-10.5h19.5m0 0v.75a.75.75 0 01-.75.75h-.75m1.5-1.5h.75m0 0v10.5m0-10.5h-.75M3.75 19.5h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-ink text-sm">{{ __('messages.cod_label') }}</p>
                                    <p class="text-xs text-ink/50 mt-0.5 truncate">{{ __('messages.cod_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============ 5. RINGKASAN PESANAN ============ --}}
                <div class="bg-white border border-[#EBE3E5] rounded-2xl p-5 sm:p-7 shadow-xs">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-7 h-7 rounded-full bg-[#F3F4F6] border border-[#E5E7EB] text-ink font-sans font-bold text-xs flex items-center justify-center shrink-0">
                            5
                        </span>
                        <h2 class="font-serif text-lg sm:text-xl font-bold text-ink">{{ __('messages.ringkasan_pesanan') }}</h2>
                    </div>

                    <div class="border border-[#E5E7EB] rounded-xl p-4 flex items-start justify-between gap-4 mb-5">
                        <div class="flex items-start gap-3.5 min-w-0">
                            <img src="{{ $produk['gambar_utama'] }}"
                                 alt="{{ $produk['nama'] }}"
                                 class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover shrink-0">
                            <div class="min-w-0">
                                <h3 class="font-serif text-sm sm:text-base font-semibold text-ink leading-snug">
                                    {{ $produk['nama'] }}
                                </h3>
                                <div class="mt-1 space-y-0.5 text-xs text-ink/60">
                                    <p>Size: <span id="summary-size-text">{{ $size }}</span></p>
                                    <p>Color: {{ $color }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-sm sm:text-base font-semibold text-ink">
                                Rp{{ number_format($hargaProduk, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs sm:text-sm text-ink/70 mb-4">
                        <div class="flex justify-between items-center">
                            <span>{{ __('messages.subtotal') }}</span>
                            <span class="font-medium text-ink">Rp{{ number_format($hargaProduk, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Tambahan sewa (hari ke-3+)</span>
                            <span id="biaya-tambahan-sewa" class="font-medium text-ink">Rp{{ number_format($biayaTambahanSewa, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="border-t border-[#E5E7EB] pt-3.5 flex justify-between items-center">
                        <span class="font-serif text-sm sm:text-base font-bold text-ink">{{ __('messages.total_pembayaran') }}</span>
                        <span id="total-pembayaran" class="font-bold text-sm sm:text-base text-ink">
                            Rp{{ number_format($totalPembayaran, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="bg-brand-50/70 border border-brand-100 rounded-xl p-3.5 flex items-center gap-3 mt-5 mb-5">
                        <div class="w-7 h-7 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-brand-700 text-xs sm:text-sm">{{ __('messages.transaksi_aman') }}</p>
                            <p class="text-[11px] sm:text-xs text-ink/60 mt-0.5">{{ __('messages.transaksi_aman_desc') }}</p>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3.5 rounded-xl text-center text-sm sm:text-base transition-colors shadow-sm cursor-pointer">
                        {{ __('messages.checkout_pesanan_btn') }}
                    </button>
                </div>

            </div>
        </form>

    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .flatpickr-day.selected, .flatpickr-day.selected:hover, .flatpickr-day.startRange, .flatpickr-day.endRange { background: #9d174d; border-color: #9d174d; }
        .flatpickr-day.today { border-color: #9d174d; }
        .flatpickr-day:hover { background: #fce7f0; }
        .flatpickr-calendar { box-shadow: 0 10px 30px -5px rgba(0,0,0,0.15); border-radius: 0.75rem; border: 1px solid #EBE3E5; }
    </style>
    <script>
        (function () {
            const alamatItems = document.querySelectorAll('.alamat-item');
            const selectedAlamatInput = document.getElementById('selected-alamat-id');
            alamatItems.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    if (e.target.tagName === 'A') return;
                    alamatItems.forEach(function (el) {
                        el.classList.remove('bg-brand-50/60', 'border-0');
                        el.classList.add('bg-white', 'border', 'border-[#E5E7EB]');
                        const radio = el.querySelector('.radio-circle');
                        const dot = el.querySelector('.radio-dot');
                        if (radio) { radio.classList.remove('border-brand-600'); radio.classList.add('border-[#D1D5DB]'); }
                        if (dot) dot.classList.add('hidden');
                    });
                    item.classList.add('bg-brand-50/60', 'border-0');
                    item.classList.remove('bg-white', 'border', 'border-[#E5E7EB]');
                    const radio = item.querySelector('.radio-circle');
                    const dot = item.querySelector('.radio-dot');
                    if (radio) { radio.classList.add('border-brand-600'); radio.classList.remove('border-[#D1D5DB]'); }
                    if (dot) dot.classList.remove('hidden');
                    if (selectedAlamatInput) selectedAlamatInput.value = item.getAttribute('data-id');
                });
            });

            const ukuranItems = document.querySelectorAll('.ukuran-item');
            const selectedSizeInput = document.getElementById('selected-size');
            const summarySizeText = document.getElementById('summary-size-text');
            ukuranItems.forEach(function (item) {
                item.addEventListener('click', function () {
                    if (item.disabled) return;
                    ukuranItems.forEach(function (el) {
                        el.classList.remove('bg-brand-50/60', 'border-brand-500', 'text-brand-700');
                        if (!el.disabled) el.classList.add('bg-white', 'border-[#E5E7EB]', 'text-ink');
                    });
                    item.classList.add('bg-brand-50/60', 'border-brand-500', 'text-brand-700');
                    item.classList.remove('bg-white', 'border-[#E5E7EB]', 'text-ink');
                    const ukuran = item.getAttribute('data-ukuran');
                    if (selectedSizeInput) selectedSizeInput.value = ukuran;
                    if (summarySizeText) summarySizeText.textContent = ukuran;
                });
            });

            const pembayaranItems = document.querySelectorAll('.pembayaran-item');
            const selectedMetodeInput = document.getElementById('selected-metode-pembayaran');
            pembayaranItems.forEach(function (item) {
                item.addEventListener('click', function () {
                    pembayaranItems.forEach(function (el) {
                        el.classList.remove('bg-brand-50/60', 'border-brand-200');
                        el.classList.add('bg-white', 'border-[#E5E7EB]');
                        const radio = el.querySelector('.radio-circle');
                        const dot = el.querySelector('.radio-dot');
                        if (radio) { radio.classList.remove('border-brand-600'); radio.classList.add('border-[#D1D5DB]'); }
                        if (dot) dot.classList.add('hidden');
                    });
                    item.classList.add('bg-brand-50/60', 'border-brand-200');
                    item.classList.remove('bg-white', 'border-[#E5E7EB]');
                    const radio = item.querySelector('.radio-circle');
                    const dot = item.querySelector('.radio-dot');
                    if (radio) { radio.classList.add('border-brand-600'); radio.classList.remove('border-[#D1D5DB]'); }
                    if (dot) dot.classList.remove('hidden');
                    if (selectedMetodeInput) selectedMetodeInput.value = item.getAttribute('data-metode');
                });
            });

            var tanggalSewaSudahInit = false;
            var hargaProduk = {{ (int) $hargaProduk }};
            var biayaPerHariTambahan = 25000;
            var biayaTambahanSewa = document.getElementById('biaya-tambahan-sewa');
            var totalPembayaran = document.getElementById('total-pembayaran');

            function perbaruiTotalSewa() {
                var inputMulai = document.getElementById('tanggal_sewa_mulai');
                var inputSelesai = document.getElementById('tanggal_sewa_selesai');
                if (!inputMulai || !inputSelesai || !inputMulai.value || !inputSelesai.value) return;

                var mulai = new Date(inputMulai.value + 'T00:00:00');
                var selesai = new Date(inputSelesai.value + 'T00:00:00');
                var jumlahHari = Math.floor((selesai - mulai) / 86400000) + 1;
                var tambahan = Math.max(0, jumlahHari - 2) * biayaPerHariTambahan;
                var total = hargaProduk + tambahan;
                var formatRupiah = new Intl.NumberFormat('id-ID');

                if (biayaTambahanSewa) biayaTambahanSewa.textContent = 'Rp' + formatRupiah.format(tambahan);
                if (totalPembayaran) totalPembayaran.textContent = 'Rp' + formatRupiah.format(total);
            }

            function initTanggalSewa() {
                if (tanggalSewaSudahInit) return;
                tanggalSewaSudahInit = true;
                var inputMulai = document.getElementById('tanggal_sewa_mulai');
                var inputSelesai = document.getElementById('tanggal_sewa_selesai');
                if (typeof flatpickr === 'function') {
                    var pickerSelesai = flatpickr(inputSelesai, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd F Y', minDate: 'today', disableMobile: true, onChange: perbaruiTotalSewa });
                    flatpickr(inputMulai, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd F Y', minDate: 'today', disableMobile: true, onChange: function (selectedDates, dateStr) { pickerSelesai.set('minDate', dateStr); perbaruiTotalSewa(); } });
                }
            }
            if (typeof flatpickr === 'function') { initTanggalSewa(); } else { window.addEventListener('load', initTanggalSewa); setTimeout(initTanggalSewa, 1500); }
        })();
    </script>
@endsection