<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produkLama = [
            'solo-basahan' => [
                'nama' => 'Solo Basahan - Velvet Heritage',
                'kategori_label' => 'Baju Adat Jawa',
                'daerah' => 'Jawa Tengah',
                'region' => 'jawa',
                'harga' => 12500000,
                'rating' => 5,
                'jumlah_ulasan' => 12,
                'deskripsi' => 'Koleksi busana pengantin klasik dengan bahan beludru premium dan sulaman payet emas tangan yang membutuhkan waktu 300 jam pengerjaan. Memberikan kesan agung dan elegan bagi setiap pengantin.',
                'catatan_pengerjaan' => 'Diproses secara manual oleh pengrajin ahli kami untuk menjamin kualitas warisan budaya yang tak lekang oleh waktu.',
                    'gambar_utama' => '/images/Logo_butik.png',
                'gambar_galeri' => [
                    'https://images.unsplash.com/photo-1650472185090-a8cfdd9a38d3?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.3&fp-y=0.6',
                    'https://images.unsplash.com/photo-1650472185090-a8cfdd9a38d3?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop',
                ],
                'stok_ukuran' => ['S (Anak)' => 2, 'M (Anak)' => 3, 'S' => 4, 'M' => 6, 'L' => 5, 'XL' => 2],
            ],
            'sunda-siger' => [
                'nama' => 'Sunda Siger White Elegance',
                'kategori_label' => 'Baju Adat Jawa Barat',
                'daerah' => 'Jawa Barat',
                'region' => 'sunda',
                'harga' => 8500000,
                'rating' => 5,
                'jumlah_ulasan' => 9,
                'deskripsi' => 'Balutan busana putih bernuansa lembut dengan siger emas khas Sunda, dipadukan renda halus untuk kesan anggun dan suci di hari pernikahan Anda.',
                'catatan_pengerjaan' => 'Setiap detail siger dan aksesoris dirangkai tangan oleh pengrajin lokal Jawa Barat.',
                    'gambar_utama' => '/images/Logo_butik.png',
                'gambar_galeri' => [
                    'https://images.unsplash.com/photo-1643213222456-ca6c9c6824c2?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.3',
                    'https://images.unsplash.com/photo-1643213222456-ca6c9c6824c2?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop',
                ],
                'stok_ukuran' => ['S (Anak)' => 1, 'M (Anak)' => 2, 'S' => 3, 'M' => 5, 'L' => 4, 'XL' => 0],
            ],
            'payas-agung' => [
                'nama' => 'Payas Agung Royal Gold',
                'kategori_label' => 'Baju Adat Bali',
                'daerah' => 'Bali',
                'region' => 'bali',
                'harga' => 10200000,
                'rating' => 5,
                'jumlah_ulasan' => 15,
                'deskripsi' => 'Busana kebesaran khas Bali dengan mahkota emas berukir detail dan kain songket pilihan, menghadirkan kemegahan prosesi adat Bali yang sakral.',
                'catatan_pengerjaan' => 'Mahkota dan aksesoris diimpor langsung dari pengrajin Bali dan dirawat khusus setiap selesai penyewaan.',
                    'gambar_utama' => '/images/Logo_butik.png',
                'gambar_galeri' => [
                    'https://images.unsplash.com/photo-1650377509428-11e7fe8614a9?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2',
                    'https://images.unsplash.com/photo-1650377509428-11e7fe8614a9?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop',
                ],
                'stok_ukuran' => ['S (Anak)' => 0, 'M (Anak)' => 1, 'S' => 2, 'M' => 3, 'L' => 3, 'XL' => 1],
            ],
            'minang-suntiang' => [
                'nama' => 'Minang Suntiang Heritage',
                'kategori_label' => 'Baju Adat Sumatera',
                'daerah' => 'Sumatera Barat',
                'region' => 'sumatera',
                'harga' => 9800000,
                'rating' => 5,
                'jumlah_ulasan' => 7,
                'deskripsi' => 'Suntiang megah bertingkat emas dipadukan busana merah marun bersulam benang emas, mencerminkan kebesaran adat Minangkabau.',
                'catatan_pengerjaan' => 'Suntiang dirakit ulang khusus sesuai ukuran kepala penyewa untuk kenyamanan maksimal seharian.',
                    'gambar_utama' => '/images/Logo_butik.png',
                'gambar_galeri' => [
                    'https://images.unsplash.com/photo-1756208978395-874a79e3094c?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2',
                    'https://images.unsplash.com/photo-1756208978395-874a79e3094c?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop',
                ],
                'stok_ukuran' => ['S (Anak)' => 2, 'M (Anak)' => 1, 'S' => 3, 'M' => 4, 'L' => 2, 'XL' => 3],
            ],
            'baju-bodo-modern' => [
                'nama' => 'Modern Baju Bodo Silk',
                'kategori_label' => 'Baju Adat Sulawesi',
                'daerah' => 'Sulawesi Selatan',
                'region' => 'sulawesi',
                'harga' => 7500000,
                'rating' => 4,
                'jumlah_ulasan' => 6,
                'deskripsi' => 'Baju Bodo klasik Bugis-Makassar dalam siluet modern berbahan sutra lembut, cocok untuk pengantin yang ingin tampil ringan namun tetap sarat makna adat.',
                'catatan_pengerjaan' => 'Dibuat dari sutra pilihan yang dijahit halus agar nyaman dipakai sepanjang acara.',
                    'gambar_utama' => '/images/Logo_butik.png',
                'gambar_galeri' => [
                    'https://images.unsplash.com/photo-1667353931393-7cf46f3d0649?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2',
                    'https://images.unsplash.com/photo-1667353931393-7cf46f3d0649?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop',
                ],
                'stok_ukuran' => ['S (Anak)' => 3, 'M (Anak)' => 2, 'S' => 5, 'M' => 6, 'L' => 4, 'XL' => 2],
            ],
            'dodotan-klasik' => [
                'nama' => 'Dodotan Klasik Couple',
                'kategori_label' => 'Baju Adat Jawa',
                'daerah' => 'Jawa Tengah / DIY',
                'region' => 'jawa',
                'harga' => 13500000,
                'rating' => 5,
                'jumlah_ulasan' => 10,
                'deskripsi' => 'Paket dodot klasik untuk pasangan pengantin, dengan motif batik tulis otentik dan tata rias pengantin Yogyakarta yang penuh filosofi.',
                'catatan_pengerjaan' => 'Termasuk sesi fitting bersama pasangan sebelum hari-H untuk memastikan ukuran dan kenyamanan.',
                    'gambar_utama' => '/images/Logo_butik.png',
                'gambar_galeri' => [
                    'https://images.unsplash.com/photo-1756209126861-4d240394a587?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop&crop=focalpoint&fp-x=0.5&fp-y=0.2',
                    'https://images.unsplash.com/photo-1756209126861-4d240394a587?fm=jpg&q=80&w=300&h=300&auto=format&fit=crop',
                ],
                'stok_ukuran' => ['S (Anak)' => 1, 'M (Anak)' => 1, 'S' => 2, 'M' => 4, 'L' => 3, 'XL' => 2],
            ],
        ];

        foreach ($produkLama as $slug => $data) {
            Produk::updateOrCreate(['slug' => $slug], $data);
        }
    }
}