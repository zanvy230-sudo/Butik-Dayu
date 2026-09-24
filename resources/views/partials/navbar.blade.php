{{-- 
    Navbar Butik Dayu.
--}}
@php
    $active = $active ?? 'beranda';
    $menu = [
        'beranda' => ['label' => __('messages.beranda'), 'route' => 'home'],
        'katalog' => ['label' => __('messages.katalog'), 'route' => 'katalog.index'],
        'layanan' => ['label' => __('messages.layanan_rias'), 'route' => 'layanan.index'],
        'tentang' => ['label' => __('messages.tentang_kami'), 'route' => 'tentang'],
    ];
    $notifikasiList = $notifikasiList ?? collect();
    $notifikasiUnreadCount = $notifikasiUnreadCount ?? 0;
@endphp

<header class="fixed inset-x-0 top-0 z-50 bg-white shadow-sm">
    <nav class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-10 py-4">
        
        {{-- Kiri: Tombol Hamburger (Mobile) & Logo --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Hamburger khusus HP --}}
            <button type="button" id="mobile-menu-button" aria-label="Menu" class="md:hidden text-ink/80 hover:text-brand-500 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                @if ($logoNavbar)
                    <img src="{{ asset('storage/' . $logoNavbar) }}" alt="Butik Dayu"
                         class="w-9 h-9 sm:w-10 sm:h-10 rounded-full object-cover">
                @endif
                <span class="font-serif text-base sm:text-lg font-semibold text-brand-600 italic">Butik Dayu</span>
            </a>
        </div>

        {{-- Menu tengah (Desktop) --}}
        <ul class="hidden md:flex items-center gap-9 text-sm">
            @foreach ($menu as $key => $item)
                <li>
                    <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                       class="{{ $active === $key ? 'text-brand-500 font-semibold' : 'text-ink/80 hover:text-brand-500' }} transition-colors">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Icon kanan (Keranjang, Notifikasi, Bahasa, Profil) --}}
        <div class="flex items-center gap-3 sm:gap-4 text-ink/85">
            
            {{-- Tombol Switch Bahasa (ID / EN) --}}
            <div class="flex items-center gap-1 text-xs font-semibold border border-brand-200 rounded-full px-2 py-1 bg-brand-50/50">
                <a href="{{ route('change.locale', 'id') }}" class="{{ app()->getLocale() === 'id' ? 'text-brand-600 underline' : 'text-ink/50 hover:text-ink' }}">ID</a>
                <span class="text-brand-200">/</span>
                <a href="{{ route('change.locale', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'text-brand-600 underline' : 'text-ink/50 hover:text-ink' }}">EN</a>
            </div>

            {{-- Keranjang --}}
            <a href="{{ Route::has('cart.index') ? route('cart.index') : '#' }}" aria-label="Keranjang" class="hover:text-brand-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.756-4.75 1.883-7.312a.75.75 0 00-.75-.813H6.108M7.5 14.25L5.106 5.272M7.5 14.25L5.25 5.25" />
                </svg>
            </a>

            {{-- Dropdown Notifikasi --}}
            <div class="relative">
                <button type="button" id="notif-menu-button" aria-label="Notifikasi" class="relative hover:text-brand-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <span id="notif-unread-dot" class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-brand-500 ring-2 ring-white {{ $notifikasiUnreadCount > 0 ? '' : 'hidden' }}"></span>
                </button>

                <div id="notif-menu-dropdown"
                     class="hidden absolute right-0 mt-4 w-[20rem] sm:w-[26rem] bg-white rounded-2xl shadow-card border border-brand-100 z-50">
                    <div class="absolute -top-2 right-4 w-4 h-4 bg-white border-t border-l border-brand-100 rotate-45"></div>
                    <div class="relative p-5 sm:p-6">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <h3 class="font-serif text-lg sm:text-xl font-semibold text-brand-700">Notification</h3>
                                <p id="notif-summary" class="text-xs text-ink/50 mt-0.5">
                                    @if ($notifikasiUnreadCount > 0)
                                        Kamu memiliki {{ $notifikasiUnreadCount }} notifikasi baru
                                    @else
                                        Tidak ada notifikasi baru
                                    @endif
                                </p>
                            </div>
                            <span class="shrink-0 text-xs font-semibold text-brand-600 border border-brand-300 rounded-full px-3 py-1.5 whitespace-nowrap">Semua</span>
                        </div>

                        <div class="flex gap-1 mb-4 border-b border-brand-100 pb-2">
                            <button type="button" data-notif-filter="all" class="notif-filter px-3 py-1.5 rounded-full text-xs font-semibold bg-brand-600 text-white">Semua</button>
                            <button type="button" data-notif-filter="unread" class="notif-filter px-3 py-1.5 rounded-full text-xs font-semibold text-ink/55 hover:bg-brand-50">Belum Dibaca</button>
                            <button type="button" data-notif-filter="read" class="notif-filter px-3 py-1.5 rounded-full text-xs font-semibold text-ink/55 hover:bg-brand-50">Sudah Dibaca</button>
                        </div>

                        @php
                            $iconPaths = [
                                'pesanan'    => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25a2 2 0 104 0M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375C2.754 3.75 2.25 4.254 2.25 4.875v1.5c0 .621.504 1.125 1.125 1.125z',
                                'koleksi'    => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
                                'promo'      => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z M6 6h.008v.008H6V6z',
                                'pengiriman' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v11.177m0-11.177L12.63 4.42a1.125 1.125 0 00-.888-.42H4.5a1.125 1.125 0 00-1.125 1.125v9.25m9.375 0H3.375',
                                'batal'      => 'M6 18L18 6M6 6l12 12',
                            ];
                        @endphp

                        <div id="notif-list" class="space-y-3 max-h-80 overflow-y-auto">
                            @forelse ($notifikasiList as $n)
                                <a href="{{ $n->url ?: '#' }}" data-notif-id="{{ $n->id }}" data-notif-read="{{ $n->dibaca_at ? 'true' : 'false' }}" class="flex items-start gap-3 rounded-xl border border-brand-100 p-3 hover:bg-brand-50/50 transition-colors {{ $n->dibaca_at ? 'bg-white' : 'bg-brand-50/40' }}">
                                    <span class="shrink-0 w-9 h-9 rounded-full bg-brand-100 text-brand-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$n->icon] ?? $iconPaths['pesanan'] }}" />
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-brand-700">{{ $n->judul }}</p>
                                        <p class="text-xs text-ink/55 mt-0.5 truncate">{{ $n->pesan }}</p>
                                    </div>
                                    <button type="button" data-hapus-notif="{{ $n->id }}" aria-label="Hapus notifikasi" class="ml-auto shrink-0 text-ink/30 hover:text-red-500">&times;</button>
                                </a>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-xs text-ink/40">Belum ada notifikasi.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Login / Profil / Menu Akun --}}
            @auth
                <div class="relative">
                    <button type="button" id="profile-menu-button"
                            class="flex items-center gap-2 pl-2 sm:border-l sm:border-brand-100 hover:text-brand-500">
                        <span class="w-7 h-7 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span class="hidden sm:block text-sm font-medium text-ink/80">
                            {{ explode(' ', auth()->user()->name)[0] }}
                        </span>
                    </button>

                    <div id="profile-menu-dropdown"
                         class="hidden absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-card border border-brand-100 py-2 z-50">
                        
                        {{-- Menu Utama untuk Tampilan HP (Digabung di sini) --}}
                        <div class="md:hidden px-2 pb-2 mb-1 border-b border-brand-100 space-y-1">
                            @foreach ($menu as $key => $item)
                                <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                                   class="block px-3 py-2 rounded-lg text-sm font-medium {{ $active === $key ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-ink/80 hover:bg-brand-50' }}">
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>

                        <a href="{{ Route::has('profile.settings') ? route('profile.settings') : '#' }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-brand-600 hover:bg-brand-50">
                            {{ __('messages.pengaturan') }}
                        </a>
                        <div class="my-1 border-t border-brand-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-red-500 hover:bg-red-50">
                                {{ __('messages.keluar') }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                {{-- Jika Belum Login, Tombol Hamburger HP menampilkan Menu + Masuk/Daftar --}}
                <div class="relative">
                    <div class="hidden sm:flex items-center gap-3 pl-2 border-l border-brand-100 text-sm">
                        <a href="{{ route('login') }}" class="text-ink/80 hover:text-brand-500">{{ __('messages.masuk') }}</a>
                        <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-700">{{ __('messages.daftar') }}</a>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    {{-- Dropdown Menu Khusus HP (Jika Belum Login atau panel terpisah) --}}
    @guest
        <div id="mobile-menu-dropdown" class="hidden md:hidden bg-white border-b border-brand-100 px-6 py-4 space-y-3">
            <div class="space-y-2 pb-3 border-b border-brand-100">
                @foreach ($menu as $key => $item)
                    <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                       class="block text-sm font-medium {{ $active === $key ? 'text-brand-600 font-semibold' : 'text-ink/80' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
            <div class="flex items-center gap-4 pt-1 text-sm">
                <a href="{{ route('login') }}" class="text-ink/80 hover:text-brand-500">{{ __('messages.masuk') }}</a>
                <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-700">{{ __('messages.daftar') }}</a>
            </div>
        </div>
    @endguest
    @auth
        <div id="mobile-menu-dropdown" class="hidden md:hidden bg-white border-b border-brand-100 px-6 py-4 space-y-2">
            @foreach ($menu as $key => $item)
                <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                   class="block text-sm font-medium {{ $active === $key ? 'text-brand-600 font-semibold' : 'text-ink/80' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    @endauth
</header>

{{-- Script Toggle Dropdown --}}
<script>
    (function () {
        // Toggle Mobile Menu
        const mobileBtn = document.getElementById('mobile-menu-button');
        const mobileDropdown = document.getElementById('mobile-menu-dropdown');
        if (mobileBtn && mobileDropdown) {
            mobileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                mobileDropdown.classList.toggle('hidden');
            });
        }

        // Toggle Profile Menu
        const profileBtn = document.getElementById('profile-menu-button');
        const profileDropdown = document.getElementById('profile-menu-dropdown');
        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });
        }

        // Toggle Notification Menu
        const notifBtn = document.getElementById('notif-menu-button');
        const notifDropdown = document.getElementById('notif-menu-dropdown');
        if (notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                notifDropdown.classList.toggle('hidden');
            });

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const notifList = document.getElementById('notif-list');
            const notifSummary = document.getElementById('notif-summary');
            const notifDot = document.getElementById('notif-unread-dot');
            const dataUrl = @json(route('notifikasi.data'));
            const readUrl = @json(route('notifikasi.read', ['notifikasi' => '__ID__']));
            const deleteUrl = @json(route('notifikasi.destroy', ['notifikasi' => '__ID__']));

            function updateUnreadCount(count) {
                notifDot?.classList.toggle('hidden', count < 1);
                if (notifSummary) notifSummary.textContent = count > 0 ? 'Kamu memiliki ' + count + ' notifikasi baru' : 'Tidak ada notifikasi baru';
            }

            function renderNotifications(notifications) {
                notifList.innerHTML = '';
                if (!notifications.length) {
                    const empty = document.createElement('div');
                    empty.className = 'text-center py-6';
                    empty.textContent = 'Belum ada notifikasi.';
                    notifList.appendChild(empty);
                    return;
                }
                notifications.forEach(function (notification) {
                    const item = document.createElement('a');
                    item.href = notification.url;
                    item.dataset.notifId = notification.id;
                    item.className = 'flex items-start gap-3 rounded-xl border border-brand-100 p-3 hover:bg-brand-50/50 transition-colors ' + (notification.dibaca ? 'bg-white' : 'bg-brand-50/40');
                    item.innerHTML = '<span class="shrink-0 w-9 h-9 rounded-full bg-brand-100 text-brand-500 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg></span><div class="min-w-0"><p class="text-xs font-semibold text-brand-700"></p><p class="text-xs text-ink/55 mt-0.5 truncate"></p></div><button type="button" aria-label="Hapus notifikasi" class="ml-auto shrink-0 text-ink/30 hover:text-red-500">&times;</button>';
                    item.querySelector('p').textContent = notification.judul;
                    item.querySelectorAll('p')[1].textContent = notification.pesan;
                    item.querySelector('button').addEventListener('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();
                        fetch(deleteUrl.replace('__ID__', notification.id), { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } }).then(function () { item.remove(); });
                    });
                    item.addEventListener('click', function () {
                        if (!notification.dibaca) fetch(readUrl.replace('__ID__', notification.id), { method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
                    });
                    notifList.appendChild(item);
                });
            }

            document.querySelectorAll('[data-notif-filter]').forEach(function (filterButton) {
                filterButton.addEventListener('click', function () {
                    document.querySelectorAll('[data-notif-filter]').forEach(function (button) { button.classList.remove('bg-brand-600', 'text-white'); button.classList.add('text-ink/55'); });
                    filterButton.classList.add('bg-brand-600', 'text-white');
                    filterButton.classList.remove('text-ink/55');
                    fetch(dataUrl + '?filter=' + filterButton.dataset.notifFilter, { headers: { 'Accept': 'application/json' } }).then(function (response) { return response.json(); }).then(function (data) { renderNotifications(data.notifications); updateUnreadCount(data.unread_count); });
                });
            });

            notifList?.querySelectorAll('[data-hapus-notif]').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    fetch(deleteUrl.replace('__ID__', button.dataset.hapusNotif), { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } }).then(function () { button.closest('[data-notif-id]')?.remove(); });
                });
            });

            notifList?.querySelectorAll('[data-notif-id]').forEach(function (item) {
                item.addEventListener('click', function () {
                    if (item.dataset.notifRead !== 'true') {
                        fetch(readUrl.replace('__ID__', item.dataset.notifId), { method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
                    }
                });
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            if (mobileDropdown && !mobileDropdown.contains(e.target) && mobileBtn && !mobileBtn.contains(e.target)) {
                mobileDropdown.classList.add('hidden');
            }
            if (profileDropdown && !profileDropdown.contains(e.target) && profileBtn && !profileBtn.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
            if (notifDropdown && !notifDropdown.contains(e.target) && notifBtn && !notifBtn.contains(e.target)) {
                notifDropdown.classList.add('hidden');
            }
        });
    })();
</script>