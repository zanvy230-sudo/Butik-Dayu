@extends('layouts.app')

@section('title', __('messages.struk_pemesanan') . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => 'layanan'])

    <div class="pt-28 md:pt-32 max-w-lg mx-auto px-4 sm:px-6 pb-24">

        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-serif font-semibold text-brand-600 mb-2">{{ __('messages.pemesanan_berhasil') }}</h1>
            <p class="text-sm text-ink/60 max-w-md mx-auto leading-relaxed">
                {!! __('messages.struk_rias_cod_desc') !!}
            </p>
        </div>

        {{-- ============ STRUK (yang di-download) ============ --}}
        <div id="struk" class="bg-white border border-brand-100 rounded-2xl p-6 mb-6">
            <div class="text-center border-b border-dashed border-brand-200 pb-4 mb-4">
                <p class="font-serif text-lg font-semibold text-brand-600">Butik Dayu</p>
                <p class="text-xs text-ink/50">{{ __('messages.struk_layanan_rias') }}</p>
            </div>

            <div class="space-y-2 text-sm mb-4">
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.no_pemesanan') }}</span>
                    <span class="font-semibold text-ink">#{{ $pemesanan->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.nama_label') }}</span>
                    <span class="font-semibold text-ink">{{ $pemesanan->nama_lengkap }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.no_telepon_label_pendek') }}</span>
                    <span class="font-semibold text-ink">{{ $pemesanan->telepon }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.paket_label') }}</span>
                    <span class="font-semibold text-ink">{{ $pemesanan->paket_nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.tanggal_acara_label') }}</span>
                    <span class="font-semibold text-ink">{{ \Carbon\Carbon::parse($pemesanan->tanggal_acara)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.jam_acara_label') }}</span>
                    <span class="font-semibold text-ink">{{ $pemesanan->jam_acara }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.lokasi_label') }}</span>
                    <span class="font-semibold text-ink text-right max-w-[60%]">{{ $pemesanan->alamat_acara }}</span>
                </div>
                @if ($pemesanan->catatan)
                    <div class="flex justify-between">
                        <span class="text-ink/50">{{ __('messages.catatan_label') }}</span>
                        <span class="font-semibold text-ink text-right max-w-[60%]">{{ $pemesanan->catatan }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-ink/50">{{ __('messages.metode_bayar_label') }}</span>
                    <span class="font-semibold text-ink">{{ __('messages.cod_label_full') }}</span>
                </div>
            </div>

            <div class="border-t border-dashed border-brand-200 pt-4 flex justify-between items-center">
                <span class="font-serif font-bold text-ink">{{ __('messages.total_bayar') }}</span>
                <span class="font-bold text-brand-600 text-lg">Rp{{ number_format($pemesanan->paket_harga, 0, ',', '.') }}</span>
            </div>

            <p class="text-center text-xs text-ink/40 mt-4">
                Status: {{ method_exists($pemesanan, 'labelStatus') ? $pemesanan->labelStatus() : __('messages.menunggu_konfirmasi') }}
            </p>
        </div>

        {{-- ============ TOMBOL AKSI ============ --}}
        <div class="space-y-3">
            <button type="button" id="btn-download"
                    class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3.5 rounded-xl text-sm sm:text-base transition-colors">
                {{ __('messages.download_struk') }}
            </button>
            <a href="{{ route('layanan.index') }}"
               class="block text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-xl py-3.5 hover:bg-brand-50 transition-colors">
                {{ __('messages.kembali_layanan_rias') }}
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas-pro@latest/dist/html2canvas-pro.min.js"></script>
    <script>
        (function () {
            const btn = document.getElementById('btn-download');
            const struk = document.getElementById('struk');

            btn.addEventListener('click', function () {
                if (typeof html2canvas !== 'function') {
                    alert('{{ __('messages.alert_gagal_muat_alat') }}');
                    return;
                }

                const labelAsli = btn.textContent;
                btn.textContent = '{{ __('messages.menyiapkan') }}';
                btn.disabled = true;

                try {
                    html2canvas(struk, { backgroundColor: '#ffffff', scale: 2 }).then(function (canvas) {
                        const link = document.createElement('a');
                        link.download = 'struk-pemesanan-{{ $pemesanan->id }}.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();

                        btn.textContent = labelAsli;
                        btn.disabled = false;
                    }).catch(function (err) {
                        console.error(err);
                        alert('{{ __('messages.alert_gagal_buat_gambar') }}');
                        btn.textContent = labelAsli;
                        btn.disabled = false;
                    });
                } catch (err) {
                    console.error(err);
                    alert('{{ __('messages.alert_gagal_buat_gambar') }}');
                    btn.textContent = labelAsli;
                    btn.disabled = false;
                }
            });
        })();
    </script>

@endsection