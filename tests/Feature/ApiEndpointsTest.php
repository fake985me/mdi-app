<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user for authentication
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    /** @test */
    public function it_can_access_auth_protected_endpoints_with_valid_token()
    {
        $token = $this->user->createToken('test_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user',
            'profile'
        ]);
    }

    /** @test */
    public function it_can_create_and_get_categories()
    {
        $token = $this->user->createToken('test_token')->plainTextToken;

        $categoryData = [
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories',
            'slug' => 'electronics',
            'status' => true
        ];

        // Test creating a category
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/categories', $categoryData);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Category created successfully',
        ]);

        // Test getting all categories
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'slug',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_create_and_get_products()
    {
        $token = $this->user->createToken('test_token')->plainTextToken;

        // First create a category
        $category = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories',
            'slug' => 'electronics',
            'status' => true
        ]);

        $productData = [
            'name' => 'Smartphone',
            'description' => 'Latest model smartphone',
            'price' => 599.99,
            'stock' => 10,
            'sku' => 'SPH001',
            'category_id' => $category->id,
            'status' => true
        ];

        // Test creating a product
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/products', $productData);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Product created successfully',
        ]);

        // Test getting all products
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'stock',
                    'sku',
                    'category_id',
                    'category',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
}