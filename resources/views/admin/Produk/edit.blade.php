@extends('admin.layouts.app')

@section('title', 'Edit Produk - Butik Dayu')

@section('content')

    <h1 class="font-serif text-3xl font-semibold text-ink mb-1.5">Edit Produk Butik Dayu</h1>
    <p class="text-sm text-ink/50 mb-8">Perbarui Informasi Produk</p>

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $fotoLama = $produk->gambar_galeri ?: ($produk->gambar_utama ? [$produk->gambar_utama] : []);
    @endphp

    <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data" id="produk-form"
          class="bg-white border border-brand-100 rounded-2xl p-6">
        @csrf
        @method('PUT')

        <h2 class="font-serif text-lg font-semibold text-ink mb-6">Informasi Produk</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">

            {{-- Kolom kiri --}}
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}"
                           class="w-full rounded-lg border border-brand-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_label" class="w-full rounded-lg border border-brand-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-300">
                        <option value="">Pilih Kategori</option>
                        @foreach (['Baju Adat Jawa', 'Baju Adat Jawa Barat', 'Baju Adat Bali', 'Baju Adat Sumatera', 'Baju Adat Sulawesi'] as $opt)
                            <option value="{{ $opt }}" {{ old('kategori_label', $produk->kategori_label) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Harga Sewa <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}"
                           class="w-full rounded-lg border border-brand-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Daerah</label>
                    <input type="text" name="daerah" value="{{ old('daerah', $produk->daerah) }}"
                           class="w-full rounded-lg border border-brand-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full rounded-lg border border-brand-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-300">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

            </div>

            {{-- Kolom kanan: foto --}}
            <div>
                <label class="block text-sm font-medium text-ink mb-2">Foto Produk Saat Ini</label>

                @if (count($fotoLama))
                    <div class="grid grid-cols-3 gap-3 mb-2">
                        @foreach ($fotoLama as $foto)
                            <label class="relative rounded-lg overflow-hidden h-24 border border-brand-100 cursor-pointer group">
                                <img src="{{ $foto }}" class="w-full h-full object-cover">
                                <input type="checkbox" name="foto_dihapus[]" value="{{ $foto }}" class="peer absolute top-1.5 right-1.5 w-4 h-4 accent-red-500">
                                <div class="absolute inset-0 bg-red-500/70 opacity-0 peer-checked:opacity-100 flex items-center justify-center text-white text-xs font-semibold transition-opacity pointer-events-none">
                                    Akan Dihapus
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-ink/40 mb-5">Centang kotak di pojok foto untuk menghapusnya. Untuk crop ulang foto utama, upload ulang sebagai foto baru lalu hapus yang lama.</p>
                @else
                    <p class="text-xs text-ink/40 mb-5">Belum ada foto untuk produk ini.</p>
                @endif

                <label class="block text-sm font-medium text-ink mb-2">Tambah Foto Baru</label>
                <p class="text-xs text-ink/40 mb-2">Bisa pilih lebih dari 1 foto sekaligus, atau satu-satu berkali-kali.</p>
                <label for="foto_produk"
                       class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-brand-200 rounded-xl py-8 cursor-pointer hover:bg-brand-50/40 transition-colors">
                    <span class="w-9 h-9 rounded-full bg-brand-600 text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l-3.75 3.75M12 9.75l3.75 3.75M3 17.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18v-.75" />
                        </svg>
                    </span>
                    <span id="foto-label" class="text-sm text-ink/50">Klik untuk menambah foto (bisa lebih dari 1)</span>
                </label>
                <input type="file" name="foto_produk[]" id="foto_produk" accept="image/*" multiple class="hidden">

                <p id="klik-hint" class="hidden text-xs text-brand-600 mt-2">
                    💡 Foto utama baru sudah otomatis dipotong persegi. Klik foto itu untuk mengatur ulang crop-nya.
                </p>

                <div id="preview-grid" class="grid grid-cols-3 gap-3 mt-3"></div>

                {{-- ============ EDITOR CROP FOTO UTAMA BARU (muncul kalau foto itu diklik) ============ --}}
                <div id="crop-stage-wrapper" class="hidden mt-5 pt-5 border-t border-brand-50">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-medium text-ink">Atur Crop Foto Utama Baru</p>
                        <button type="button" id="crop-selesai"
                                class="text-xs font-semibold text-brand-600 border border-brand-300 rounded-full px-3.5 py-1.5 hover:bg-brand-50 transition-colors">
                            Selesai
                        </button>
                    </div>
                    <p class="text-xs text-ink/40 mb-3">
                        Geser kotak untuk memindahkan, seret bulatan di pojok untuk mengubah ukuran.
                    </p>

                    <div id="crop-stage" class="relative overflow-hidden select-none" style="width: 300px;">
                        <img id="crop-image" src="" alt="Foto untuk di-crop" class="w-full h-auto block rounded-lg" draggable="false">
                        <div id="crop-box"
                             class="absolute border-2 border-white cursor-move"
                             style="left:0; top:0; width:100px; height:100px; box-shadow: 0 0 0 9999px rgba(0,0,0,0.45);">
                            <div id="crop-resize-handle"
                                 class="absolute -right-2.5 -bottom-2.5 w-5 h-5 rounded-full bg-brand-600 border-2 border-white cursor-nwse-resize"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Stok per Ukuran --}}
        <div class="mt-8 pt-6 border-t border-brand-50">
            <label class="block text-sm font-medium text-ink mb-3">Stok per Ukuran <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                @foreach ($ukuranTetap as $ukuran)
                    <div>
                        <label class="block text-xs text-ink/50 mb-1">{{ $ukuran }}</label>
                        <input type="number" name="stok_{{ \Illuminate\Support\Str::slug($ukuran) }}"
                               value="{{ old('stok_' . \Illuminate\Support\Str::slug($ukuran), $produk->stok_ukuran[$ukuran] ?? 0) }}" min="0"
                               class="w-full rounded-lg border border-brand-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-300">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('admin.produk.index') }}"
               class="text-center border border-brand-200 text-ink/70 text-sm font-semibold rounded-lg px-6 py-2.5 hover:bg-brand-50 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg px-6 py-2.5 transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>

    {{-- ============ LIGHTBOX PREVIEW FOTO ============ --}}
    <div id="lightbox-modal" class="hidden fixed inset-0 z-50 bg-ink/80 items-center justify-center p-6">
        <button type="button" id="lightbox-close" aria-label="Tutup"
                class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img id="lightbox-img" src="" alt="Pratinjau foto" class="max-w-full max-h-full rounded-xl shadow-2xl object-contain">
    </div>

    <script>
        (function () {
            const form = document.getElementById('produk-form');
            const input = document.getElementById('foto_produk');
            const label = document.getElementById('foto-label');
            const klikHint = document.getElementById('klik-hint');
            const grid = document.getElementById('preview-grid');
            const lightboxModal = document.getElementById('lightbox-modal');
            const lightboxImg = document.getElementById('lightbox-img');

            const cropWrapper = document.getElementById('crop-stage-wrapper');
            const cropImage = document.getElementById('crop-image');
            const cropBox = document.getElementById('crop-box');
            const cropHandle = document.getElementById('crop-resize-handle');
            const cropSelesaiBtn = document.getElementById('crop-selesai');

            let selectedFiles = [];
            let cropActive = false;

            let box = { x: 0, y: 0, size: 100 };
            let dragging = false, resizing = false;
            let dragOffset = { x: 0, y: 0 };

            function syncInputFiles() {
                const dt = new DataTransfer();
                selectedFiles.forEach(function (file) { dt.items.add(file); });
                input.files = dt.files;
            }

            function initCrop(dataUrl) {
                cropImage.src = dataUrl;
                cropActive = true;

                cropImage.onload = function () {
                    const w = cropImage.clientWidth;
                    const h = cropImage.clientHeight;
                    const size = Math.min(w, h);
                    box = { x: (w - size) / 2, y: (h - size) / 2, size: size };
                    applyBoxStyle();
                    updateThumbnailUtama();
                };
            }

            function applyBoxStyle() {
                cropBox.style.left = box.x + 'px';
                cropBox.style.top = box.y + 'px';
                cropBox.style.width = box.size + 'px';
                cropBox.style.height = box.size + 'px';
            }

            // Render hasil crop dan pakai langsung sebagai gambar thumbnail
            // "Utama Baru" di grid -- ini yang jadi pratinjau live-nya.
            function updateThumbnailUtama() {
                if (!cropActive || !cropImage.naturalWidth) return;

                const scale = cropImage.naturalWidth / cropImage.clientWidth;
                const canvas = document.createElement('canvas');
                const OUT = 400;
                canvas.width = OUT;
                canvas.height = OUT;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(
                    cropImage,
                    box.x * scale, box.y * scale, box.size * scale, box.size * scale,
                    0, 0, OUT, OUT
                );

                const thumb = document.getElementById('grid-thumb-utama');
                if (thumb) thumb.src = canvas.toDataURL('image/jpeg', 0.92);
            }

            cropBox.addEventListener('pointerdown', function (e) {
                if (e.target === cropHandle) return;
                dragging = true;
                dragOffset.x = e.clientX - box.x;
                dragOffset.y = e.clientY - box.y;
                e.preventDefault();
            });

            cropHandle.addEventListener('pointerdown', function (e) {
                resizing = true;
                e.stopPropagation();
                e.preventDefault();
            });

            document.addEventListener('pointermove', function (e) {
                if (!dragging && !resizing) return;

                const w = cropImage.clientWidth;
                const h = cropImage.clientHeight;

                if (dragging) {
                    let newX = e.clientX - dragOffset.x;
                    let newY = e.clientY - dragOffset.y;
                    newX = Math.max(0, Math.min(w - box.size, newX));
                    newY = Math.max(0, Math.min(h - box.size, newY));
                    box.x = newX;
                    box.y = newY;
                }

                if (resizing) {
                    const stageRect = cropImage.getBoundingClientRect();
                    let newSize = Math.max(e.clientX - stageRect.left - box.x, e.clientY - stageRect.top - box.y);
                    newSize = Math.max(40, newSize);
                    newSize = Math.min(newSize, w - box.x, h - box.y);
                    box.size = newSize;
                }

                applyBoxStyle();
                updateThumbnailUtama();
            });

            document.addEventListener('pointerup', function () {
                dragging = false;
                resizing = false;
            });

            cropSelesaiBtn.addEventListener('click', function () {
                cropWrapper.classList.add('hidden');
            });

            function renderPreview() {
                grid.innerHTML = '';

                selectedFiles.forEach(function (file, index) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'relative rounded-lg overflow-hidden h-24 border border-brand-100 group';

                        if (index === 0) {
                            wrapper.innerHTML = `
                                <button type="button" id="preview-crop-toggle" class="absolute inset-0 w-full h-full cursor-pointer" aria-label="Klik untuk atur crop">
                                    <img id="grid-thumb-utama" src="${e.target.result}" class="w-full h-full object-cover">
                                </button>
                                <span class="absolute bottom-1 left-1 bg-brand-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full pointer-events-none">Utama Baru</span>
                                <button type="button" class="preview-remove absolute top-1 right-1 w-5 h-5 rounded-full bg-black/60 text-white text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500" data-index="${index}" aria-label="Batalkan foto ini">
                                    &times;
                                </button>
                            `;
                            grid.appendChild(wrapper);
                            initCrop(e.target.result);
                        } else {
                            wrapper.innerHTML = `
                                <button type="button" class="preview-view absolute inset-0 w-full h-full cursor-zoom-in" data-src="${e.target.result}" aria-label="Lihat foto lebih besar">
                                    <img src="${e.target.result}" class="w-full h-full object-cover">
                                </button>
                                <button type="button" class="preview-remove absolute top-1 right-1 w-5 h-5 rounded-full bg-black/60 text-white text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-500" data-index="${index}" aria-label="Batalkan foto ini">
                                    &times;
                                </button>
                            `;
                            grid.appendChild(wrapper);
                        }
                    };
                    reader.readAsDataURL(file);
                });

                label.textContent = selectedFiles.length > 0
                    ? selectedFiles.length + ' foto baru dipilih'
                    : 'Klik untuk menambah foto (bisa lebih dari 1)';

                klikHint.classList.toggle('hidden', selectedFiles.length === 0);

                if (selectedFiles.length === 0) {
                    cropWrapper.classList.add('hidden');
                    cropActive = false;
                }
            }

            input.addEventListener('change', function () {
                Array.from(this.files).forEach(function (file) {
                    const sudahAda = selectedFiles.some(function (f) {
                        return f.name === file.name && f.size === file.size && f.lastModified === file.lastModified;
                    });
                    if (!sudahAda) selectedFiles.push(file);
                });

                syncInputFiles();
                renderPreview();
            });

            grid.addEventListener('click', function (e) {
                const removeBtn = e.target.closest('.preview-remove');
                if (removeBtn) {
                    const idx = parseInt(removeBtn.getAttribute('data-index'), 10);
                    selectedFiles.splice(idx, 1);
                    syncInputFiles();
                    renderPreview();
                    return;
                }

                const viewBtn = e.target.closest('.preview-view');
                if (viewBtn) {
                    openLightbox(viewBtn.getAttribute('data-src'));
                    return;
                }

                const cropToggleBtn = e.target.closest('#preview-crop-toggle');
                if (cropToggleBtn && cropActive) {
                    cropWrapper.classList.toggle('hidden');
                }
            });

            function openLightbox(src) {
                lightboxImg.src = src;
                lightboxModal.classList.remove('hidden');
                lightboxModal.classList.add('flex');
            }

            function closeLightbox() {
                lightboxModal.classList.add('hidden');
                lightboxModal.classList.remove('flex');
                lightboxImg.src = '';
            }

            document.getElementById('lightbox-close').addEventListener('click', closeLightbox);
            lightboxModal.addEventListener('click', function (e) {
                if (e.target === lightboxModal) closeLightbox();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeLightbox();
            });

            function dataURLtoFile(dataurl, filename) {
                const arr = dataurl.split(',');
                const mimeMatch = arr[0].match(/:(.*?);/);
                const mime = mimeMatch ? mimeMatch[1] : 'image/jpeg';
                const bstr = atob(arr[1]);
                let n = bstr.length;
                const u8arr = new Uint8Array(n);
                while (n--) u8arr[n] = bstr.charCodeAt(n);
                return new File([u8arr], filename, { type: mime });
            }

            form.addEventListener('submit', function () {
                if (!cropActive || !cropImage.naturalWidth || selectedFiles.length === 0) return;

                const scale = cropImage.naturalWidth / cropImage.clientWidth;
                const canvas = document.createElement('canvas');
                const OUT = 900;
                canvas.width = OUT;
                canvas.height = OUT;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(
                    cropImage,
                    box.x * scale, box.y * scale, box.size * scale, box.size * scale,
                    0, 0, OUT, OUT
                );

                const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
                const namaAsli = selectedFiles[0].name.replace(/\.[^.]+$/, '') + '.jpg';
                selectedFiles[0] = dataURLtoFile(dataUrl, namaAsli);
                syncInputFiles();
            });
        })();
    </script>

@endsection