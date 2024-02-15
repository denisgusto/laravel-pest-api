<?php

use App\Models\Product;

test('user can get list of prodcts', function () {
    $product = Product::factory()->create();

    $this->get('/api/products')
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                ]
            ]
        ]);
})->only();
