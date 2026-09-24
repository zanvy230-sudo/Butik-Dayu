<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_checkout(): void
    {
        $response = $this->get('/checkout/payas-agung');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_checkout_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/checkout/payas-agung');

        $response->assertStatus(200);
        $response->assertSee('Checkout Produk');
        $response->assertSee('Lengkapi data pengiriman dan pilih metode pembayaran untuk melanjutkan pesanan');

        // 1. Data Penyewa
        $response->assertSee('Data Penyewa');
        $response->assertSee('+ Tambah Data');

        // 2. Metode Pembayaran
        $response->assertSee('Metode Pembayaran');
        $response->assertSee('Transfer Bank');
        $response->assertSee('COD (Bayar di Tempat)');

        // 3. Ringkasan Pesanan
        $response->assertSee('Ringkasan Pesanan');
        $response->assertSee('Payas Agung Royal');
        $response->assertSee('Rp10.500.000');
        $response->assertSee('Rp25.000');
        $response->assertSee('Total Pembayaran');
        $response->assertSee('Rp10.525.000');
        $response->assertSee('Transaksi Anda 100% aman');
        $response->assertSee('Checkout Pesanan');
    }

    public function test_checkout_does_not_show_dummy_address_when_user_has_no_saved_address(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/checkout/payas-agung');

        $response->assertStatus(200);
        $response->assertSee('Belum ada alamat');
        $response->assertDontSee('Jl. Kebon Jeruk Raya');
        $response->assertDontSee('Jl. Anggrek Indah');
    }

    public function test_detail_produk_has_checkout_sekarang_link(): void
    {
        $response = $this->get('/katalog/payas-agung');

        $response->assertStatus(200);
        $response->assertSee('Checkout Sekarang');
        $response->assertSee(route('checkout.show', ['slug' => 'payas-agung']));
    }

    public function test_detail_produk_shows_size_options_and_stock(): void
    {
        $response = $this->get('/katalog/payas-agung');

        $response->assertStatus(200);
        $response->assertSee('Pilih Ukuran');
        $response->assertSee('S');
        $response->assertSee('M');
        $response->assertSee('L');
        $response->assertSee('XL');
        $response->assertSee('Stok');
    }

    public function test_user_can_select_multiple_products_from_cart(): void
    {
        $user = User::factory()->create();

        $this->withSession([
            'cart' => [
                'sunda-siger' => ['nama' => 'Kebaya Siger Sunda', 'gambar' => 'x', 'size' => 'M', 'color' => 'White', 'harga' => 8500000, 'qty' => 1],
                'payas-agung' => ['nama' => 'Payas Agung Royal', 'gambar' => 'x', 'size' => 'XL', 'color' => 'Gold', 'harga' => 10500000, 'qty' => 1],
            ],
        ]);

        $response = $this->actingAs($user)->post('/keranjang/checkout', [
            'produk' => ['sunda-siger', 'payas-agung'],
        ]);

        $response->assertRedirect(route('checkout.show', ['slug' => 'sunda-siger']));
        $response->assertSessionHas('checkout_selected_slugs');
    }

    public function test_user_can_submit_checkout_and_redirects_to_transfer_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/checkout', [
            'slug' => 'payas-agung',
            'metode_pembayaran' => 'transfer',
            'total_pembayaran' => 10525000,
            'tanggal_sewa_mulai' => now()->toDateString(),
            'tanggal_sewa_selesai' => now()->addDay()->toDateString(),
        ]);

        $response->assertRedirect(route('checkout.transfer'));
        $response->assertSessionHas('checkout_data');
    }
}
