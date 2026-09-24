@extends('layouts.app')

@section('title', __('messages.ubah_sandi_judul') . ' - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-xl mx-auto px-6 pb-20">

        <div class="mb-8">
            <a href="{{ route('profile.settings', ['tab' => 'keamanan']) }}"
               class="inline-flex items-center gap-1.5 text-sm text-ink/50 hover:text-brand-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                {{ __('messages.kembali_ke_keamanan') }}
            </a>
            <h1 class="text-2xl md:text-3xl font-semibold text-brand-600 mb-1">{{ __('messages.ubah_sandi_heading') }}</h1>
            <p class="text-sm text-ink/60">{{ __('messages.ubah_sandi_sub') }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-white border border-brand-100 rounded-2xl p-8">
            <form method="POST" action="{{ route('keamanan.update-password') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-ink mb-2">{{ __('messages.sandi_saat_ini_label') }}</label>
                    <input type="password" name="current_password" id="current_password"
                           class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-ink mb-2">{{ __('messages.sandi_baru_label') }}</label>
                    <input type="password" name="password" id="password"
                           class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-ink mb-2">{{ __('messages.konfirmasi_sandi_label') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('profile.settings', ['tab' => 'keamanan']) }}"
                       class="flex-1 text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-lg py-3.5 hover:bg-brand-50 transition-colors">
                        {{ __('messages.batal_btn') }}
                    </a>
                    <button type="submit"
                            class="flex-1 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg py-3.5 transition-colors">
                        {{ __('messages.simpan_sandi_btn') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection