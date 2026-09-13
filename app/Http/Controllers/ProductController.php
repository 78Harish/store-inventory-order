<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{

    public function lowStockProducts()
    {
        $products = Product::whereColumn(
            'product_stock_on_hand',
            '<=',
            'product_threshold'
        )->get();

        return response()->json($products);
    }

    public function getAllProducts()
    {
        $products = Product::all();

        return response()->json($products);
    }
}
