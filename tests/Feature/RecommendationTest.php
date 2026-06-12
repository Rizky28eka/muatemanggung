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
        $this->seed(\Database\Seeders\MuaSeeder::class);

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
        $this->seed(\Database\Seeders\MuaSeeder::class);

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
        $this->seed(\Database\Seeders\MuaSeeder::class);

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

    public function test_siraman_event_forces_adat_theme()
    {
        $this->seed(DatabaseSeeder::class);

        $siramanEvent = EventType::where('slug', 'siraman')->first();
        $modernTheme = \App\Models\Theme::where('slug', 'modern')->first();
        $district = District::first();

        $postData = [
            'event_type_id' => $siramanEvent->id,
            'theme_id' => $modernTheme->id,
            'district_id' => $district->id,
        ];

        $response = $this->post(route('recommendation.process'), $postData);
        $response->assertSessionHasErrors(['theme_id']);
    }

    public function test_vector_regenerates_when_package_is_modified()
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(\Database\Seeders\MuaSeeder::class);

        $mua = \App\Models\Mua::first();
        $this->assertNotNull($mua);

        $vectorRecord = $mua->vector;
        $timeBefore = $vectorRecord->updated_at;

        sleep(1);

        $package = $mua->packages()->first();
        $package->update(['price' => 9999999]);

        $vectorRecord->refresh();
        $timeAfter = $vectorRecord->updated_at;

        $this->assertNotEquals($timeBefore, $timeAfter);
    }

    public function test_admin_can_create_new_mua_account()
    {
        $this->seed(DatabaseSeeder::class);

        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin-creator@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $district = District::first();
        $eventType = EventType::first();
        $theme = \App\Models\Theme::first();
        $look = MakeupLook::first();

        $postData = [
            'name' => 'New MUA Studio',
            'email' => 'newmua@example.com',
            'password' => 'newpassword123',
            'description' => 'A great new MUA in Temanggung',
            'address' => 'Jl. Baru No. 12',
            'whatsapp_number' => '0899999999',
            'instagram_username' => 'newmua.studio',
            'is_home_service' => 1,
            'service_radius_km' => 20,
            'district_id' => $district->id,
            'event_type_ids' => [$eventType->id],
            'theme_ids' => [$theme->id],
            'makeup_look_ids' => [$look->id],
            'service_district_ids' => [$district->id],
            'is_active' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('admin.mua.store'), $postData);

        $response->assertRedirect(route('admin.mua.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('muas', [
            'name' => 'New MUA Studio',
            'whatsapp_number' => '0899999999',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'newmua@example.com',
            'role' => 'mua',
        ]);
    }
}
