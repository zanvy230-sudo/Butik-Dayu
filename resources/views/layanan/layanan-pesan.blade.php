@extends('layouts.app')

@section('title', __('messages.pesan_label') . ' ' . $paket['nama'] . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => 'layanan'])

    <div class="pt-28 md:pt-32 max-w-lg mx-auto px-4 sm:px-6 pb-24">

        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-serif font-semibold text-brand-600 mb-2">{{ __('messages.form_pemesanan') }}</h1>
            <p class="text-sm text-ink/60 max-w-md mx-auto leading-relaxed">
                {{ __('messages.form_pemesanan_desc') }}
            </p>
        </div>

        {{-- ============ RINGKASAN PAKET ============ --}}
        <div class="bg-white border border-brand-100 rounded-2xl p-5 mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-ink/40 uppercase tracking-wide mb-1">{{ __('messages.paket_dipilih') }}</p>
                <p class="font-serif font-semibold text-ink text-lg">{{ $paket['nama'] }}</p>
            </div>
            <p class="font-bold text-brand-600">Rp{{ number_format($paket['harga'], 0, ',', '.') }}</p>
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

        {{-- ============ FORM ============ --}}
        <form method="POST" action="{{ route('rias.pesan.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="paket_slug" value="{{ $paket['slug'] }}">
            <input type="hidden" name="alamat_id" id="selected-alamat-id" value="{{ old('alamat_id', $alamatList->first()->id ?? '') }}">
            <input type="hidden" name="metode_pembayaran" id="selected-metode-pembayaran" value="transfer">

            <div class="bg-white border border-brand-100 rounded-2xl p-5 space-y-5">

                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-sm font-semibold text-ink">Alamat Acara</h2>
                    <a href="{{ route('alamat.create') }}"
                       class="inline-flex items-center gap-1 border border-brand-200 text-brand-600 rounded-lg px-3 py-1 text-xs font-semibold hover:bg-brand-50 transition-colors">
                        {{ __('messages.tambah_data') }}
                    </a>
                </div>

                <div class="space-y-3" id="alamat-container">
                    @forelse ($alamatList as $index => $alamat)
                        @php $isSelected = (string) old('alamat_id', $alamatList->first()->id ?? '') === (string) $alamat->id; @endphp
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

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_acara" class="block text-sm font-semibold text-ink mb-1.5">{{ __('messages.tanggal_acara') }}</label>
                        <input type="text" name="tanggal_acara" id="tanggal_acara" required readonly
                               placeholder="{{ __('messages.pilih_tanggal') }}"
                               value="{{ old('tanggal_acara') }}"
                               class="tanggal-picker w-full rounded-xl border border-brand-200 px-4 py-2.5 text-sm text-ink cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                    </div>
                    <div>
                        <label for="jam_acara" class="block text-sm font-semibold text-ink mb-1.5">{{ __('messages.jam_acara') }}</label>
                        <input type="text" name="jam_acara" id="jam_acara" required readonly
                               placeholder="{{ __('messages.pilih_jam') }}"
                               value="{{ old('jam_acara') }}"
                               class="jam-picker w-full rounded-xl border border-brand-200 px-4 py-2.5 text-sm text-ink cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                    </div>
                </div>

                <div>
                    <label for="catatan" class="block text-sm font-semibold text-ink mb-1.5">
                        {{ __('messages.catatan_tambahan') }} <span class="text-ink/40 font-normal">({{ __('messages.opsional') }})</span>
                    </label>
                    <textarea name="catatan" id="catatan" rows="3"
                              placeholder="{{ __('messages.catatan_placeholder') }}"
                              class="w-full rounded-xl border border-brand-200 px-4 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">{{ old('catatan') }}</textarea>
                </div>

            </div>

            {{-- ============ METODE PEMBAYARAN ============ --}}
            <div class="bg-white border border-brand-100 rounded-2xl p-5">
                <h2 class="text-sm font-semibold text-ink mb-4">{{ __('messages.metode_pembayaran_judul') }}</h2>

                <div class="space-y-3" id="pembayaran-container">
                    <div class="pembayaran-item rounded-xl p-4 transition-all cursor-pointer flex items-center justify-between gap-3 border-2 border-brand-500 bg-brand-50/60"
                         data-metode="transfer">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="radio-circle w-4 h-4 rounded-full border border-brand-600 flex items-center justify-center shrink-0 transition-colors">
                                <span class="radio-dot w-2 h-2 rounded-full bg-brand-600"></span>
                            </span>
                            <div class="w-8 h-8 rounded-lg bg-brand-100 text-brand-500 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5m-15 10.5V10.5M3 21h18M3 10.5h18" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-ink text-sm">{{ __('messages.transfer_bank') }}</p>
                                <p class="text-xs text-ink/50 mt-0.5">{{ __('messages.transfer_rias_desc') }}</p>
                            </div>
                        </div>
                    </div>

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
                                <p class="text-xs text-ink/50 mt-0.5">{{ __('messages.cod_rias_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <button type="submit"
                        class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3.5 rounded-xl text-sm sm:text-base transition-colors">
                    {{ __('messages.kirim_pemesanan') }}
                </button>
                <a href="{{ route('layanan.index') }}"
                   class="block text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-xl py-3.5 hover:bg-brand-50 transition-colors">
                    {{ __('messages.batal') }}
                </a>
            </div>
        </form>

    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .flatpickr-day.selected, .flatpickr-day.selected:hover, .flatpickr-day.startRange, .flatpickr-day.endRange { background: #9d174d; border-color: #9d174d; }
        .flatpickr-day.today { border-color: #9d174d; }
        .flatpickr-day:hover { background: #fce7f0; }
        .flatpickr-calendar { box-shadow: 0 10px 30px -5px rgba(0,0,0,0.15); border-radius: 0.75rem; border: 1px solid #f3e6eb; }
    </style>
    <script>
        (function () {
            var sudahInit = false;
            function initPicker() {
                if (sudahInit) return;
                sudahInit = true;
                if (typeof flatpickr !== 'function') return;
                flatpickr('#tanggal_acara', { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd F Y', minDate: 'today', disableMobile: true });
                flatpickr('#jam_acara', { enableTime: true, noCalendar: true, dateFormat: 'H:i', time_24hr: true, minuteIncrement: 15, disableMobile: true });
            }
            if (typeof flatpickr === 'function') { initPicker(); } else { window.addEventListener('load', initPicker); setTimeout(initPicker, 1500); }

            const alamatItems = document.querySelectorAll('.alamat-item');
            const selectedAlamatInput = document.getElementById('selected-alamat-id');
            alamatItems.forEach(function (item) {
                item.addEventListener('click', function (event) {
                    if (event.target.closest('a')) return;

                    alamatItems.forEach(function (el) {
                        el.classList.remove('bg-brand-50/60', 'border-0');
                        el.classList.add('bg-white', 'border', 'border-[#E5E7EB]');
                        const radio = el.querySelector('.radio-circle');
                        const dot = el.querySelector('.radio-dot');
                        if (radio) { radio.classList.remove('border-brand-600'); radio.classList.add('border-[#D1D5DB]'); }
                        if (dot) dot.classList.add('hidden');
                    });

                    item.classList.remove('bg-white', 'border', 'border-[#E5E7EB]');
                    item.classList.add('bg-brand-50/60', 'border-0');
                    const radio = item.querySelector('.radio-circle');
                    const dot = item.querySelector('.radio-dot');
                    if (radio) { radio.classList.add('border-brand-600'); radio.classList.remove('border-[#D1D5DB]'); }
                    if (dot) dot.classList.remove('hidden');
                    if (selectedAlamatInput) selectedAlamatInput.value = item.getAttribute('data-id');
                });
            });

            const pembayaranItems = document.querySelectorAll('.pembayaran-item');
            const selectedMetodeInput = document.getElementById('selected-metode-pembayaran');
            pembayaranItems.forEach(function (item) {
                item.addEventListener('click', function () {
                    pembayaranItems.forEach(function (el) {
                        el.classList.remove('border-2', 'border-brand-500', 'bg-brand-50/60');
                        el.classList.add('border', 'border-[#E5E7EB]');
                        const radio = el.querySelector('.radio-circle');
                        const dot = el.querySelector('.radio-dot');
                        if (radio) { radio.classList.remove('border-brand-600'); radio.classList.add('border-[#D1D5DB]'); }
                        if (dot) dot.classList.add('hidden');
                    });
                    item.classList.remove('border', 'border-[#E5E7EB]');
                    item.classList.add('border-2', 'border-brand-500', 'bg-brand-50/60');
                    const radio = item.querySelector('.radio-circle');
                    const dot = item.querySelector('.radio-dot');
                    if (radio) { radio.classList.add('border-brand-600'); radio.classList.remove('border-[#D1D5DB]'); }
                    if (dot) dot.classList.remove('hidden');
                    if (selectedMetodeInput) selectedMetodeInput.value = item.getAttribute('data-metode');
                });
            });
        })();
    </script>
@endsection