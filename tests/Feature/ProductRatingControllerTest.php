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
        $product = Product::all();
        logger()->info('product key' . json_encode($product));

        $data = [
            'score' => 1
        ];

        $response = $this->getJson("/api/products/{$product->getKey()}/rate", $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }
}
