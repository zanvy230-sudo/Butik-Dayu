@extends('admin.layouts.app')

@section('title', 'Dashboard Admin - Butik Dayu')

@section('content')

    <h1 class="font-serif text-3xl font-semibold text-ink mb-1.5">Ringkasan Dashboard</h1>
    <p class="text-sm text-ink/50 mb-8">
        Selamat Datang Kembali, Admin Butik Dayu. Berikut Status produk anda hari ini.
    </p>

    {{-- ============ 4 KARTU STATISTIK ============ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <div class="bg-white border border-brand-100 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <span class="flex items-center gap-2 text-sm text-ink/60">
                    <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </span>
                    Total Produk
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-ink/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-brand-700">{{ $totalProduk }}</p>
        </div>

        <div class="bg-white border border-brand-100 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <span class="flex items-center gap-2 text-sm text-ink/60">
                    <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                    </span>
                    Produk disewa
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-ink/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-brand-700">{{ $produkDisewa }}</p>
        </div>

        <div class="bg-white border border-brand-100 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <span class="flex items-center gap-2 text-sm text-ink/60">
                    <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m-.75 9h9a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-9a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </span>
                    Pesanan Aktif
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-ink/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-brand-700">{{ $pesananAktif }}</p>
        </div>

        <div class="bg-white border border-brand-100 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <span class="flex items-center gap-2 text-sm text-ink/60">
                    <span class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    Total Pendapatan
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-ink/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>
            <p class="text-3xl font-bold text-brand-700">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- ============ GRAFIK PESANAN ============ --}}
    @php
        $nilaiGrafikMaks = max($totalPesanan, $pesananMenunggu, $pesananAktifGabungan, $pesananSelesai, 1);
        $grafikPesanan = [
            ['label' => 'Total', 'nilai' => $totalPesanan, 'warna' => 'bg-brand-600'],
            ['label' => 'Menunggu', 'nilai' => $pesananMenunggu, 'warna' => 'bg-amber-500'],
            ['label' => 'Aktif', 'nilai' => $pesananAktifGabungan, 'warna' => 'bg-blue-500'],
            ['label' => 'Selesai', 'nilai' => $pesananSelesai, 'warna' => 'bg-emerald-500'],
        ];
    @endphp

    <div class="bg-white border border-brand-100 rounded-2xl p-6 mb-8">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="font-serif text-lg font-semibold text-ink">Grafik Pesanan</h2>
                <p class="text-sm text-ink/50 mt-1">Perbandingan status pesanan produk dan layanan rias</p>
            </div>
            <a href="{{ route('admin.pesanan.index') }}" class="text-sm font-semibold text-brand-600 hover:underline">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 items-end min-h-64 border-b border-brand-100 px-2 pt-6">
            @foreach ($grafikPesanan as $bar)
                <div class="flex flex-col items-center justify-end h-56 gap-3">
                    <span class="text-sm font-bold text-ink">{{ $bar['nilai'] }}</span>
                    <div class="w-full max-w-20 h-40 flex items-end justify-center">
                        <div class="{{ $bar['warna'] }} w-full rounded-t-xl transition-all"
                             style="height: {{ max(($bar['nilai'] / $nilaiGrafikMaks) * 100, $bar['nilai'] > 0 ? 8 : 2) }}%;"
                             title="{{ $bar['label'] }}: {{ $bar['nilai'] }}"></div>
                    </div>
                    <span class="text-xs text-ink/60 text-center">{{ $bar['label'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-5 flex items-center justify-between gap-4">
            <div>
                <p class="text-xs text-ink/50">Pendapatan Selesai</p>
                <p class="text-lg font-bold text-emerald-700 mt-1">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="flex flex-wrap justify-end gap-x-4 gap-y-2 text-xs text-ink/60">
                @foreach ($grafikPesanan as $bar)
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-sm {{ $bar['warna'] }}"></span>
                        {{ $bar['label'] }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ============ PESANAN TERBARU ============ --}}
    <div class="bg-white border border-brand-100 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5">
            <h2 class="font-serif text-lg font-semibold text-ink">Pesanan Terbaru</h2>
            <a href="{{ \Illuminate\Support\Facades\Route::has('admin.pesanan.index') ? route('admin.pesanan.index') : '#' }}"
               class="text-sm font-semibold text-brand-600 hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-brand-50/60 text-left text-ink/60 text-xs uppercase tracking-wide">
                        <th class="px-6 py-3 font-semibold">Kode Pesanan</th>
                        <th class="px-6 py-3 font-semibold">Nama Pemesan</th>
                        <th class="px-6 py-3 font-semibold">Produk / Layanan</th>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Total</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse ($pesananTerbaru as $p)
                        <tr class="hover:bg-brand-50/30 transition-colors">
                            <td class="px-6 py-4 font-semibold text-ink">{{ $p->kode }}</td>
                            <td class="px-6 py-4 text-ink/80">{{ $p->nama_pemesan }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($p->gambar)
                                        <img src="{{ $p->gambar }}" alt="{{ $p->produk_layanan }}" class="w-9 h-9 rounded-lg object-cover shrink-0">
                                    @else
                                        <span class="w-9 h-9 rounded-lg bg-brand-50 flex items-center justify-center text-brand-500 shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                                            </svg>
                                        </span>
                                    @endif
                                    <span class="text-ink/80">{{ $p->produk_layanan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-ink/60">{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 font-semibold text-ink">Rp{{ number_format($p->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full {{ $p->status_badge }}">
                                    {{ $p->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-ink/40">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection