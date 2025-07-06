<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticatedUserRoutesTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $existingUser = User::role('member')->first();
        $this->actingAs($existingUser);
    }

    public function test_authenticated_user_can_access_profile()
    {
        $response = $this->get('/profile');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_cannot_access_admin_routes()
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
            $response->assertStatus(403);
        }
    }
}
