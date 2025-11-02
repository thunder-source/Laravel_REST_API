<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Product API',
        'version' => '1.0',
        'endpoints' => [
            'GET /api/products' => 'Get all products',
            'GET /api/products/{id}' => 'Get a specific product',
            'POST /api/products' => 'Create a new product',
            'PUT /api/products/{id}' => 'Update a product',
            'DELETE /api/products/{id}' => 'Delete a product',
        ]
    ]);
});
