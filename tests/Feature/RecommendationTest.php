<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\PriceRange;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationTest extends TestCase
{
    use RefreshDatabase;

    public function test_recommendation_flow_works_correctly()
    {
        $this->seed(DatabaseSeeder::class);

        // Fetch inputs from database to make sure they match seeds
        $eventType = EventType::first();
        $district = District::first();
        $look = MakeupLook::first();
        $priceRange = PriceRange::first();

        // 1. Visit recommendation form
        $response = $this->get(route('recommendation.form'));
        $response->assertStatus(200);

        // 2. Post preference form
        $postData = [
            'event_type_id' => $eventType->id,
            'makeup_look_id' => $look->id,
            'district_id' => $district->id,
            'price_range_id' => $priceRange->id,
            'wants_home_service' => 1,
        ];

        $response = $this->post(route('recommendation.process'), $postData);
        
        // Should redirect to results page
        $response->assertRedirect(route('guest.recommendation.results'));

        // Follow the redirect
        $response = $this->get(route('guest.recommendation.results'));
        $response->assertStatus(200);

        // Check if there are no errors in session
        $response->assertSessionHasNoErrors();
        
        // Assert we see some of the seeded MUAs or match labels
        $response->assertSee('Top 3 Rekomendasi MUA');
    }

    public function test_mua_detail_page_works_correctly()
    {
        $this->seed(DatabaseSeeder::class);

        $mua = \App\Models\Mua::where('is_active', true)->first();
        $this->assertNotNull($mua);

        $response = $this->get(route('mua.show', $mua->slug));
        $response->assertStatus(200);
        $response->assertSee($mua->name);
        $response->assertSee('Portofolio Riasan');
        $response->assertSee('Paket Layanan');
    }

    public function test_results_redirects_to_form_when_session_empty()
    {
        $response = $this->get(route('guest.recommendation.results'));
        
        $response->assertRedirect(route('recommendation.form'));
        $response->assertSessionHas('error');
    }

    public function test_login_page_renders_successfully()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertSee('Login Pengguna');
        $response->assertSee('Portal Akses');
    }

    public function test_mua_login_redirects_to_login()
    {
        $response = $this->get(route('mua.login'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_login_redirects_to_login()
    {
        $response = $this->get(route('admin.login'));
        $response->assertRedirect(route('login'));
    }

    public function test_mua_register_page_renders_successfully()
    {
        $this->seed(DatabaseSeeder::class);
        $response = $this->get(route('mua.register'));
        $response->assertStatus(200);
        $response->assertSee('Registrasi Pengelola MUA');
    }

    public function test_mua_registration_creates_pending_user_and_mua()
    {
        $this->seed(DatabaseSeeder::class);

        $district = \App\Models\District::first();

        $postData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'mua_name' => 'John Rias MUA',
            'district_id' => $district->id,
            'whatsapp_number' => '0812345678',
            'instagram_username' => 'john.rias',
        ];

        $response = $this->post(route('mua.register.process'), $postData);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        // Check if DB records exist
        $this->assertDatabaseHas('muas', [
            'name' => 'John Rias MUA',
            'whatsapp_number' => '0812345678',
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'mua',
            'is_active' => false,
        ]);
    }

    public function test_guests_are_redirected_to_login()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('mua.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_admin_dashboard_but_not_mua_dashboard()
    {
        $this->seed(DatabaseSeeder::class);

        $admin = \App\Models\User::create([
            'name' => 'Test Admin',
            'email' => 'admin-test@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get(route('mua.dashboard'));
        $response->assertStatus(403);
    }

    public function test_mua_user_can_access_mua_dashboard_but_not_admin_dashboard()
    {
        $this->seed(DatabaseSeeder::class);

        $mua = \App\Models\Mua::first();
        $muaUser = \App\Models\User::create([
            'name' => 'Test MUA User',
            'email' => 'mua-test@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'mua',
            'is_active' => true,
            'mua_id' => $mua->id,
        ]);

        $response = $this->actingAs($muaUser)->get(route('mua.dashboard'));
        $response->assertStatus(200);

        $response = $this->actingAs($muaUser)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }
}
