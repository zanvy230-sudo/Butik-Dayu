@extends('admin.layouts.app')

@section('title', 'Daftar Produk - Butik Dayu')

@section('content')

    <div class="flex items-start justify-between mb-1.5">
        <div>
            <h1 class="font-serif text-3xl font-semibold text-ink mb-1.5">Daftar Produk Butik Dayu</h1>
            <p class="text-sm text-ink/50">Seluruh Produk Butik Dayu Terdaftar disini</p>
        </div>
        <a href="{{ route('admin.produk.create') }}"
           class="shrink-0 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg px-4 py-2.5 transition-colors">
            + Tambah Produk
        </a>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-brand-100 rounded-2xl overflow-hidden mt-6">

        {{-- Filter --}}
        <form method="GET" class="flex flex-col sm:flex-row gap-3 px-6 py-5">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari Produk"
                   class="flex-1 rounded-lg border border-brand-100 px-4 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300">

            <select name="kategori" onchange="this.form.submit()"
                    class="rounded-lg border border-brand-100 px-3 py-2.5 text-sm text-ink">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriList as $kategori)
                    <option value="{{ $kategori }}" {{ request('kategori') === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()"
                    class="rounded-lg border border-brand-100 px-3 py-2.5 text-sm text-ink">
                <option value="">Semua Status</option>
                <option value="Sedang Disewa" {{ request('status') === 'Sedang Disewa' ? 'selected' : '' }}>Sedang Disewa</option>
                <option value="Produk Tersedia" {{ request('status') === 'Produk Tersedia' ? 'selected' : '' }}>Produk Tersedia</option>
            </select>

            <button type="submit" class="hidden">Cari</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-brand-50/60 text-left text-ink/60 text-xs uppercase tracking-wide">
                        <th class="px-6 py-3 font-semibold">No</th>
                        <th class="px-6 py-3 font-semibold">Foto Produk</th>
                        <th class="px-6 py-3 font-semibold">Produk / Layanan</th>
                        <th class="px-6 py-3 font-semibold">Kategori</th>
                        <th class="px-6 py-3 font-semibold">Harga</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse ($produkList as $i => $p)
                        <tr class="hover:bg-brand-50/30 transition-colors">
                            <td class="px-6 py-4 text-ink/60">{{ $produkList->firstItem() + $i }}</td>
                            <td class="px-6 py-4">
                                <img src="{{ $p->gambar_utama }}" alt="{{ $p->nama }}" class="w-11 h-11 rounded-lg object-cover">
                            </td>
                            <td class="px-6 py-4 font-medium text-ink">{{ $p->nama }}</td>
                            <td class="px-6 py-4 text-ink/70">{{ $p->kategori_label }}</td>
                            <td class="px-6 py-4 text-ink/80">Rp{{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if ($p->status_sewa === 'Sedang Disewa')
                                    <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full bg-amber-50 text-amber-600">Sedang Disewa</span>
                                @else
                                    <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600">Produk Tersedia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.produk.edit', $p) }}" title="Edit produk"
                                       class="w-8 h-8 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center hover:bg-brand-100 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.produk.destroy', $p) }}" data-confirm="Hapus produk ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus produk"
                                                class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-ink/40">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-brand-50">
            <p class="text-sm text-ink/50">
                Menampilkan {{ $produkList->firstItem() ?? 0 }} - {{ $produkList->lastItem() ?? 0 }} Produk dari {{ $produkList->total() }} Produk
            </p>
            {{ $produkList->links() }}
        </div>
    </div>

@endsection