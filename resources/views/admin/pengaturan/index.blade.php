@extends('admin.layouts.app')

@section('title', 'Pengaturan Website - Butik Dayu')

@section('content')
    <h1 class="font-serif text-3xl font-semibold text-ink mb-1.5">Pengaturan Website</h1>
    <p class="text-sm text-ink/50 mb-8">Atur informasi yang tampil di website Butik Dayu.</p>

    @if (session('status'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <section class="bg-white border border-brand-100 rounded-2xl p-6">
            <div class="border-t border-brand-100 mt-6 pt-6">
                <h3 class="font-semibold text-ink mb-4">Logo Website</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Logo Footer</label>
                        <div class="flex items-center gap-4">
                            <div class="relative w-20 h-20 rounded-xl border border-dashed border-brand-200 bg-brand-50/40 flex items-center justify-center overflow-hidden">
                                @if ($settings['logo_footer'])
                                    <img id="preview-logo-footer" src="{{ asset('storage/' . $settings['logo_footer']) }}" alt="Logo footer" class="max-w-full max-h-full object-contain">
                                @else
                                    <span id="preview-logo-footer" class="text-xs text-ink/40 text-center px-2">Belum ada logo</span>
                                @endif
                                <button type="submit" form="remove-logo-footer" class="absolute top-1 right-1 w-5 h-5 rounded-full bg-black/65 text-white text-xs leading-none hover:bg-red-600 transition-colors" aria-label="Hapus logo footer">&times;</button>
                            </div>
                            <div class="min-w-0">
                                <input type="file" name="logo_footer" accept="image/png,image/jpeg,image/webp" class="setting-input-file">
                                <button type="button" data-upload-key="logo_footer" data-upload-url="{{ route('admin.pengaturan.image.upload', 'logo_footer') }}" class="upload-image-btn bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-lg px-3 py-2 mt-2">Upload</button>
                                <p class="text-xs text-ink/45 mt-2">PNG/JPG/WEBP, maksimal 2MB.</p>
                                @if (!$settings['logo_footer'])
                                    <p class="text-xs text-ink/40 mt-2">Menggunakan logo dari folder website.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-2">Logo Navbar</label>
                        <div class="flex items-center gap-4">
                            <div class="relative w-20 h-20 rounded-xl border border-dashed border-brand-200 bg-brand-50/40 flex items-center justify-center overflow-hidden">
                                @if ($settings['logo_navbar'])
                                    <img id="preview-logo-navbar" src="{{ asset('storage/' . $settings['logo_navbar']) }}" alt="Logo navbar" class="max-w-full max-h-full object-contain">
                                @else
                                    <span id="preview-logo-navbar" class="text-xs text-ink/40 text-center px-2">Belum ada logo</span>
                                @endif
                                <button type="submit" form="remove-logo-navbar" class="absolute top-1 right-1 w-5 h-5 rounded-full bg-black/65 text-white text-xs leading-none hover:bg-red-600 transition-colors" aria-label="Hapus logo navbar">&times;</button>
                            </div>
                            <div class="min-w-0">
                                <input type="file" name="logo_navbar" accept="image/png,image/jpeg,image/webp" class="setting-input-file">
                                <button type="button" data-upload-key="logo_navbar" data-upload-url="{{ route('admin.pengaturan.image.upload', 'logo_navbar') }}" class="upload-image-btn bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-lg px-3 py-2 mt-2">Upload</button>
                                <p class="text-xs text-ink/45 mt-2">PNG transparan disarankan, maksimal 2MB.</p>
                                @if (!$settings['logo_navbar'])
                                    <p class="text-xs text-ink/40 mt-2">Menggunakan logo dari folder website.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white border border-brand-100 rounded-2xl p-6">
            <h2 class="font-serif text-lg font-semibold text-ink mb-1">Beranda</h2>
            <p class="text-xs text-ink/50 mb-5">Teks utama yang tampil pada hero halaman beranda.</p>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Banner Hero</label>
                    <div class="flex flex-col lg:flex-row gap-5 lg:items-center">
                        <div class="relative w-full lg:w-80 h-36 rounded-xl border border-dashed border-brand-200 bg-brand-50/40 overflow-hidden">
                            @if ($settings['hero_banner'])
                                <img id="preview-hero-banner" src="{{ asset('storage/' . $settings['hero_banner']) }}" alt="Banner hero" class="w-full h-full object-cover">
                            @else
                                <span id="preview-hero-banner" class="flex h-full items-center justify-center text-xs text-ink/40">Belum ada banner</span>
                            @endif
                            <button type="submit" form="remove-hero-banner" class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/65 text-white text-base leading-none hover:bg-red-600 transition-colors" aria-label="Hapus banner hero">&times;</button>
                        </div>
                        <div class="min-w-0">
                            <input type="file" name="hero_banner" accept="image/png,image/jpeg,image/webp" class="setting-input-file">
                            <button type="button" data-upload-key="hero_banner" data-upload-url="{{ route('admin.pengaturan.image.upload', 'hero_banner') }}" class="upload-image-btn bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-lg px-3 py-2 mt-2">Upload</button>
                            <p class="text-xs text-ink/45 mt-2">JPG/PNG/WEBP, maksimal 5MB. Gunakan gambar landscape.</p>
                            @if (!$settings['hero_banner'])
                                <p class="text-xs text-ink/40 mt-2">Menggunakan banner default website.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Judul hero</label>
                    <input name="hero_judul" value="{{ old('hero_judul', $settings['hero_judul']) }}" class="setting-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Deskripsi hero</label>
                    <textarea name="hero_deskripsi" rows="3" class="setting-input">{{ old('hero_deskripsi', $settings['hero_deskripsi']) }}</textarea>
                </div>
            </div>
        </section>

        <section class="bg-white border border-brand-100 rounded-2xl p-6">
            <h2 class="font-serif text-lg font-semibold text-ink mb-1">Kontak dan Lokasi</h2>
            <p class="text-xs text-ink/50 mb-5">Informasi yang dapat dihubungi pelanggan.</p>
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Nomor WhatsApp</label>
                    <input name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp']) }}" placeholder="+62 812-3456-7890" class="setting-input">
                    <p class="text-xs text-ink/45 mt-2">Sertakan kode negara, misalnya +62.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $settings['email']) }}" class="setting-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Username Instagram</label>
                    <input name="instagram_username" value="{{ old('instagram_username', $settings['instagram_username']) }}" placeholder="@butikdayu" class="setting-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram', $settings['instagram']) }}" placeholder="https://instagram.com/..." class="setting-input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Jam operasional</label>
                    <input name="jam_operasional" value="{{ old('jam_operasional', $settings['jam_operasional']) }}" class="setting-input">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-ink mb-2">Alamat toko</label>
                    <textarea name="alamat_toko" rows="3" class="setting-input">{{ old('alamat_toko', $settings['alamat_toko']) }}</textarea>
                </div>
            </div>
        </section>

        <section class="bg-white border border-brand-100 rounded-2xl p-6">
            <h2 class="font-serif text-lg font-semibold text-ink mb-1">Galeri Layanan Rias</h2>
            <p class="text-xs text-ink/50 mb-5">Upload foto portofolio yang akan tampil di halaman Layanan Rias.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @for ($slot = 1; $slot <= 8; $slot++)
                    @php $portfolioKey = 'portfolio_' . $slot; @endphp
                    <div class="min-w-0">
                        <label class="block text-sm font-medium text-ink mb-2">Foto {{ $slot }}</label>
                        <div data-file-picker="{{ $portfolioKey }}" class="relative aspect-square rounded-xl border border-dashed border-brand-200 bg-brand-50/40 flex items-center justify-center overflow-hidden cursor-pointer hover:border-brand-500 transition-colors">
                            @if ($settings[$portfolioKey])
                                <img id="preview-{{ str_replace('_', '-', $portfolioKey) }}" src="{{ asset('storage/' . $settings[$portfolioKey]) }}" alt="Foto portofolio {{ $slot }}" class="w-full h-full object-cover">
                            @else
                                <span id="preview-{{ str_replace('_', '-', $portfolioKey) }}" class="text-xs text-ink/40 text-center px-2">Belum ada foto</span>
                            @endif
                            <button type="submit" form="remove-{{ $portfolioKey }}" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-black/65 text-white text-sm leading-none hover:bg-red-600 transition-colors" aria-label="Hapus foto {{ $slot }}">&times;</button>
                        </div>
                        <input id="{{ $portfolioKey }}" type="file" name="{{ $portfolioKey }}" accept="image/png,image/jpeg,image/webp" class="hidden">
                        @if (!$settings[$portfolioKey])
                            <p class="text-xs text-ink/40 mt-2">Belum diupload.</p>
                        @endif
                    </div>
                @endfor
            </div>
        </section>

        <section class="bg-white border border-brand-100 rounded-2xl p-6">
            <h2 class="font-serif text-lg font-semibold text-ink mb-1">Kebijakan</h2>
            <p class="text-xs text-ink/50 mb-5">Catatan yang perlu diketahui pelanggan sebelum memesan.</p>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Kebijakan pembayaran</label>
                    <textarea name="kebijakan_pembayaran" rows="3" class="setting-input">{{ old('kebijakan_pembayaran', $settings['kebijakan_pembayaran']) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Kebijakan pemesanan</label>
                    <textarea name="kebijakan_pemesanan" rows="3" class="setting-input">{{ old('kebijakan_pemesanan', $settings['kebijakan_pemesanan']) }}</textarea>
                </div>
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg px-6 py-3 transition-colors">
                Simpan Pengaturan
            </button>
        </div>
    </form>

    @foreach ([
        'remove-logo-footer' => 'logo_footer',
        'remove-logo-navbar' => 'logo_navbar',
        'remove-hero-banner' => 'hero_banner',
    ] as $formId => $imageKey)
        <form id="{{ $formId }}" method="POST" action="{{ route('admin.pengaturan.image.remove', $imageKey) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    @for ($slot = 1; $slot <= 8; $slot++)
        @php $portfolioKey = 'portfolio_' . $slot; @endphp
        <form id="remove-{{ $portfolioKey }}" method="POST" action="{{ route('admin.pengaturan.image.remove', $portfolioKey) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endfor

    <style>
        .setting-input { width: 100%; border: 1px solid #eadde2; border-radius: .65rem; padding: .75rem 1rem; font-size: .875rem; color: #291d22; outline: none; }
        .setting-input:focus { border-color: #d783a4; box-shadow: 0 0 0 2px rgba(215, 131, 164, .2); }
    </style>
    <script>
        document.querySelectorAll('[data-file-picker]').forEach(function (previewContainer) {
            previewContainer.addEventListener('click', function (event) {
                if (!event.target.closest('button')) {
                    document.getElementById(previewContainer.dataset.filePicker).click();
                }
            });
        });

        document.querySelectorAll('input[type="file"][name]').forEach(function (input) {
            input.addEventListener('change', function () {
                const file = input.files[0];
                const preview = document.getElementById('preview-' + input.name.replace('_', '-'));
                if (file && preview) {
                    if (preview.tagName.toLowerCase() === 'img') {
                        preview.src = URL.createObjectURL(file);
                    } else {
                        const image = document.createElement('img');
                        image.id = preview.id;
                        image.alt = input.name;
                        image.className = 'max-w-full max-h-full object-contain';
                        image.src = URL.createObjectURL(file);
                        preview.replaceWith(image);
                    }
                }
            });
        });
    </script>
@endsection
