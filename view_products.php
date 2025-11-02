<?php

/**
 * Simple Product Viewer
 * Displays all products in a formatted table
 */

$response = file_get_contents('http://localhost:8000/api/products');
$data = json_decode($response, true);

if (!$data || !isset($data['data'])) {
    echo "Error fetching products\n";
    exit(1);
}

$products = $data['data'];

echo "\n";
echo "\033[1m\033[36m╔═══════════════════════════════════════════════════════════════════════════════════════╗\033[0m\n";
echo "\033[1m\033[36m║                              PRODUCT INVENTORY                                        ║\033[0m\n";
echo "\033[1m\033[36m╚═══════════════════════════════════════════════════════════════════════════════════════╝\033[0m\n";
echo "\n";

echo "\033[1mTotal Products: " . count($products) . "\033[0m\n\n";

echo str_pad("ID", 5) . " | ";
echo str_pad("Product Name", 30) . " | ";
echo str_pad("Price", 12) . " | ";
echo str_pad("Stock", 8) . " | ";
echo str_pad("SKU", 25) . "\n";
echo str_repeat("─", 95) . "\n";

$totalValue = 0;
$totalStock = 0;

foreach ($products as $product) {
    $price = floatval($product['price']);
    $quantity = intval($product['quantity']);
    $totalValue += $price * $quantity;
    $totalStock += $quantity;
    
    echo str_pad($product['id'], 5) . " | ";
    echo str_pad(substr($product['name'], 0, 30), 30) . " | ";
    echo str_pad("$" . number_format($price, 2), 12) . " | ";
    echo str_pad($quantity, 8) . " | ";
    echo str_pad($product['sku'], 25) . "\n";
}

echo str_repeat("─", 95) . "\n";
echo "\n";
echo "\033[1m\033[33m📊 Summary Statistics:\033[0m\n";
echo "   Total Products: \033[36m" . count($products) . "\033[0m\n";
echo "   Total Stock Units: \033[36m" . number_format($totalStock) . "\033[0m\n";
echo "   Total Inventory Value: \033[36m$" . number_format($totalValue, 2) . "\033[0m\n";
echo "\n";

