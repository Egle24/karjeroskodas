<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    public function test_home(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_contacts(): void
    {
        $response = $this->get('/contacts');
        $response->assertStatus(200);
    }

    public function test_camps(): void
    {
        $response = $this->get('/camps');
        $response->assertStatus(200);
    }

    public function test_articles(): void
    {
        $response = $this->get('/articles');
        $response->assertStatus(200);
    }

    public function test_gallery(): void
    {
        $response = $this->get('/gallery');
        $response->assertStatus(200);
    }

    public function test_login(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_register_step_1(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_register_step_2(): void
    {
        $response = $this->get('/register-step2');
        $response->assertStatus(200);
    }

    public function test_admin_home(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_gallery(): void
    {
        $response = $this->get('/admin/gallery');
        $response->assertStatus(200);
    }

    public function test_admin_articles(): void
    {
        $response = $this->get('/admin/articles');
        $response->assertStatus(200);
    }

    public function test_admin_users(): void
    {
        $response = $this->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_admin_categories(): void
    {
        $response = $this->get('/admin/categories');
        $response->assertStatus(200);
    }

    public function test_admin_feedbacks(): void
    {
        $response = $this->get('/admin/feedbacks');
        $response->assertStatus(200);
    }

    public function test_admin_camps(): void
    {
        $response = $this->get('/admin/camps');
        $response->assertStatus(200);
    }

}
