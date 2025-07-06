<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticatedAdminRoutesTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $adminUser = User::role('admin')->first();
        $this->assertNotNull($adminUser, 'Administratoriaus duomenų bazėje nėra.');
        $this->actingAs($adminUser);
    }

    public function test_authenticated_admin_can_access_admin_routes()
    {
        $adminRoutes = [
            '/admin',
            '/admin/gallery',
            '/admin/articles',
            '/admin/users',
            '/admin/categories',
            '/admin/feedbacks',
            '/admin/camps',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_authenticated_admin_can_access_user_routes()
    {
        $userRoutes = [
            '/',
            '/gallery',
            '/articles',
            '/contacts',
            '/feedbacks',
            '/camps',
        ];

        foreach ($userRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

}
