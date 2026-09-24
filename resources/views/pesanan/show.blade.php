@extends('layouts.app')

@section('title', 'Detail Pesanan - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-3xl mx-auto px-4 sm:px-6 pb-24">
        <a href="{{ route('profile.settings', ['tab' => 'riwayat']) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 mb-6">
            <span aria-hidden="true">&larr;</span> Kembali ke Riwayat Pesanan
        </a>

        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-serif font-semibold text-brand-600">Detail Pesanan</h1>
                <p class="text-sm text-ink/50 mt-1">Pesanan #BTK{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full whitespace-nowrap {{ $pesanan->badgeClass() }}">
                {{ $pesanan->labelStatus() }}
            </span>
        </div>

        <div class="space-y-5">
            <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6 flex items-center gap-4">
                <img src="{{ $pesanan->gambar_produk ?: asset('images/Logo_butik.png') }}"
                     alt="{{ $pesanan->nama_produk }}"
                     class="w-24 h-24 rounded-xl object-cover shrink-0">
                <div class="min-w-0">
                    <h2 class="font-serif text-lg font-semibold text-ink truncate">{{ $pesanan->nama_produk }}</h2>
                    <p class="text-sm text-ink/50 mt-1">
                        {{ collect([$pesanan->size, $pesanan->color])->filter()->implode(' / ') ?: 'Detail ukuran belum tersedia' }}
                    </p>
                    <p class="text-base font-semibold text-brand-700 mt-2">
                        Rp{{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-lg font-semibold text-ink mb-4">Informasi Penyewaan</h2>
                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-ink/50">Tanggal pesan</dt>
                        <dd class="font-medium text-ink mt-1">{{ $pesanan->created_at->translatedFormat('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Periode sewa</dt>
                        <dd class="font-medium text-ink mt-1">
                            {{ optional($pesanan->tanggal_sewa_mulai)->translatedFormat('d M Y') ?: '-' }}
                            - {{ optional($pesanan->tanggal_sewa_selesai)->translatedFormat('d M Y') ?: '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Metode pembayaran</dt>
                        <dd class="font-medium text-ink mt-1">{{ $pesanan->metode_pembayaran === 'transfer' ? 'Transfer Bank' : 'COD (Bayar di Tempat)' }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Total pembayaran</dt>
                        <dd class="font-semibold text-brand-700 mt-1">Rp{{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-lg font-semibold text-ink mb-4">Alamat Pengiriman</h2>
                <p class="font-medium text-ink">{{ $pesanan->nama_penerima ?: '-' }}</p>
                <p class="text-sm text-ink/60 mt-1">{{ $pesanan->telepon ?: '-' }}</p>
                <p class="text-sm text-ink/70 mt-2 whitespace-pre-line">{{ $pesanan->alamat_lengkap ?: '-' }}</p>
            </div>

            @if ($pesanan->bukti_transfer)
                <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6">
                    <h2 class="font-serif text-lg font-semibold text-ink mb-4">Bukti Pembayaran</h2>
                    <img src="{{ asset('storage/' . $pesanan->bukti_transfer) }}" alt="Bukti pembayaran"
                         class="max-h-80 rounded-xl object-contain border border-brand-100">
                </div>
            @endif
        </div>
    </div>

@endsection
