@extends('admin.layouts.app')

@section('title', 'Pembayaran Pesanan - Butik Dayu')

@section('content')

    <h1 class="font-serif text-3xl font-semibold text-ink mb-1.5">Pembayaran Pesanan Butik Dayu</h1>
    <p class="text-sm text-ink/50 mb-8">Periksa dan Konfirmasi Pesanan dari Pelanggan</p>

    @if (session('status'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-brand-100 rounded-2xl p-6">

        <h2 class="font-serif text-lg font-semibold text-ink mb-4">Konfirmasi Pembayaran</h2>

        {{-- Tab filter --}}
        <div class="flex items-center gap-2 mb-5">
            <a href="{{ route('admin.pembayaran.index', ['tab' => 'menunggu']) }}"
               class="text-sm font-semibold px-4 py-2 rounded-full transition-colors
                      {{ $tab === 'menunggu' ? 'bg-brand-600 text-white' : 'border border-brand-200 text-ink/60 hover:bg-brand-50' }}">
                Menunggu Konfirmasi ({{ $jumlahMenunggu }})
            </a>
            <a href="{{ route('admin.pembayaran.index', ['tab' => 'semua']) }}"
               class="text-sm font-semibold px-4 py-2 rounded-full transition-colors
                      {{ $tab === 'semua' ? 'bg-brand-600 text-white' : 'border border-brand-200 text-ink/60 hover:bg-brand-50' }}">
                Semua Pembayaran
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-brand-50/60 text-left text-ink/60 text-xs uppercase tracking-wide">
                        <th class="px-6 py-3 font-semibold">Kode Pesanan</th>
                        <th class="px-6 py-3 font-semibold">Nama Pemesan</th>
                        <th class="px-6 py-3 font-semibold">Metode Pembayaran</th>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Total</th>
                        <th class="px-6 py-3 font-semibold">Bukti</th>
                        <th class="px-6 py-3 font-semibold">Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse ($pembayaranList as $p)
                        <tr class="hover:bg-brand-50/30 transition-colors">
                            <td class="px-6 py-4 font-semibold text-ink">#{{ $p->jenis_pembayaran === 'rias' ? 'RIAS' : 'BTK' }}{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 text-ink/80">{{ $p->nama_pemesan_display ?? '-' }}</td>
                            <td class="px-6 py-4 text-ink/70">{{ $p->metode_pembayaran === 'transfer' ? 'Transfer Bank' : 'Cash (COD)' }}</td>
                            <td class="px-6 py-4 text-ink/60">{{ $p->created_at->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 font-semibold text-ink">Rp{{ number_format($p->total_display, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if ($p->bukti_transfer)
                                    <button type="button"
                                            data-bukti-preview="{{ asset('storage/' . $p->bukti_transfer) }}"
                                            class="preview-bukti-btn w-9 h-9 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center hover:bg-brand-100 transition-colors"
                                            aria-label="Lihat bukti transfer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="w-9 h-9 rounded-full bg-gray-50 text-gray-300 flex items-center justify-center" title="Tidak ada bukti (COD)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                                        </svg>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if (in_array($p->status, ['menunggu_konfirmasi', 'menunggu_verifikasi'], true))
                                    <form method="POST" action="{{ $p->jenis_pembayaran === 'rias' ? route('admin.pembayaran.rias.confirm', $p) : route('admin.pembayaran.confirm', $p) }}"
                                        data-confirm="Konfirmasi pembayaran pesanan ini?">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-lg px-4 py-2 transition-colors whitespace-nowrap">
                                            Konfirmasi
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full {{ $p->badgeClass() }}">
                                        {{ $p->labelStatus() }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-ink/40">
                                @if ($tab === 'menunggu')
                                    Tidak ada pembayaran yang menunggu konfirmasi.
                                @else
                                    Belum ada data pembayaran.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-brand-50">
            <p class="text-sm text-ink/50">
                Menampilkan {{ $pembayaranList->firstItem() ?? 0 }} - {{ $pembayaranList->lastItem() ?? 0 }} Pembayaran dari {{ $pembayaranList->total() }} Pembayaran
            </p>
            {{ $pembayaranList->links() }}
        </div>
    </div>

    <div id="bukti-modal" class="hidden fixed inset-0 z-50 bg-black/70 items-center justify-center p-4">
        <div class="relative w-full max-w-4xl">
            <button type="button" id="bukti-modal-close"
                    class="absolute -top-3 -right-3 z-10 w-9 h-9 rounded-full bg-white text-ink shadow-lg flex items-center justify-center hover:bg-brand-50 transition-colors"
                    aria-label="Tutup preview bukti">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="bukti-modal-image" src="" alt="Bukti pembayaran" class="w-full max-h-[80vh] object-contain rounded-2xl bg-white p-3 shadow-2xl">
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('bukti-modal');
            const modalImage = document.getElementById('bukti-modal-image');
            const closeBtn = document.getElementById('bukti-modal-close');

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalImage.src = '';
            }

            document.querySelectorAll('.preview-bukti-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const src = button.getAttribute('data-bukti-preview');
                    if (!src) return;
                    modalImage.src = src;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            closeBtn.addEventListener('click', closeModal);

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        })();
    </script>

@endsection