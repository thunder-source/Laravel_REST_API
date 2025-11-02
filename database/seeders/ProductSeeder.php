<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with USB receiver',
                'price' => 29.99,
                'quantity' => 100,
                'sku' => 'MOUSE-001',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical gaming keyboard',
                'price' => 89.99,
                'quantity' => 50,
                'sku' => 'KEY-001',
            ],
            [
                'name' => 'USB-C Cable',
                'description' => '2-meter USB-C charging cable',
                'price' => 12.99,
                'quantity' => 200,
                'sku' => 'CABLE-001',
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Adjustable aluminum laptop stand',
                'price' => 45.00,
                'quantity' => 75,
                'sku' => 'STAND-001',
            ],
            [
                'name' => 'Webcam HD',
                'description' => '1080p HD webcam with microphone',
                'price' => 59.99,
                'quantity' => 30,
                'sku' => 'CAM-001',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
