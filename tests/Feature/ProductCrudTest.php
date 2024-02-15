<?php

use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('user can get list of prodcts', function () {
    $product = Product::factory()->create();

    $this->getJson('/api/products')
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $product->id,
                    'name' => $product->name,
                ]
            ]
        ]);
});

test('user can get a product', function () {
    $product = Product::factory()->create();

    $this->getJson("/api/products/{$product->id}")
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
            ]
        ]);
});

test('guest user not allow to create a product', function () {
    $product = Product::factory()->raw();

    $this->postJson('/api/products', $product)
        ->assertStatus(401);

    $this->assertDatabaseCount('products', 0);
});

test('authenticated user can create a new product', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    
    $product = Product::factory()->raw();

    $this->postJson('/api/products', $product)
        ->assertStatus(201);

    $this->assertDatabaseCount('products', 1);
    $this->assertDatabaseHas('products', $product);
})->only();
