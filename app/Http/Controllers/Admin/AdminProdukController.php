<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Support\ProdukData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProdukController extends Controller
{
    private const UKURAN_TETAP = ['S (Anak)', 'M (Anak)', 'S', 'M', 'L', 'XL'];

    /**
     * Pemetaan Kategori -> Region, dipakai supaya kolom "region" (yang
     * dipakai filter daerah di halaman Katalog) otomatis terisi tanpa
     * perlu field terpisah di form Tambah/Edit Produk.
     */
    private const KATEGORI_KE_REGION = [
        'Baju Adat Jawa'        => 'jawa',
        'Baju Adat Jawa Barat'  => 'sunda',
        'Baju Adat Bali'        => 'bali',
        'Baju Adat Sumatera'    => 'sumatera',
        'Baju Adat Sulawesi'    => 'sulawesi',
    ];

    public function index(Request $request)
    {
        // Gunakan sumber query yang sama dengan katalog user agar admin
        // tidak menampilkan produk yang tidak tersedia di halaman user.
        $query = ProdukData::query();

        if ($cari = $request->query('cari')) {
            $query->where('nama', 'like', '%' . $cari . '%');
        }

        if ($kategori = $request->query('kategori')) {
            $query->where('kategori_label', $kategori);
        }

        $produkList = $query->orderBy('id')->get()->map(function (Produk $p) {
            $p->status_sewa = $p->statusSewa();
            return $p;
        });

        $statusFilter = $request->query('status');
        if ($statusFilter) {
            $produkList = $produkList->filter(fn ($p) => $p->status_sewa === $statusFilter)->values();
        }

        $perHalaman = 5;
        $halaman = (int) $request->query('page', 1);
        $items = $produkList->forPage($halaman, $perHalaman)->values();

        $produkPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $produkList->count(),
            $perHalaman,
            $halaman,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $kategoriList = ProdukData::query()
            ->select('kategori_label')
            ->distinct()
            ->orderBy('kategori_label')
            ->pluck('kategori_label');

        return view('admin.produk.index', [
            'produkList'    => $produkPaginated,
            'kategoriList'  => $kategoriList,
            'ukuranTetap'   => self::UKURAN_TETAP,
        ]);
    }

    public function create()
    {
        return view('admin.produk.create', [
            'ukuranTetap' => self::UKURAN_TETAP,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validasi($request, true);

        $validated['slug'] = $this->buatSlugUnik($validated['nama']);
        $validated['stok_ukuran'] = $this->parseStokUkuran($request);
        $validated['region'] = $this->tentukanRegion($validated['kategori_label']);

        // Upload semua foto yang dipilih. Foto pertama otomatis jadi
        // gambar_utama, semuanya (termasuk yang pertama) masuk ke gambar_galeri.
        $fotoPaths = [];
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                $fotoPaths[] = '/storage/' . $file->store('produk', 'public');
            }
        }

        $validated['gambar_utama'] = $fotoPaths[0] ?? null;
        $validated['gambar_galeri'] = $fotoPaths;

        unset($validated['foto_produk']);

        Produk::create($validated);

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', [
            'produk'      => $produk,
            'ukuranTetap' => self::UKURAN_TETAP,
        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $this->validasi($request, false);
        $validated['stok_ukuran'] = $this->parseStokUkuran($request);
        $validated['region'] = $this->tentukanRegion($validated['kategori_label']);

        // Foto lama dikurangi foto yang dicentang untuk dihapus
        $fotoLama = $produk->gambar_galeri ?: ($produk->gambar_utama ? [$produk->gambar_utama] : []);
        $dihapus = $request->input('foto_dihapus', []);
        $fotoTersisa = array_values(array_diff($fotoLama, $dihapus));

        // Hapus file fisiknya dari storage
        foreach ($dihapus as $path) {
            $relatif = str_replace('/storage/', '', $path);
            Storage::disk('public')->delete($relatif);
        }

        // Tambahkan foto baru yang diupload
        $fotoBaru = [];
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                $fotoBaru[] = '/storage/' . $file->store('produk', 'public');
            }
        }

        $semuaFoto = array_values(array_merge($fotoTersisa, $fotoBaru));

        $validated['gambar_galeri'] = $semuaFoto;
        $validated['gambar_utama'] = $semuaFoto[0] ?? $produk->gambar_utama;

        unset($validated['foto_produk']);

        $produk->update($validated);

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return back()->with('status', 'Produk berhasil dihapus.');
    }

    /**
     * $isCreate menentukan apakah foto_produk wajib diisi (create) atau
     * boleh dikosongkan alias tidak diganti (edit).
     */
private function validasi(Request $request, bool $isCreate): array
{
    $validated = $request->validate([
        'nama'                => ['required', 'string', 'max:255'],
        'kategori_label'      => ['required', 'string', 'max:255'],
        'daerah'              => ['nullable', 'string', 'max:255'],
        'harga'               => ['required', 'integer', 'min:0'],
        'rating'              => ['nullable', 'integer', 'min:1', 'max:5'],
        'jumlah_ulasan'       => ['nullable', 'integer', 'min:0'],
        'deskripsi'           => ['required', 'string'],
        'catatan_pengerjaan'  => ['nullable', 'string'],
        'foto_produk'         => [$isCreate ? 'required' : 'nullable', 'array', $isCreate ? 'min:1' : 'sometimes'],
        'foto_produk.*'       => ['image', 'max:2048'],
    ]);

    $validated['catatan_pengerjaan'] = $validated['catatan_pengerjaan'] ?? '';

    return $validated;
}
    /**
     * Tentukan slug region (dipakai filter daerah di Katalog) otomatis
     * dari Kategori yang dipilih admin. Kalau kategorinya tidak dikenali
     * (harusnya tidak mungkin karena pilihan di form sudah dibatasi),
     * fallback ke 'jawa' supaya kolom NOT NULL di database tetap terisi.
     */
    private function tentukanRegion(string $kategoriLabel): string
    {
        return self::KATEGORI_KE_REGION[$kategoriLabel] ?? 'jawa';
    }

    private function buatSlugUnik(string $nama): string
    {
        $slugDasar = Str::slug($nama);
        $slug = $slugDasar;
        $i = 1;

        while (Produk::where('slug', $slug)->exists()) {
            $slug = $slugDasar . '-' . $i++;
        }

        return $slug;
    }

    private function parseStokUkuran(Request $request): array
    {
        $hasil = [];

        foreach (self::UKURAN_TETAP as $ukuran) {
            $hasil[$ukuran] = (int) $request->input('stok_' . Str::slug($ukuran), 0);
        }

        return $hasil;
    }
}