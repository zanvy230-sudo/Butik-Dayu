@extends('layouts.app')

@section('title', __('messages.instruksi_pembayaran') . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-lg mx-auto px-4 sm:px-6 pb-24">

        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5m-15 10.5V10.5M3 21h18M3 10.5h18" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-serif font-semibold text-brand-600 mb-2">{{ __('messages.selesaikan_pembayaran') }}</h1>
            <p class="text-sm text-ink/60 max-w-md mx-auto leading-relaxed">
                {!! __('messages.transfer_instruksi_desc') !!}
            </p>
        </div>

        <div class="bg-white border border-brand-100 rounded-2xl divide-y divide-brand-100 mb-6">
            @foreach ($checkout['items'] as $item)
                <div class="p-5 flex items-center gap-4">
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}"
                         class="w-16 h-16 rounded-xl object-cover shrink-0">
                    <div class="min-w-0 flex-1">
                        <p class="font-serif font-semibold text-ink text-sm truncate">{{ $item['nama'] }}</p>
                        <p class="text-xs text-ink/50 mt-0.5">
                            Size: {{ $item['size'] }} &middot; Color: {{ $item['color'] }}
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
                        <span class="font-medium text-ink text-right">{{ __('messages.transfer_bank') }}</span>
                    </div>
                </div>
            </div>

            @foreach ($rekeningList as $rek)
                <div class="p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="h-9 px-3 flex items-center justify-center bg-brand-50 text-brand-600 rounded-lg text-sm font-bold shrink-0">
                            {{ $rek['bank'] }}
                        </span>
                        <div class="min-w-0">
                            <p class="font-mono font-semibold text-ink text-base tracking-wide" id="norek-{{ $loop->index }}">
                                {{ $rek['nomor'] }}
                            </p>
                            <p class="text-xs text-ink/50 mt-0.5">a.n. {{ $rek['atas_nama'] }}</p>
                        </div>
                    </div>
                    <button type="button" data-copy-target="norek-{{ $loop->index }}"
                            class="copy-btn shrink-0 text-xs font-semibold text-brand-600 border border-brand-200 rounded-lg px-3 py-2 hover:bg-brand-50 transition-colors">
                        {{ __('messages.salin_btn') }}
                    </button>
                </div>
            @endforeach
        </div>

        <div class="bg-white border border-brand-100 rounded-2xl p-5 mb-8">
            <p class="text-sm font-semibold text-ink mb-1">{{ __('messages.upload_bukti_transfer') }}</p>
            <p class="text-xs text-ink/50 mb-4">{{ __('messages.upload_bukti_desc') }}</p>

            <label for="bukti_transfer"
                   class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-brand-200 rounded-xl py-8 cursor-pointer hover:bg-brand-50/40 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                </svg>
                <span id="upload-label" class="text-sm text-brand-600 font-semibold">{{ __('messages.klik_pilih_file') }}</span>
                <span class="text-xs text-ink/40">{{ __('messages.atau_tarik_file') }}</span>
            </label>
        </div>

        @error('bukti_transfer')
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
                {{ $message }}
            </div>
        @enderror

        <div class="bg-brand-50/70 border border-brand-100 rounded-xl p-4 flex gap-3 mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <p class="text-xs sm:text-sm text-ink/60 leading-relaxed">
                {!! __('messages.catatan_transfer') !!}
            </p>
        </div>

        <form method="POST" action="{{ route('checkout.transfer.confirm') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" class="hidden">
            <button type="submit" id="submit-transfer-proof"
                    disabled
                    class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3.5 rounded-xl text-sm sm:text-base transition-colors disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:bg-brand-600">
                {{ __('messages.saya_sudah_transfer') }}
            </button>
            <a href="{{ route('katalog.index') }}"
               class="block text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-xl py-3.5 hover:bg-brand-50 transition-colors">
                {{ __('messages.kembali_katalog') }}
            </a>
        </form>

    </div>

    <script>
        (function () {
            document.querySelectorAll('.copy-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = btn.getAttribute('data-copy-target');
                    const text = document.getElementById(targetId).textContent.trim();
                    navigator.clipboard.writeText(text).then(function () {
                        const originalLabel = btn.textContent;
                        btn.textContent = "{{ __('messages.tersalin') }}";
                        setTimeout(function () { btn.textContent = originalLabel; }, 1500);
                    });
                });
            });

            const fileInput = document.getElementById('bukti_transfer');
            const uploadLabel = document.getElementById('upload-label');
            const submitBtn = document.getElementById('submit-transfer-proof');
            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    const hasFile = fileInput.files.length > 0;
                    if (submitBtn) {
                        submitBtn.disabled = !hasFile;
                    }
                    if (hasFile) {
                        uploadLabel.textContent = fileInput.files[0].name;
                    } else {
                        uploadLabel.textContent = "{{ __('messages.klik_pilih_file') }}";
                    }
                });
            }
        })();
    </script>
@endsection