<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

Route::post('/order', [OrderController::class, 'store']);

Route::get('/customer_list', [CustomerController::class, 'index']);

Route::get('/low_stock_products', [ProductController::class, 'lowStockProducts']);

Route::get('/order_history/{email}', [CustomerController::class, 'order_history']);

Route::get('/products_list', [ProductController::class, 'getAllProducts']);

