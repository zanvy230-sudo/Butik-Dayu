<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RiwayatPesananTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_settings(): void
    {
        $response = $this->get('/pengaturan?tab=riwayat');
        $response->assertRedirect('/login');

        $responseRoute = $this->get('/pengaturan/riwayat');
        $responseRoute->assertRedirect('/login');
    }

    public function test_user_can_access_riwayat_pesanan_tab(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pengaturan?tab=riwayat');

        $response->assertStatus(200);
        $response->assertSee('Riwayat Pesanan');
        $response->assertSee('Lihat semua pesanan anda di Butik Dayu');
        $response->assertSee('Kode Pesanan #BTK1019');
        $response->assertSee('Kebaya Siger Sunda');
        $response->assertSee('Rp8.500.000');
        $response->assertSee('Pesanan dalam Perjalanan');
        $response->assertSee('Kode Pesanan #BTK1018');
        $response->assertSee('Payas Agung Royal');
        $response->assertSee('Rp10.500.000');
        $response->assertSee('Pesanan Selesai');
        $response->assertSee('Kode Pesanan #BTK1017');
        $response->assertSee('Minang Suntiang');
        $response->assertSee('Kode Pesanan #BTK1016');
        $response->assertSee('Baju Bodo Modern');
    }

    public function test_pengaturan_riwayat_route_redirects_to_tab(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/pengaturan/riwayat');
        $response->assertRedirect(route('profile.settings', ['tab' => 'riwayat']));
    }
}
