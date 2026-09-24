@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan - Butik Dayu')

@section('content')

    <h1 class="font-serif text-3xl font-semibold text-ink mb-1.5">Daftar Pesanan Butik Dayu</h1>
    <p class="text-sm text-ink/50 mb-8">Kelola Semua Pesanan Produk dan Layanan MUA</p>

    <div class="bg-white border border-brand-100 rounded-2xl p-6">

        <h2 class="font-serif text-lg font-semibold text-ink mb-4">Daftar Pesanan Pelanggan</h2>

        @if (session('status'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        {{-- Tab Semua / Produk / MUA -- masing-masing route/halaman terpisah --}}
        <div class="inline-flex bg-brand-50/60 rounded-full p-1 mb-5">
            <a href="{{ route('admin.pesanan.index') }}"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-colors {{ $jenisAktif === 'semua' ? 'bg-brand-600 text-white' : 'text-ink/60 hover:text-ink' }}">
                Semua
            </a>
            <a href="{{ route('admin.pesanan.produk') }}"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-colors {{ $jenisAktif === 'produk' ? 'bg-brand-600 text-white' : 'text-ink/60 hover:text-ink' }}">
                Produk
            </a>
            <a href="{{ route('admin.pesanan.rias') }}"
               class="px-5 py-2 rounded-full text-sm font-semibold transition-colors {{ $jenisAktif === 'mua' ? 'bg-brand-600 text-white' : 'text-ink/60 hover:text-ink' }}">
                MUA
            </a>
        </div>

        {{-- Pencarian --}}
        <form method="GET" class="mb-5">
            <div class="relative max-w-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-ink/30 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari Kode Pesanan / Nama Pemesan"
                       class="w-full rounded-lg border border-brand-100 pl-10 pr-4 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-300">
            </div>
        </form>

        <div class="overflow-x-auto border border-brand-50 rounded-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-brand-50/60 text-left text-ink/60">
                        <th class="px-6 py-3 font-semibold">Kode Pesanan</th>
                        <th class="px-6 py-3 font-semibold">Nama Pemesan</th>
                        <th class="px-6 py-3 font-semibold">Jenis Pesanan</th>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Total</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse ($pesananList as $item)
                        <tr class="hover:bg-brand-50/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-ink">#{{ $item['kode'] }}</td>
                            <td class="px-6 py-4 text-ink/80">{{ $item['nama_pemesan'] }}</td>
                            <td class="px-6 py-4 text-ink/70">{{ $item['jenis'] }}</td>
                            <td class="px-6 py-4 text-ink/70">{{ $item['tanggal']->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-ink/80">Rp{{ number_format($item['total'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full {{ $item['badge_status'] }}">
                                        {{ $item['label_status'] }}
                                    </span>
                                    @if ($item['jenis_raw'] === 'produk' && $item['status_raw'] === 'pembayaran_berhasil')
                                        <form method="POST" action="{{ route('admin.pesanan.update-status', $item['id']) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <input type="checkbox" onchange="this.form.submit()"
                                                   aria-label="Tandai pesanan selesai"
                                                   title="Tandai pesanan selesai"
                                                   class="w-4 h-4 accent-emerald-600 cursor-pointer">
                                        </form>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" class="form-hapus-pesanan"
                                      action="{{ $item['jenis_raw'] === 'produk'
                                                  ? route('admin.pesanan.destroy-produk', $item['id'])
                                                  : route('admin.pesanan.destroy-rias', $item['id']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" data-buka-modal-hapus data-kode="{{ $item['kode'] }}"
                                            class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-ink/40">
                                @if ($cari)
                                    Tidak ada pesanan yang cocok dengan pencarian "{{ $cari }}".
                                @else
                                    Belum ada pesanan.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">
            <p class="text-sm text-ink/50">
                Menampilkan {{ $pesananList->firstItem() ?? 0 }} - {{ $pesananList->lastItem() ?? 0 }} Pesanan dari {{ $pesananList->total() }} Pesanan
            </p>
            {{ $pesananList->onEachSide(1)->links() }}
        </div>
    </div>

    {{-- ============ MODAL KONFIRMASI HAPUS ============ --}}
    <div id="modal-hapus" class="hidden fixed inset-0 z-50 bg-ink/50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <h3 class="font-serif text-lg font-semibold text-ink mb-1.5">Yakin Batalkan Pesanan?</h3>
            <p id="modal-hapus-teks" class="text-sm text-ink/60 mb-6">
                Pesanan ini akan dihapus permanen dan tidak bisa dikembalikan.
            </p>
            <div class="flex gap-3">
                <button type="button" id="modal-hapus-batal"
                        class="flex-1 border border-brand-200 text-ink/70 text-sm font-semibold rounded-lg py-2.5 hover:bg-brand-50 transition-colors">
                    Batal
                </button>
                <button type="button" id="modal-hapus-konfirmasi"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg py-2.5 transition-colors">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('modal-hapus');
            const modalTeks = document.getElementById('modal-hapus-teks');
            const btnBatal = document.getElementById('modal-hapus-batal');
            const btnKonfirmasi = document.getElementById('modal-hapus-konfirmasi');
            let formAktif = null;

            document.querySelectorAll('[data-buka-modal-hapus]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    formAktif = btn.closest('form');
                    modalTeks.textContent = 'Pesanan #' + btn.getAttribute('data-kode') + ' akan dihapus permanen dan tidak bisa dikembalikan.';
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            function tutupModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                formAktif = null;
            }

            btnBatal.addEventListener('click', tutupModal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) tutupModal();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) tutupModal();
            });

            btnKonfirmasi.addEventListener('click', function () {
                if (formAktif) formAktif.submit();
            });
        })();
    </script>

@endsection