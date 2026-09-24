@extends('layouts.app')

@section('title', __('messages.pengaturan_akun_judul') . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-6xl mx-auto px-6 lg:px-10 pb-20">

        {{-- ============ HEADER ============ --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-semibold text-brand-600 mb-2">{{ __('messages.pengaturan_akun_heading') }}</h1>
            <p class="text-ink/60">{{ __('messages.pengaturan_akun_sub') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] gap-8 items-start">

            {{-- ============ SIDEBAR TAB ============ --}}
            @php
                $tabs = [
                    'informasi' => [
                        'label' => __('messages.tab_informasi'),
                        'icon' =>
                            'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
                    ],
                    'alamat' => [
                        'label' => __('messages.tab_alamat'),
                        'icon' =>
                            'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z',
                    ],
                    'riwayat' => [
                        'label' => __('messages.tab_riwayat'),
                        'icon' =>
                            'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z',
                    ],
                    'keamanan' => [
                        'label' => __('messages.tab_keamanan'),
                        'icon' =>
                            'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                    ],
                ];
            @endphp

            <div class="bg-white border border-brand-100 rounded-2xl p-3">
                @foreach ($tabs as $key => $tab)
                    <button type="button" data-tab-target="{{ $key }}"
                        class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-left font-medium transition-colors mb-1
                               {{ $key === $activeTab ? 'bg-brand-50 text-brand-600' : 'text-ink/70 hover:bg-brand-50/60' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tab['icon'] }}" />
                        </svg>
                        {{ $tab['label'] }}
                    </button>
                @endforeach

                {{-- Keluar: langsung logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-left font-medium text-ink/70 hover:bg-red-50 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        {{ __('messages.keluar_btn') }}
                    </button>
                </form>
            </div>

            {{-- ============ KONTEN TAB ============ --}}
            <div class="bg-white border border-brand-100 rounded-2xl p-8">

                @if (session('status'))
                    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Panel: Informasi Akun --}}
                <div id="panel-informasi" class="tab-panel {{ $activeTab === 'informasi' ? '' : 'hidden' }}">
                    <h2 class="font-serif text-2xl font-semibold text-ink mb-1">{{ __('messages.informasi_akun_judul') }}</h2>
                    <p class="text-sm text-ink/50 mb-8">{{ __('messages.informasi_akun_sub') }}</p>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-medium text-ink mb-2">{{ __('messages.nama_lengkap_label') }}</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-ink mb-2">{{ __('messages.email_label') }}</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-ink mb-2">{{ __('messages.no_telepon_label') }}</label>
                            <input type="tel" name="phone" id="phone"
                                value="{{ old('phone', auth()->user()->phone) }}"
                                class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                        </div>

                        <div>
                            <p class="block text-sm font-medium text-ink mb-3">{{ __('messages.jenis_kelamin_label') }}</p>
                            <div class="flex items-center gap-8">
                                <label class="flex items-center gap-2 text-sm text-ink/70 cursor-pointer">
                                    <input type="radio" name="gender" value="perempuan"
                                        {{ old('gender', auth()->user()->gender) === 'perempuan' ? 'checked' : '' }}
                                        class="w-4 h-4 text-brand-500 focus:ring-brand-300">
                                    {{ __('messages.gender_perempuan') }}
                                </label>
                                <label class="flex items-center gap-2 text-sm text-ink/70 cursor-pointer">
                                    <input type="radio" name="gender" value="laki-laki"
                                        {{ old('gender', auth()->user()->gender) === 'laki-laki' ? 'checked' : '' }}
                                        class="w-4 h-4 text-brand-500 focus:ring-brand-300">
                                    {{ __('messages.gender_lakilaki') }}
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-full px-6 py-3 transition-colors">
                                {{ __('messages.simpan_perubahan_btn') }}
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Panel: Alamat --}}
                <div id="panel-alamat" class="tab-panel {{ $activeTab === 'alamat' ? '' : 'hidden' }}">
                    <h2 class="font-serif text-2xl font-semibold text-ink mb-1">{{ __('messages.alamat_pengiriman_judul') }}</h2>
                    <p class="text-sm text-ink/50 mb-8">{{ __('messages.alamat_pengiriman_sub') }}</p>

                    <div class="space-y-4 mb-6">
                        @forelse ($alamatList as $alamat)
                            <div class="border border-brand-100 rounded-xl p-5 flex items-start justify-between gap-4">
                                <div class="flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brand-500 shrink-0 mt-0.5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-ink">{{ $alamat->nama_penerima }}</p>
                                        <p class="text-sm text-ink/60 mb-1">{{ $alamat->telepon }}</p>
                                        <p class="text-sm text-ink/60 leading-relaxed max-w-md">
                                            {{ $alamat->alamat_lengkap }}</p>
                                    </div>
                                </div>

                                <div class="shrink-0 flex items-center gap-2">
                                    <a href="{{ route('alamat.edit', $alamat) }}"
                                       class="text-xs font-semibold text-brand-600 border border-brand-200 px-3 py-1.5 rounded-md hover:bg-brand-50 transition-colors whitespace-nowrap">
                                        Edit
                                    </a>
                                    @if ($alamat->is_utama)
                                        <span
                                            class="text-xs font-semibold text-brand-600 bg-brand-50 px-3 py-1.5 rounded-md whitespace-nowrap">
                                            {{ __('messages.alamat_utama_badge') }}
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('alamat.set-utama', $alamat) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-xs font-semibold text-brand-600 border border-brand-300 px-3 py-1.5 rounded-md hover:bg-brand-50 transition-colors whitespace-nowrap">
                                                {{ __('messages.jadikan_alamat_utama_btn') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-ink/50">{{ __('messages.belum_ada_alamat') }}</p>
                        @endforelse
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('alamat.create') }}"
                            class="inline-block bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg px-5 py-3 transition-colors">
                            {{ __('messages.tambah_alamat_btn') }}
                        </a>
                    </div>
                </div>

                {{-- Panel: Keamanan --}}
                <div id="panel-keamanan" class="tab-panel {{ $activeTab === 'keamanan' ? '' : 'hidden' }}">
                    <h2 class="font-serif text-2xl font-semibold text-ink mb-1">{{ __('messages.keamanan_akun_judul') }}</h2>
                    <p class="text-sm text-ink/50 mb-8">{{ __('messages.keamanan_akun_sub') }}</p>

                    <div class="space-y-4">
                        {{-- Ubah Kata Sandi --}}
                        <a href="{{ route('keamanan.edit-password') }}"
                            class="flex items-center justify-between gap-4 border border-brand-100 rounded-xl p-5 hover:bg-brand-50/40 transition-colors">
                            <div class="flex items-center gap-4">
                                <span
                                    class="w-10 h-10 rounded-full bg-brand-50 text-brand-500 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold text-ink text-sm">{{ __('messages.ubah_kata_sandi') }}</p>
                                    <p class="text-xs text-ink/50 mt-0.5">
                                        @if (auth()->user()->password_changed_at)
                                            {{ __('messages.terakhir_diubah') }}
                                            {{ auth()->user()->password_changed_at->translatedFormat('d F Y') }}
                                        @else
                                            {{ __('messages.belum_pernah_diubah') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-ink/30 shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>

                    </div>
                </div>

                {{-- Panel: Riwayat Pesanan --}}
                <div id="panel-riwayat" class="tab-panel {{ $activeTab === 'riwayat' ? '' : 'hidden' }}">
                    <h2 class="font-serif text-2xl font-semibold text-ink mb-1">{{ __('messages.riwayat_pesanan_judul') }}</h2>
                    <p class="text-sm text-ink/50 mb-6">{{ __('messages.riwayat_pesanan_sub') }}</p>

                    <div class="inline-flex bg-brand-50/60 rounded-full p-1 mb-6">
                        <button type="button" data-riwayat-target="sewa"
                            class="riwayat-cat-btn px-5 py-2 rounded-full text-sm font-semibold transition-colors bg-white text-brand-600 shadow-sm">
                            {{ __('messages.sub_sewa_baju') }}
                        </button>
                        <button type="button" data-riwayat-target="rias"
                            class="riwayat-cat-btn px-5 py-2 rounded-full text-sm font-semibold transition-colors text-ink/50 hover:text-ink">
                            {{ __('messages.sub_layanan_rias') }}
                        </button>
                    </div>

                    {{-- Kategori: Sewa Baju --}}
                    <div id="riwayat-cat-sewa" class="riwayat-cat-panel">
                        @if ($pesananList->isEmpty())
                            <div
                                class="rounded-lg border border-dashed border-brand-200 bg-brand-50/40 py-16 text-center text-sm text-ink/40">
                                {!! __('messages.kosong_sewa_baju', ['route' => route('katalog.index')]) !!}
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($pesananList as $pesanan)
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center gap-4 rounded-xl border border-brand-100 p-4 hover:border-brand-300 hover:bg-brand-50/20 transition-colors">
                                        <a href="{{ route('pesanan.show', $pesanan) }}"
                                            class="flex items-center gap-4 flex-1 min-w-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-300">
                                            <img src="{{ $pesanan->gambar_produk ?: asset('images/Logo_butik.png') }}"
                                                alt="{{ $pesanan->nama_produk }}"
                                                class="w-16 h-16 rounded-lg object-cover shrink-0">

                                            <span class="min-w-0">
                                                <span class="block text-[10px] uppercase tracking-[0.12em] text-ink/40 font-semibold">
                                                    Kode Pesanan #{{ $pesanan->kode }}
                                                </span>
                                                <span class="block font-serif text-base font-semibold text-ink truncate">
                                                    {{ $pesanan->nama_produk }}</span>
                                                <span class="block text-xs text-ink/50 mt-0.5">
                                                    {{ $pesanan->created_at->translatedFormat('d M Y, H:i') }}
                                                    @if ($pesanan->size || $pesanan->color)
                                                        &middot;
                                                        {{ collect([$pesanan->size, $pesanan->color])->filter()->implode(' / ') }}
                                                    @endif
                                                </span>
                                                <span class="block text-sm font-semibold text-brand-700 mt-1">
                                                    Rp{{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}</span>
                                            </span>
                                        </a>

                                        <div class="flex sm:flex-col items-end gap-2 shrink-0">
                                            <span
                                                class="text-xs font-semibold px-3 py-1.5 rounded-full whitespace-nowrap {{ $pesanan->badgeClass() }}">
                                                {{ $pesanan->labelStatus() }}
                                            </span>

                                            @if ($pesanan->status === 'menunggu_konfirmasi')
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('pesanan.edit', $pesanan) }}"
                                                        class="text-xs font-semibold text-brand-600 border border-brand-200 rounded-md px-3 py-1.5 hover:bg-brand-50 transition-colors whitespace-nowrap">
                                                        {{ __('messages.edit_btn') }}
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('pesanan.batalkan', $pesanan) }}"
                                                        data-confirm="{{ __('messages.konfirmasi_batalkan') }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="text-xs font-semibold text-red-500 border border-red-200 rounded-md px-3 py-1.5 hover:bg-red-50 transition-colors whitespace-nowrap">
                                                            {{ __('messages.batalkan_btn') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Kategori: Layanan Rias --}}
                    <div id="riwayat-cat-rias" class="riwayat-cat-panel hidden">
                        @if ($pemesananRiasList->isEmpty())
                            <div
                                class="rounded-lg border border-dashed border-brand-200 bg-brand-50/40 py-16 text-center text-sm text-ink/40">
                                {!! __('messages.kosong_layanan_rias', ['route' => route('layanan.index')]) !!}
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($pemesananRiasList as $pemesanan)
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center gap-4 rounded-xl border border-brand-100 p-4 hover:border-brand-300 hover:bg-brand-50/20 transition-colors">
                                        <a href="{{ route('rias.pemesanan.show', $pemesanan) }}"
                                           class="flex items-center gap-4 flex-1 min-w-0 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-300">
                                            <span
                                                class="w-16 h-16 rounded-lg bg-brand-50 text-brand-500 flex items-center justify-center shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                                            </svg>
                                            </span>

                                        <span class="min-w-0">
                                            <span class="block font-serif text-base font-semibold text-ink truncate">
                                                {{ $pemesanan->paket_nama }}</span>
                                            <span class="block text-xs text-ink/50 mt-0.5">
                                                {{ $pemesanan->tanggal_acara->translatedFormat('d M Y') }} &middot;
                                                {{ $pemesanan->jam_acara }}
                                            </span>
                                            <span class="block text-sm font-semibold text-brand-700 mt-1">
                                                Rp{{ number_format($pemesanan->paket_harga, 0, ',', '.') }}
                                            </span>
                                        </span>
                                        </a>

                                        <div class="shrink-0 sm:ml-auto self-start sm:self-center">
                                            <span
                                                class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full whitespace-nowrap {{ $pemesanan->badgeClass() }}">
                                                {{ $pemesanan->labelStatus() }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        (function() {
            const buttons = document.querySelectorAll('.tab-btn');
            const panels = document.querySelectorAll('.tab-panel');

            buttons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const target = btn.getAttribute('data-tab-target');

                    buttons.forEach(function(b) {
                        b.classList.remove('bg-brand-50', 'text-brand-600');
                        b.classList.add('text-ink/70');
                    });
                    btn.classList.add('bg-brand-50', 'text-brand-600');
                    btn.classList.remove('text-ink/70');

                    panels.forEach(function(panel) {
                        panel.classList.toggle('hidden', panel.id !== 'panel-' + target);
                    });
                });
            });
        })();

        (function() {
            const catButtons = document.querySelectorAll('.riwayat-cat-btn');
            const catPanels = document.querySelectorAll('.riwayat-cat-panel');

            catButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const target = btn.getAttribute('data-riwayat-target');

                    catButtons.forEach(function(b) {
                        b.classList.remove('bg-white', 'text-brand-600', 'shadow-sm');
                        b.classList.add('text-ink/50');
                    });
                    btn.classList.add('bg-white', 'text-brand-600', 'shadow-sm');
                    btn.classList.remove('text-ink/50');

                    catPanels.forEach(function(panel) {
                        panel.classList.toggle('hidden', panel.id !== 'riwayat-cat-' + target);
                    });
                });
            });
        })();
    </script>

@endsection