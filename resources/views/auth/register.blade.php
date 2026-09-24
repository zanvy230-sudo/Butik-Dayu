@extends('layouts.guest')

@section('title', 'Daftar Akun - Butik Dayu')

@section('content')

    <div class="w-full max-w-md bg-white rounded-2xl shadow-card px-8 py-10 sm:px-10">

        {{-- Logo --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/Logo_butik.png') }}" alt="Butik Dayu"
                 class="w-24 h-24 rounded-full object-cover shadow-inner">
        </div>

        {{-- Judul --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-brand-600 mb-1">Buat Akun</h1>
            <p class="text-sm text-ink/60">Bergabunglah untuk pengalaman bridal eksklusif</p>
        </div>

        {{-- Pesan error validasi, kalau ada --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ Route::has('register.store') ? route('register.store') : '#' }}" class="space-y-5">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="block text-xs font-semibold tracking-wide text-ink/70 mb-2">
                    NAMA LENGKAP
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-ink/40 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </span>
                    <input type="text" name="name" id="name" required autofocus
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama lengkap Anda"
                           class="w-full rounded-lg border border-brand-100 bg-brand-50/40 pl-11 pr-4 py-3 text-sm text-ink placeholder:text-ink/30 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-semibold tracking-wide text-ink/70 mb-2">
                    ALAMAT EMAIL
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-ink/40 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </span>
                    <input type="email" name="email" id="email" required
                           value="{{ old('email') }}"
                           placeholder="nama@contoh.com"
                           class="w-full rounded-lg border border-brand-100 bg-brand-50/40 pl-11 pr-4 py-3 text-sm text-ink placeholder:text-ink/30 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label for="phone" class="block text-xs font-semibold tracking-wide text-ink/70 mb-2">
                    NOMOR TELEPON
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-ink/40 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372a1.125 1.125 0 00-.852-1.09l-4.423-1.106a1.125 1.125 0 00-1.173.417l-.97 1.293a1.125 1.125 0 01-1.21.38 12.035 12.035 0 01-7.143-7.143 1.125 1.125 0 01.38-1.21l1.293-.97a1.125 1.125 0 00.417-1.173L6.963 3.102a1.125 1.125 0 00-1.09-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </span>
                    <input type="tel" name="phone" id="phone" required
                           value="{{ old('phone') }}"
                           placeholder="08xx xxxx xxxx"
                           class="w-full rounded-lg border border-brand-100 bg-brand-50/40 pl-11 pr-4 py-3 text-sm text-ink placeholder:text-ink/30 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>
            </div>

            {{-- Kata Sandi --}}
            <div>
                <label for="password" class="block text-xs font-semibold tracking-wide text-ink/70 mb-2">
                    KATA SANDI
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-ink/40 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </span>
                    <input type="password" name="password" id="password" required
                           placeholder="Buat kata sandi"
                           class="w-full rounded-lg border border-brand-100 bg-brand-50/40 pl-11 pr-11 py-3 text-sm text-ink placeholder:text-ink/30 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                    <button type="button" data-toggle-target="password" aria-label="Tampilkan kata sandi"
                            class="toggle-password absolute inset-y-0 right-3 flex items-center text-ink/40 hover:text-ink/60">
                        <svg class="icon-eye w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg class="icon-eye-off w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Kata Sandi --}}
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold tracking-wide text-ink/70 mb-2">
                    KONFIRMASI KATA SANDI
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-ink/40 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           placeholder="Ulangi kata sandi"
                           class="w-full rounded-lg border border-brand-100 bg-brand-50/40 pl-11 pr-11 py-3 text-sm text-ink placeholder:text-ink/30 focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                    <button type="button" data-toggle-target="password_confirmation" aria-label="Tampilkan konfirmasi kata sandi"
                            class="toggle-password absolute inset-y-0 right-3 flex items-center text-ink/40 hover:text-ink/60">
                        <svg class="icon-eye w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg class="icon-eye-off w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Tombol submit --}}
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold tracking-wide rounded-lg py-3.5 transition-colors">
                DAFTAR SEKARANG
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </form>

        {{-- Link login --}}
        <p class="text-center text-sm text-ink/60 mt-7">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:text-brand-700">
                Masuk di sini
            </a>
        </p>
    </div>

    <script>
        // Toggle tampil/sembunyi untuk SEMUA field password di halaman ini
        // (Kata Sandi & Konfirmasi Kata Sandi), masing-masing independen.
        (function () {
            document.querySelectorAll('.toggle-password').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = btn.getAttribute('data-toggle-target');
                    const input = document.getElementById(targetId);
                    const eye = btn.querySelector('.icon-eye');
                    const eyeOff = btn.querySelector('.icon-eye-off');
                    const isPassword = input.type === 'password';

                    input.type = isPassword ? 'text' : 'password';
                    eye.classList.toggle('hidden', isPassword);
                    eyeOff.classList.toggle('hidden', !isPassword);
                });
            });
        })();
    </script>

@endsection
