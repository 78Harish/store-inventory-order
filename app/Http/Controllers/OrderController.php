<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreOrderRequest;

use App\Actions\CreateOrder;



class OrderController extends Controller
{

    public function store(StoreOrderRequest $request, CreateOrder $createOrder)
    {
        $order = $createOrder->execute($request->validated());

        return response()->json($order, 201);
    }
}
