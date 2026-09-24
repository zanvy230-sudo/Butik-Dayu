@extends('admin.layouts.app')

@section('title', 'Pelanggan dan Ulasan - Butik Dayu')

@section('content')
    <h1 class="font-serif text-3xl font-semibold text-ink mb-1.5">Pelanggan dan Ulasan</h1>
    <p class="text-sm text-ink/50 mb-8">Moderasi ulasan pelanggan sebelum ditampilkan di halaman beranda.</p>

    @if (session('status'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-brand-100 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-serif text-lg font-semibold text-ink">Ulasan Pelanggan</h2>
            <span class="text-xs text-ink/50">{{ $ulasanList->count() }} ulasan</span>
        </div>

        <div class="space-y-4">
            @forelse ($ulasanList as $ulasan)
                <article class="border border-brand-100 rounded-xl p-5">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h3 class="font-semibold text-ink">{{ $ulasan->nama }}</h3>
                                <span class="text-xs px-2.5 py-1 rounded-full
                                    {{ $ulasan->status === 'disetujui' ? 'bg-green-50 text-green-600' : ($ulasan->status === 'ditolak' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                    {{ ucfirst($ulasan->status) }}
                                </span>
                                @if ($ulasan->ditampilkan)
                                    <span class="text-xs px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">Tampil di Beranda</span>
                                @endif
                            </div>
                            <p class="text-xs text-ink/50 mb-3">
                                {{ $ulasan->labelPaket() }}
                                @if ($ulasan->tanggal_acara)
                                    &middot; {{ $ulasan->tanggal_acara->translatedFormat('d M Y') }}
                                @endif
                                &middot; {{ $ulasan->created_at->translatedFormat('d M Y, H:i') }}
                            </p>
                            <p class="text-sm text-ink/75 leading-relaxed">{{ $ulasan->ulasan }}</p>
                        </div>

                        <div class="flex flex-wrap lg:flex-col gap-2 shrink-0">
                            @if ($ulasan->status !== 'disetujui')
                                <form method="POST" action="{{ route('admin.pelanggan.ulasan.approve', $ulasan) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full text-xs font-semibold rounded-lg px-3 py-2 bg-green-600 text-white hover:bg-green-700 transition-colors">
                                        Setujui
                                    </button>
                                </form>
                            @endif

                            @if ($ulasan->status !== 'ditolak')
                                <form method="POST" action="{{ route('admin.pelanggan.ulasan.reject', $ulasan) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full text-xs font-semibold rounded-lg px-3 py-2 border border-red-200 text-red-600 hover:bg-red-50 transition-colors">
                                        Tolak
                                    </button>
                                </form>
                            @endif

                            @if ($ulasan->status === 'disetujui')
                                <form method="POST" action="{{ route('admin.pelanggan.ulasan.homepage', $ulasan) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full text-xs font-semibold rounded-lg px-3 py-2 border border-brand-200 text-brand-600 hover:bg-brand-50 transition-colors">
                                        {{ $ulasan->ditampilkan ? 'Sembunyikan' : 'Tampilkan di Beranda' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="py-10 text-center text-sm text-ink/40">Belum ada ulasan dari pelanggan.</p>
            @endforelse
        </div>
    </div>
@endsection
