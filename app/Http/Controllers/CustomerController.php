<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return response()->json($customers);
    }

    public function order_history(string $email)
    {

        if (!$email) {
            return response()->json([
                'message' => 'Email is required'
            ], 400);
        }

        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        $orders = Order::where(
            'order_customer_id',
            $customer->customer_id
        )->get();

        return response()->json($orders);
    }
}
