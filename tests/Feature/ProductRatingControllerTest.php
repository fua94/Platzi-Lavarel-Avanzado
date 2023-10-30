<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductRatingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            factory(User::class)->state('admin')->create()
        );
    }

    public function test_rate()
    {
        $product = factory(Product::class)->create();

        $data = [
            'score' => 1
        ];

        $response = $this->postJson("/api/products/{$product->getKey()}/rate", $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_approve()
    {
        $product = factory(Product::class)->create();

        $data = [
            'score' => 5
        ];

        $this->postJson("/api/products/{$product->getKey()}/rate", $data);

        $ratings = json_decode($this->getJson("/api/rating", [
            "approved" => true
        ])->getContent(), true);

        $response = $this->postJson("/api/rating/{$ratings["data"][0]["id"]}/approve");
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }
}
