<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Product::create([
            'product_code' => 'P001',
            'product_name' => 'Laptop',
            'product_price' => 50000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 10,
            'product_threshold' => 2,
        ]);

        Product::create([
            'product_code' => 'P002',
            'product_name' => 'Keyboard',
            'product_price' => 1500,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 20,
            'product_threshold' => 5,
        ]);
        Product::create([
            'product_code' => 'P003',
            'product_name' => 'mouse',
            'product_price' => 1500,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 20,
            'product_threshold' => 5,
        ]);

        Product::create([
            'product_code' => 'P004',
            'product_name' => 'Webcam',
            'product_price' => 3000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 15,
            'product_threshold' => 4,
        ]);

        Product::create([
            'product_code' => 'P005',
            'product_name' => 'USB Cable',
            'product_price' => 500,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 30,
            'product_threshold' => 10,
        ]);

        Product::create([
            'product_code' => 'P006',
            'product_name' => 'USB Hub',
            'product_price' => 1200,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 20,
            'product_threshold' => 5,
        ]);


        Product::create([
            'product_code' => 'P007',
            'product_name' => 'Printer',
            'product_price' => 30000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 8,
            'product_threshold' => 2,
        ]);

        Product::create([
            'product_code' => 'P008',
            'product_name' => 'Scanner',
            'product_price' => 40000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 12,
            'product_threshold' => 3,
        ]);
        Product::create([
            'product_code' => 'P009',
            'product_name' => 'Tablet',
            'product_price' => 80000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 5,
            'product_threshold' => 1,
        ]);

        Product::create([
            'product_code' => 'P010',
            'product_name' => 'Speaker',
            'product_price' => 20000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 10,
            'product_threshold' => 4,
        ]);

        Product::create([
            'product_code' => 'P011',
            'product_name' => 'Charger',
            'product_price' => 5000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 20,
            'product_threshold' => 5,
        ]);

        Product::create([
            'product_code' => 'P012',
            'product_name' => 'Headphones',
            'product_price' => 15000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 15,
            'product_threshold' => 3,
        ]);

        Product::create([
            'product_code' => 'P013',
            'product_name' => 'Keyboard',
            'product_price' => 1500,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 20,
            'product_threshold' => 5,
        ]);

        Product::create([
            'product_code' => 'P014',
            'product_name' => 'Mouse',
            'product_price' => 1200,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 25,
            'product_threshold' => 6,
        ]);

        Product::create([
            'product_code' => 'P015',
            'product_name' => 'Monitor',
            'product_price' => 35000,
            'product_tax_percent' => 18,
            'product_stock_on_hand' => 10,
            'product_threshold' => 3,
        ]);
    }
}
