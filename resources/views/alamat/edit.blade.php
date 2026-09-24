@extends('layouts.app')

@section('title', 'Ubah Alamat - Butik Dayu')

@section('content')

    @include('partials.navbar', ['active' => ''])

    <div class="pt-28 md:pt-32 max-w-xl mx-auto px-6 pb-20">
        <div class="mb-8">
            <a href="{{ route('profile.settings', ['tab' => 'alamat']) }}"
               class="inline-flex items-center gap-1.5 text-sm text-ink/50 hover:text-brand-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Pengaturan Akun
            </a>
            <h1 class="text-2xl md:text-3xl font-semibold text-brand-600 mb-1">Ubah Alamat</h1>
            <p class="text-sm text-ink/60">Perbarui detail alamat pengiriman Anda</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-white border border-brand-100 rounded-2xl p-8">
            <form method="POST" action="{{ route('alamat.update', $alamat) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="nama_penerima" class="block text-sm font-medium text-ink mb-2">Nama Penerima</label>
                    <input type="text" name="nama_penerima" id="nama_penerima"
                           value="{{ old('nama_penerima', $alamat->nama_penerima) }}"
                           class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>

                <div>
                    <label for="telepon" class="block text-sm font-medium text-ink mb-2">Nomor Telepon</label>
                    <input type="tel" name="telepon" id="telepon"
                           value="{{ old('telepon', $alamat->telepon) }}"
                           class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300">
                </div>

                <div>
                    <label for="alamat_lengkap" class="block text-sm font-medium text-ink mb-2">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3"
                              class="w-full rounded-lg border border-brand-100 px-4 py-3 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300 focus:border-brand-300 resize-none">{{ old('alamat_lengkap', $alamat->alamat_lengkap) }}</textarea>
                </div>

                <label class="flex items-center gap-2.5 text-sm text-ink/70 cursor-pointer">
                    <input type="checkbox" name="jadikan_utama" value="1"
                           {{ old('jadikan_utama', $alamat->is_utama) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-brand-500 focus:ring-brand-300">
                    Jadikan sebagai alamat utama
                </label>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('profile.settings', ['tab' => 'alamat']) }}"
                       class="flex-1 text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-lg py-3.5 hover:bg-brand-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg py-3.5 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
