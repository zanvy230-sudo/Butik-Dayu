@extends('layouts.app')

@section('title', __('messages.struk_pesanan') . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-lg mx-auto px-4 sm:px-6 pb-24">

        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-serif font-semibold text-brand-600 mb-2">{{ __('messages.struk_pesanan') }}</h1>
            <p class="text-sm text-ink/60 max-w-md mx-auto leading-relaxed">
                {!! __('messages.struk_cod_desc') !!}
            </p>
        </div>

        {{-- ============ STRUK AREA ============ --}}
        <div id="struk-area" class="bg-white border border-brand-100 rounded-2xl divide-y divide-brand-100 mb-6">

            <div class="p-5">
                <p class="text-xs text-ink/50 mb-0.5">{{ __('messages.nomor_pesanan') }}</p>
                <p class="font-mono font-semibold text-ink text-base tracking-wide">
                    #{{ str_pad($checkout['pesanan_id'], 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>

            @foreach ($checkout['items'] as $item)
                <div class="p-5 flex items-center gap-4">
                    @if(!empty($item['gambar']))
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}"
                         class="w-16 h-16 rounded-xl object-cover shrink-0">
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="font-serif font-semibold text-ink text-sm truncate">{{ $item['nama'] }}</p>
                        <p class="text-xs text-ink/50 mt-0.5">
                            Size: {{ $item['size'] ?? '-' }} &middot; Color: {{ $item['color'] ?? '-' }}
                            @if (($item['qty'] ?? 1) > 1)
                                &middot; {{ __('messages.jumlah_label') }}: {{ $item['qty'] }}
                            @endif
                        </p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="font-semibold text-ink text-sm">Rp{{ number_format($item['harga'] * ($item['qty'] ?? 1), 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach

            <div class="p-5 flex items-center justify-between bg-brand-50/40">
                <p class="text-sm font-semibold text-ink">{{ __('messages.total_bayar') }}</p>
                <p class="font-bold text-brand-600">Rp{{ number_format($checkout['total_pembayaran'], 0, ',', '.') }}</p>
            </div>

            <div class="p-5">
                <p class="text-xs font-semibold text-ink/40 uppercase tracking-wide mb-3">{{ __('messages.detail_pemesanan') }}</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-ink/50 shrink-0">{{ __('messages.penerima') }}</span>
                        <span class="font-medium text-ink text-right">{{ $checkout['nama_penerima'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-ink/50 shrink-0">{{ __('messages.no_telepon') }}</span>
                        <span class="font-medium text-ink text-right">{{ $checkout['telepon'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-ink/50 shrink-0">{{ __('messages.alamat_pengiriman') }}</span>
                        <span class="font-medium text-ink text-right">{{ $checkout['alamat_lengkap'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-ink/50 shrink-0">{{ __('messages.tanggal_sewa') }}</span>
                        <span class="font-medium text-ink text-right">
                            @if (!empty($checkout['tanggal_sewa_mulai']) && !empty($checkout['tanggal_sewa_selesai']))
                                {{ \Carbon\Carbon::parse($checkout['tanggal_sewa_mulai'])->format('d/m/Y') }}
                                &ndash;
                                {{ \Carbon\Carbon::parse($checkout['tanggal_sewa_selesai'])->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-ink/50 shrink-0">{{ __('messages.metode_pembayaran_judul') }}</span>
                        <span class="font-medium text-ink text-right">{{ __('messages.cod_label') }}</span>
                    </div>
                </div>
            </div>

            <div class="p-5 flex items-center justify-between">
                <span class="text-sm text-ink/50">Status</span>
                <span class="text-sm font-semibold text-amber-600">{{ __('messages.menunggu_konfirmasi') }}</span>
            </div>
        </div>

        <div class="bg-brand-50/70 border border-brand-100 rounded-xl p-4 flex gap-3 mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <p class="text-xs sm:text-sm text-ink/60 leading-relaxed">
                {!! __('messages.catatan_cod') !!}
            </p>
        </div>

        <div class="space-y-3">
            <button type="button" id="btn-download"
                    class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3.5 rounded-xl text-sm sm:text-base transition-colors flex items-center justify-center gap-2">
                <svg id="icon-download" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" />
                </svg>
                <span id="btn-download-text">{{ __('messages.download_struk') }}</span>
            </button>

            <a href="{{ route('profile.settings', ['tab' => 'riwayat']) }}"
               class="block text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-xl py-3.5 hover:bg-brand-50 transition-colors">
                {{ __('messages.lihat_riwayat') }}
            </a>

            <a href="{{ route('katalog.index') }}"
               class="block text-center text-ink/50 text-sm py-2 hover:text-ink transition-colors">
                {{ __('messages.kembali_katalog') }}
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas-pro@1.5.11/dist/html2canvas-pro.min.js"></script>
    <script>
        (function () {
            const btn = document.getElementById('btn-download');
            const btnText = document.getElementById('btn-download-text');
            const strukArea = document.getElementById('struk-area');
            function resetButton() { btn.disabled = false; btnText.textContent = "{{ __('messages.download_struk') }}"; }
            btn.addEventListener('click', function () {
                btn.disabled = true;
                btnText.textContent = "{{ __('messages.menyiapkan') }}";
                try {
                    if (typeof html2canvas !== 'function') throw new Error('Library missing');
                    html2canvas(strukArea, { backgroundColor: '#ffffff', scale: 2, useCORS: true }).then(function (canvas) {
                        const link = document.createElement('a');
                        link.download = 'struk-pesanan-{{ str_pad($checkout["pesanan_id"], 6, "0", STR_PAD_LEFT) }}.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                        resetButton();
                    }).catch(function () { alert('Gagal membuat struk.'); resetButton(); });
                } catch (e) { alert('Gagal membuat struk.'); resetButton(); }
            });
        })();
    </script>
@endsection