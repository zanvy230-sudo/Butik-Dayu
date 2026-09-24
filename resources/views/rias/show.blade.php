@extends('layouts.app')

@section('title', 'Detail Pesanan Rias - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => 'layanan'])

    <div class="pt-28 md:pt-32 max-w-3xl mx-auto px-4 sm:px-6 pb-24">
        <a href="{{ route('profile.settings', ['tab' => 'riwayat']) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 mb-6">
            <span aria-hidden="true">&larr;</span> Kembali ke Riwayat Pesanan
        </a>

        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-serif font-semibold text-brand-600">Detail Pesanan Rias</h1>
                <p class="text-sm text-ink/50 mt-1">Pesanan #RIAS{{ str_pad($pemesanan->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full whitespace-nowrap {{ $pemesanan->badgeClass() }}">
                {{ $pemesanan->labelStatus() }}
            </span>
        </div>

        <div class="space-y-5">
            <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6 flex items-center gap-4">
                <span class="w-24 h-24 rounded-xl bg-brand-50 text-brand-500 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                    </svg>
                </span>
                <div class="min-w-0">
                    <h2 class="font-serif text-lg font-semibold text-ink truncate">{{ $pemesanan->paket_nama }}</h2>
                    <p class="text-base font-semibold text-brand-700 mt-2">Rp{{ number_format($pemesanan->paket_harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-lg font-semibold text-ink mb-4">Informasi Acara</h2>
                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-ink/50">Tanggal pemesanan</dt>
                        <dd class="font-medium text-ink mt-1">{{ $pemesanan->created_at->translatedFormat('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Tanggal acara</dt>
                        <dd class="font-medium text-ink mt-1">{{ optional($pemesanan->tanggal_acara)->translatedFormat('d M Y') ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Jam acara</dt>
                        <dd class="font-medium text-ink mt-1">{{ $pemesanan->jam_acara ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Metode pembayaran</dt>
                        <dd class="font-medium text-ink mt-1">{{ $pemesanan->metode_pembayaran === 'transfer' ? 'Transfer Bank' : 'COD (Bayar di Tempat)' }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Total pembayaran</dt>
                        <dd class="font-semibold text-brand-700 mt-1">Rp{{ number_format($pemesanan->paket_harga, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6">
                <h2 class="font-serif text-lg font-semibold text-ink mb-4">Lokasi dan Kontak</h2>
                <p class="font-medium text-ink">{{ $pemesanan->nama_lengkap ?: '-' }}</p>
                <p class="text-sm text-ink/60 mt-1">{{ $pemesanan->telepon ?: '-' }}</p>
                <p class="text-sm text-ink/70 mt-2 whitespace-pre-line">{{ $pemesanan->alamat_acara ?: '-' }}</p>
            </div>

            @if ($pemesanan->catatan)
                <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6">
                    <h2 class="font-serif text-lg font-semibold text-ink mb-3">Catatan Tambahan</h2>
                    <p class="text-sm text-ink/70 whitespace-pre-line">{{ $pemesanan->catatan }}</p>
                </div>
            @endif

            @if ($pemesanan->bukti_transfer)
                <div class="bg-white border border-brand-100 rounded-2xl p-5 sm:p-6">
                    <h2 class="font-serif text-lg font-semibold text-ink mb-4">Bukti Pembayaran</h2>
                    <img src="{{ asset('storage/' . $pemesanan->bukti_transfer) }}" alt="Bukti pembayaran" class="max-h-80 rounded-xl object-contain border border-brand-100">
                </div>
            @endif
        </div>
    </div>

@endsection