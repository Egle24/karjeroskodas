<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $adminUser = User::role('admin')->first();
        $this->assertNotNull($adminUser, 'Administratoriaus duomenų bazėje nėra.');
        $this->actingAs($adminUser);
    }

    public function test_new_category_can_be_created()
    {
        $existingCategoryCount = Category::count();
        $newCategoryName = 'New Category';

        $response = $this->post(route('admin.categories.store'), ['title' => $newCategoryName]);

        $this->assertDatabaseCount('categories', $existingCategoryCount + 1);
        $response->assertRedirect(route('admin.categories.index'));
    }

    public function test_category_can_be_updated()
    {
        $category = Category::find(4);

        $updateData = ['title' => 'Seminarai'];

        $response = $this->put(route('admin.categories.update', $category->id), $updateData);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', $updateData);
    }

    public function test_category_can_be_deleted()
    {
        $category = Category::find(4);

        $response = $this->delete(route('admin.categories.destroy', $category->id));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['title' => 'Seminarai']);
    }

    public function test_same_category_cannot_be_created()
    {
        $existingCategoryCount = Category::count();
        $existingCategoryName = 'Projektai';

        $response = $this->post(route('admin.categories.store'), ['title' => $existingCategoryName]);

        $this->assertDatabaseCount('categories', $existingCategoryCount);
        $response->assertStatus(302);
    }
}
