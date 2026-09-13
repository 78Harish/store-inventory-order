<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_created(): void
    {
        $product = Product::create([
            'product_code' => 'P001',
            'product_name' => 'Laptop',
            'product_price' => 50000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 10,
            'product_threshold' => 2,
        ]);

        $response = $this->postJson('/api/order', [
            'customer_name' => 'John',
            'email' => 'john@example.com',
            'items' => [
                [
                    'product_id' => $product->product_id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertStatus(201);

        $customer = Customer::where('email', 'john@example.com')->first();

        $this->assertDatabaseHas('orders', [
            'order_customer_id' => $customer->customer_id,
            'order_subtotal' => 100000,
            'order_tax' => 18000,
            'order_grand_total' => 118000,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->product_id,
            'order_quantity' => 2,
        ]);

        $this->assertDatabaseHas('products', [
            'product_id' => $product->product_id,
            'product_stock_on_hand' => 8,
        ]);
    }

    public function test_order_fails_when_stock_is_insufficient(): void
    {
        $product = Product::create([
            'product_code' => 'P001',
            'product_name' => 'Laptop',
            'product_price' => 50000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 10,
            'product_threshold' => 2,
        ]);

        $response = $this->postJson('/api/order', [
            'customer_name' => 'John',
            'email' => 'john@example.com',
            'items' => [
                [
                    'product_id' => $product->product_id,
                    'quantity' => 11,
                ],
            ],
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'Product with ID ' . $product->product_id . ' does not have enough stock.',
            'errors' => [
                'items.0.quantity' => [
                    'Product with ID ' . $product->product_id . ' does not have enough stock.',
                ],
            ],
        ]);

        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseHas('products', [
            'product_id' => $product->product_id,
            'product_stock_on_hand' => 10,
        ]);
    }

    public function test_order_fails_when_product_not_found(): void
    {
        $response = $this->postJson('/api/order', [
            'customer_name' => 'John',
            'email' => 'john@example.com',
            'items' => [
                [
                    'product_id' => 10,
                    'quantity' => 1,
                ],
            ],
        ]);

        $response->assertStatus(404);

        $response->assertJson([
            'message' => 'Product with ID 10 not found.',
        ]);

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_customer_order_history(): void
    {
        $product = Product::create([
            'product_code' => 'P001',
            'product_name' => 'Laptop',
            'product_price' => 50000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 10,
            'product_threshold' => 2,
        ]);

        $response = $this->postJson('/api/order', [
            'customer_name' => 'John',
            'email' => 'john@example.com',
            'items' => [
                [
                    'product_id' => $product->product_id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertStatus(201);

        $response = $this->getJson('/api/order_history/john@example.com');

        $response->assertStatus(200);

        $response->assertJson([
            [
                'order_customer_id' => 1,
                'order_subtotal' => 100000,
                'order_tax' => 18000,
                'order_grand_total' => 118000,
            ],
        ]);
    }

    public function test_concurrent_orders_do_not_oversell_stock(): void
    {
        $product = Product::create([
            'product_code' => 'P001',
            'product_name' => 'Laptop',
            'product_price' => 50000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 1,
            'product_threshold' => 1,
        ]);

        $firstResponse = $this->postJson('/api/order', [
            'customer_name' => 'John',
            'email' => 'john@example.com',
            'items' => [
                [
                    'product_id' => $product->product_id,
                    'quantity' => 1,
                ],
            ],
        ]);

        $secondResponse = $this->postJson('/api/order', [
            'customer_name' => 'Jane',
            'email' => 'jane@example.com',
            'items' => [
                [
                    'product_id' => $product->product_id,
                    'quantity' => 1,
                ],
            ],
        ]);

        $firstResponse->assertStatus(201);
        $secondResponse->assertStatus(422);

        $this->assertDatabaseHas('products', [
            'product_id' => $product->product_id,
            'product_stock_on_hand' => 0,
        ]);

        $this->assertDatabaseCount('orders', 1);
    }


    public function test_low_stock_products(): void
    {
        $lowStockProduct = Product::create([
            'product_code' => 'P001',
            'product_name' => 'Laptop',
            'product_price' => 50000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 2,
            'product_threshold' => 2,
        ]);

        $normalStockProduct = Product::create([
            'product_code' => 'P002',
            'product_name' => 'Keyboard',
            'product_price' => 1500,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 10,
            'product_threshold' => 2,
        ]);

        $response = $this->getJson('/api/low_stock_products');

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'product_id' => $lowStockProduct->product_id,
            'product_name' => 'Laptop',
        ]);

        $response->assertJsonMissing([
            'product_id' => $normalStockProduct->product_id,
            'product_name' => 'Keyboard',
        ]);
    }
}
