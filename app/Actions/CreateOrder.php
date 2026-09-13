<?php

namespace App\Actions;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Support\Facades\DB;

use App\Jobs\SendOrderConfirmation;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateOrder
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function execute(array $data)
    {

        return DB::transaction(function () use ($data) {

            $customer = Customer::firstOrCreate(
                ['email' => $data['email']],
                ['customer_name' => $data['customer_name']]
            );

            $productArray = [];
            $subtotal = 0;
            $taxAmount = 0;
            foreach ($data['items'] as $index => $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    throw new NotFoundHttpException(
                        "Product with ID {$item['product_id']} not found."
                    );
                }

                $updated = Product::where('product_id', $item['product_id'])
                    ->where('product_stock_on_hand', '>=', $item['quantity'])
                    ->decrement('product_stock_on_hand', $item['quantity']);


                if ($updated === 0) {
                    throw ValidationException::withMessages([
                        "items.{$index}.quantity" =>
                        "Product with ID {$item['product_id']} does not have enough stock."
                    ]);
                }


                $productArray[] = $product;

                $subtotal += $product->product_price * $item['quantity'];

                $taxAmount += ($product->product_price * $item['quantity']) * ($product->product_tax_percent / 100);
            }

            $grandTotal = $subtotal + $taxAmount;

            $ordered_details = Order::create([
                'order_customer_id' => $customer->customer_id,
                'order_subtotal' => $subtotal,
                'order_tax' => $taxAmount,
                'order_grand_total' => $grandTotal,
            ]);
            $order_id = $ordered_details->order_id;

            OrderItem::insert(array_map(function ($item, $product) use ($order_id) {
                return [
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'order_quantity' => $item['quantity'],
                    'order_unit_price' => $product->product_price,
                    'order_tax_percentage' => $product->product_tax_percent,
                    'order_tax_amount' => ($product->product_price * $item['quantity']) * ($product->product_tax_percent / 100),
                    'order_line_total' => ($product->product_price * $item['quantity']) + (($product->product_price * $item['quantity']) * ($product->product_tax_percent / 100)),
                    'order_item_created_at' => now(),
                    'order_item_updated_at' => now(),
                ];
            }, $data['items'], $productArray));


            DB::afterCommit(function () use ($ordered_details) {
                SendOrderConfirmation::dispatch($ordered_details);
            });

            return $ordered_details;
        });
    }
}
