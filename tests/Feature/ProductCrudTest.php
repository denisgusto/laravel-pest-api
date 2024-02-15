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
});

test('guest user should not update a product', function () {
    $product = Product::factory()->create();

    $data = Product::factory()->raw();

    $this->putJson("/api/products/{$product->id}", $data)
        ->assertStatus(401);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $product->name,
    ]);
});

test('authenticated user can update a product', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $product = Product::factory()->create();

    $data = Product::factory()->raw();

    $this->putJson("/api/products/{$product->id}", $data)
        ->assertStatus(200);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $data['name'],
    ]);
});

test('guest user cannot delete a product', function () {
    $product = Product::factory()->create();

    $this->deleteJson("/api/products/{$product->id}")
        ->assertStatus(401);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $product->name,
    ]);
});

test('autheticated user can delete a product', function(){
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $product = Product::factory()->create();

    $this->deleteJson("/api/products/{$product->id}")
        ->assertStatus(200);

    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
        'name' => $product->name,
    ]);
});
