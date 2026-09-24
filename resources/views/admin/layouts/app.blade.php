<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Butik Dayu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F9F6F5] text-ink">

    <div class="flex min-h-screen">

        {{-- ============ SIDEBAR ============ --}}
        <aside class="w-64 shrink-0 bg-white border-r border-brand-100 flex flex-col sticky top-0 h-screen self-start">

            {{-- Logo --}}
            <div class="flex flex-col items-center text-center pt-8 pb-6 px-6 border-b border-brand-100">
                <img src="{{ asset('images/Logo_butik.png') }}" alt="Butik Dayu"
                     class="w-16 h-16 rounded-full object-cover mb-3">
                <p class="font-serif text-xl font-semibold text-brand-700 leading-tight">Butik Dayu</p>
                <p class="text-[10px] tracking-[0.15em] text-ink/40 font-semibold mt-1">LUXURY BRIDAL ADMIN</p>
            </div>

            {{-- Menu --}}
            <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

                @php
                    $navIsActive = fn (string $routeName) => request()->routeIs($routeName);
                    $navLink = fn (string $routeName) => \Illuminate\Support\Facades\Route::has($routeName) ? route($routeName) : '#';
                @endphp

                <a href="{{ $navLink('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ $navIsActive('admin.dashboard') ? 'bg-brand-50 text-brand-700' : 'text-ink/60 hover:bg-brand-50/60 hover:text-ink' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ $navLink('admin.produk.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ $navIsActive('admin.produk.*') ? 'bg-brand-50 text-brand-700' : 'text-ink/60 hover:bg-brand-50/60 hover:text-ink' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    Produk
                </a>

                {{-- Pesanan (expandable) --}}
                <div x-data="{ open: true }">
                    <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.chev').classList.toggle('rotate-180')"
                            class="w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-ink/60 hover:bg-brand-50/60 hover:text-ink transition-colors">
                        <span class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m-.75 9h9a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25h-9a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            Pesanan
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="chev w-4 h-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="pl-11 pr-2 py-1 space-y-0.5">
                        <a href="{{ $navLink('admin.pesanan.index') }}"
                           class="block px-2.5 py-2 rounded-lg text-sm transition-colors
                                  {{ $navIsActive('admin.pesanan.index') ? 'text-brand-700 font-semibold' : 'text-ink/55 hover:text-ink' }}">
                            Semua Pesanan
                        </a>
                        <a href="{{ $navLink('admin.pesanan.produk') }}"
                           class="block px-2.5 py-2 rounded-lg text-sm transition-colors
                                  {{ $navIsActive('admin.pesanan.produk') ? 'text-brand-700 font-semibold' : 'text-ink/55 hover:text-ink' }}">
                            Pesanan Produk
                        </a>
                        <a href="{{ $navLink('admin.pesanan.rias') }}"
                           class="block px-2.5 py-2 rounded-lg text-sm transition-colors
                                  {{ $navIsActive('admin.pesanan.rias') ? 'text-brand-700 font-semibold' : 'text-ink/55 hover:text-ink' }}">
                            Pesanan MUA
                        </a>
                    </div>
                </div>

                <a href="{{ $navLink('admin.pembayaran.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ $navIsActive('admin.pembayaran.*') ? 'bg-brand-50 text-brand-700' : 'text-ink/60 hover:bg-brand-50/60 hover:text-ink' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                    Pembayaran
                </a>

                <a href="{{ $navLink('admin.pelanggan.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ $navIsActive('admin.pelanggan.*') ? 'bg-brand-50 text-brand-700' : 'text-ink/60 hover:bg-brand-50/60 hover:text-ink' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a3.375 3.375 0 116.75 0c0 1.864-1.51 3.375-3.375 3.375S8.625 11.614 8.625 9.75z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 19.125a5.25 5.25 0 0110.5 0M19.5 8.25v3m1.5-1.5h-3" />
                    </svg>
                    Review
                </a>

                <a href="{{ $navLink('admin.pengaturan.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ $navIsActive('admin.pengaturan.*') ? 'bg-brand-50 text-brand-700' : 'text-ink/60 hover:bg-brand-50/60 hover:text-ink' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a7.65 7.65 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan
                </a>
            </nav>

            {{-- Bawah: Help Center & Logout --}}
            <div class="px-4 py-5 border-t border-brand-100 space-y-1">
                <a href="{{ $navLink('admin.help') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-ink/60 hover:bg-brand-50/60 hover:text-ink transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zM12 17.25h.008v.008H12v-.008z" />
                    </svg>
                    Help Center
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-ink/60 hover:bg-red-50 hover:text-red-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ============ KONTEN ============ --}}
        <main class="flex-1 px-10 py-10 overflow-x-hidden">
            @yield('content')
        </main>

    </div>

    <div id="modal-konfirmasi" class="hidden fixed inset-0 z-50 bg-ink/50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <p id="modal-konfirmasi-pesan" class="text-sm text-ink/70 mb-6"></p>
            <div class="flex gap-3">
                <button type="button" data-tutup-konfirmasi class="flex-1 border border-brand-200 text-ink/70 text-sm font-semibold rounded-lg py-2.5 hover:bg-brand-50 transition-colors">Batal</button>
                <button type="button" data-lanjut-konfirmasi class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg py-2.5 transition-colors">Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('modal-konfirmasi');
            const pesan = document.getElementById('modal-konfirmasi-pesan');
            let formAktif = null;

            document.querySelectorAll('[data-confirm]').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.dataset.confirmed === 'true') return;
                    event.preventDefault();
                    formAktif = form;
                    pesan.textContent = form.dataset.confirm;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            function tutup() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                formAktif = null;
            }

            modal.querySelector('[data-tutup-konfirmasi]').addEventListener('click', tutup);
            modal.querySelector('[data-lanjut-konfirmasi]').addEventListener('click', function () {
                if (!formAktif) return;
                formAktif.dataset.confirmed = 'true';
                formAktif.submit();
            });
            modal.addEventListener('click', function (event) {
                if (event.target === modal) tutup();
            });
        })();
    </script>

</body>
</html>