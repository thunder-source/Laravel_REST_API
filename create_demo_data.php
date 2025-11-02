<?php

/**
 * Demo Data Generator for Product API
 * Creates sample products for testing and demonstration
 */

class DemoDataGenerator
{
    private $baseUrl = 'http://localhost:8000/api';
    private $createdProducts = [];
    private $successCount = 0;
    private $failureCount = 0;

    // Color codes for terminal output
    private const COLOR_GREEN = "\033[32m";
    private const COLOR_RED = "\033[31m";
    private const COLOR_YELLOW = "\033[33m";
    private const COLOR_BLUE = "\033[34m";
    private const COLOR_CYAN = "\033[36m";
    private const COLOR_MAGENTA = "\033[35m";
    private const COLOR_RESET = "\033[0m";
    private const COLOR_BOLD = "\033[1m";

    // Demo products data
    private $demoProducts = [
        [
            'name' => 'MacBook Pro 16"',
            'description' => 'Apple M3 Max chip, 36GB RAM, 1TB SSD. Perfect for professional developers and creative work.',
            'price' => 3499.99,
            'quantity' => 15,
            'sku' => 'APPLE-MBP16-M3MAX',
            'category' => 'Electronics'
        ],
        [
            'name' => 'Dell XPS 15',
            'description' => 'Intel Core i9, 32GB RAM, 1TB SSD, NVIDIA RTX 4060. Premium Windows laptop for professionals.',
            'price' => 2299.99,
            'quantity' => 20,
            'sku' => 'DELL-XPS15-I9',
            'category' => 'Electronics'
        ],
        [
            'name' => 'Sony WH-1000XM5',
            'description' => 'Industry-leading noise cancellation wireless headphones. 30-hour battery life.',
            'price' => 399.99,
            'quantity' => 50,
            'sku' => 'SONY-WH1000XM5-BLK',
            'category' => 'Audio'
        ],
        [
            'name' => 'iPhone 15 Pro Max',
            'description' => 'A17 Pro chip, 256GB storage, Titanium design, 48MP camera system.',
            'price' => 1199.99,
            'quantity' => 35,
            'sku' => 'APPLE-IP15PM-256',
            'category' => 'Smartphones'
        ],
        [
            'name' => 'Samsung Galaxy S24 Ultra',
            'description' => 'Snapdragon 8 Gen 3, 12GB RAM, 512GB storage, 200MP camera, S Pen included.',
            'price' => 1299.99,
            'quantity' => 28,
            'sku' => 'SAMSUNG-S24U-512',
            'category' => 'Smartphones'
        ],
        [
            'name' => 'LG C3 OLED 65"',
            'description' => '4K OLED TV with HDMI 2.1, 120Hz refresh rate, perfect for gaming and movies.',
            'price' => 1899.99,
            'quantity' => 12,
            'sku' => 'LG-C3-OLED-65',
            'category' => 'TVs'
        ],
        [
            'name' => 'Logitech MX Master 3S',
            'description' => 'Advanced wireless mouse with ergonomic design, 8K DPI sensor, quiet clicks.',
            'price' => 99.99,
            'quantity' => 75,
            'sku' => 'LOGI-MXM3S-BLK',
            'category' => 'Accessories'
        ],
        [
            'name' => 'Keychron K8 Pro',
            'description' => 'Wireless mechanical keyboard, hot-swappable switches, RGB backlight.',
            'price' => 119.99,
            'quantity' => 45,
            'sku' => 'KEYCHRON-K8PRO-RGB',
            'category' => 'Accessories'
        ],
        [
            'name' => 'PlayStation 5',
            'description' => 'Next-gen gaming console with 825GB SSD, 4K gaming, DualSense controller.',
            'price' => 499.99,
            'quantity' => 25,
            'sku' => 'SONY-PS5-STD',
            'category' => 'Gaming'
        ],
        [
            'name' => 'Xbox Series X',
            'description' => 'Microsoft gaming console, 1TB SSD, 4K 120fps gaming, Game Pass compatible.',
            'price' => 499.99,
            'quantity' => 30,
            'sku' => 'MSFT-XSX-1TB',
            'category' => 'Gaming'
        ],
        [
            'name' => 'iPad Pro 12.9"',
            'description' => 'M2 chip, 256GB storage, Liquid Retina XDR display, Face ID.',
            'price' => 1099.99,
            'quantity' => 22,
            'sku' => 'APPLE-IPP129-M2-256',
            'category' => 'Tablets'
        ],
        [
            'name' => 'Samsung Galaxy Tab S9',
            'description' => '11-inch AMOLED display, Snapdragon 8 Gen 2, S Pen included, 128GB.',
            'price' => 799.99,
            'quantity' => 18,
            'sku' => 'SAMSUNG-TABS9-128',
            'category' => 'Tablets'
        ],
        [
            'name' => 'AirPods Pro 2',
            'description' => 'Active noise cancellation, Spatial Audio, USB-C charging case.',
            'price' => 249.99,
            'quantity' => 60,
            'sku' => 'APPLE-APP2-USBC',
            'category' => 'Audio'
        ],
        [
            'name' => 'Canon EOS R6 Mark II',
            'description' => 'Full-frame mirrorless camera, 24.2MP, 4K 60fps video, in-body stabilization.',
            'price' => 2499.99,
            'quantity' => 8,
            'sku' => 'CANON-R6M2-BODY',
            'category' => 'Cameras'
        ],
        [
            'name' => 'DJI Mini 3 Pro',
            'description' => 'Compact foldable drone, 4K HDR video, 34-minute flight time, obstacle avoidance.',
            'price' => 759.99,
            'quantity' => 15,
            'sku' => 'DJI-MINI3PRO',
            'category' => 'Drones'
        ],
        [
            'name' => 'ASUS ROG Strix RTX 4080',
            'description' => 'NVIDIA GeForce RTX 4080 16GB graphics card, triple-fan cooling, RGB lighting.',
            'price' => 1299.99,
            'quantity' => 10,
            'sku' => 'ASUS-RTX4080-ROG',
            'category' => 'PC Components'
        ],
        [
            'name' => 'Samsung 990 PRO 2TB',
            'description' => 'NVMe SSD, PCIe 4.0, up to 7,450 MB/s read speed, perfect for gaming.',
            'price' => 199.99,
            'quantity' => 40,
            'sku' => 'SAMSUNG-990PRO-2TB',
            'category' => 'PC Components'
        ],
        [
            'name' => 'Apple Watch Series 9',
            'description' => '45mm GPS + Cellular, Always-On Retina display, health tracking, watchOS 10.',
            'price' => 529.99,
            'quantity' => 32,
            'sku' => 'APPLE-AWS9-45-CEL',
            'category' => 'Wearables'
        ],
        [
            'name' => 'Fitbit Charge 6',
            'description' => 'Advanced fitness tracker, heart rate monitoring, built-in GPS, 7-day battery.',
            'price' => 159.99,
            'quantity' => 55,
            'sku' => 'FITBIT-CHARGE6',
            'category' => 'Wearables'
        ],
        [
            'name' => 'GoPro HERO12 Black',
            'description' => '5.3K60 video, HyperSmooth 6.0 stabilization, waterproof design, voice control.',
            'price' => 449.99,
            'quantity' => 20,
            'sku' => 'GOPRO-HERO12-BLK',
            'category' => 'Cameras'
        ]
    ];

    public function __construct()
    {
        echo $this->color("╔═══════════════════════════════════════════════════════════╗\n", 'cyan', true);
        echo $this->color("║          Product API - Demo Data Generator               ║\n", 'cyan', true);
        echo $this->color("╚═══════════════════════════════════════════════════════════╝\n", 'cyan', true);
        echo "\n";
    }

    private function color($text, $color, $bold = false)
    {
        $colorCode = match ($color) {
            'green' => self::COLOR_GREEN,
            'red' => self::COLOR_RED,
            'yellow' => self::COLOR_YELLOW,
            'blue' => self::COLOR_BLUE,
            'cyan' => self::COLOR_CYAN,
            'magenta' => self::COLOR_MAGENTA,
            default => self::COLOR_RESET,
        };

        $boldCode = $bold ? self::COLOR_BOLD : '';
        return $boldCode . $colorCode . $text . self::COLOR_RESET;
    }

    private function checkServerConnection()
    {
        echo $this->color("→ Checking server connection...\n", 'yellow');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            echo $this->color("✗ ERROR: Cannot connect to server at http://localhost:8000\n", 'red', true);
            echo $this->color("  Make sure the Laravel server is running: php artisan serve\n", 'yellow');
            return false;
        }
        
        echo $this->color("✓ Server is running!\n\n", 'green', true);
        return true;
    }

    private function makeRequest($method, $url, $data = null)
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            return [
                'success' => false,
                'error' => $error,
                'http_code' => $httpCode
            ];
        }
        
        return [
            'success' => true,
            'http_code' => $httpCode,
            'body' => json_decode($response, true),
            'raw' => $response
        ];
    }

    private function createProduct($productData)
    {
        $response = $this->makeRequest('POST', $this->baseUrl . '/products', $productData);
        
        if (!$response['success']) {
            return [
                'success' => false,
                'error' => $response['error']
            ];
        }
        
        $success = $response['http_code'] === 201 || $response['http_code'] === 200;
        
        return [
            'success' => $success,
            'http_code' => $response['http_code'],
            'data' => $response['body']['data'] ?? null,
            'error' => $response['body']['message'] ?? null
        ];
    }

    public function generate()
    {
        if (!$this->checkServerConnection()) {
            return;
        }

        echo $this->color("📦 Creating demo products...\n\n", 'blue', true);
        echo $this->color("Total products to create: " . count($this->demoProducts) . "\n\n", 'cyan');

        $progressBar = str_repeat('─', 60);
        echo $this->color($progressBar . "\n", 'cyan');

        foreach ($this->demoProducts as $index => $product) {
            $num = $index + 1;
            
            // Remove category as it's not in the API schema
            $category = $product['category'];
            unset($product['category']);
            
            echo $this->color("[$num/" . count($this->demoProducts) . "] ", 'cyan', true);
            echo $this->color("Creating: ", 'yellow') . $product['name'];
            echo $this->color(" (" . $category . ")", 'magenta');
            
            $result = $this->createProduct($product);
            
            if ($result['success']) {
                echo " " . $this->color("✓", 'green', true) . "\n";
                echo $this->color("      → ", 'cyan') . "Price: $" . $product['price'] . " | Stock: " . $product['quantity'] . " | SKU: " . $product['sku'] . "\n";
                
                if (isset($result['data']['id'])) {
                    echo $this->color("      → ", 'cyan') . "Product ID: " . $result['data']['id'] . "\n";
                    $this->createdProducts[] = $result['data'];
                }
                
                $this->successCount++;
            } else {
                echo " " . $this->color("✗", 'red', true) . "\n";
                echo $this->color("      → Error: ", 'red') . ($result['error'] ?? 'Unknown error') . "\n";
                $this->failureCount++;
            }
            
            echo "\n";
            
            // Small delay to avoid overwhelming the server
            usleep(100000); // 0.1 second
        }

        echo $this->color($progressBar . "\n\n", 'cyan');
    }

    public function printSummary()
    {
        echo $this->color("╔═══════════════════════════════════════════════════════════╗\n", 'cyan', true);
        echo $this->color("║                    GENERATION SUMMARY                     ║\n", 'cyan', true);
        echo $this->color("╚═══════════════════════════════════════════════════════════╝\n", 'cyan', true);
        echo "\n";

        $total = $this->successCount + $this->failureCount;
        
        echo $this->color("Total Products Attempted: ", 'yellow', true) . $total . "\n";
        echo $this->color("Successfully Created: ", 'green', true) . $this->successCount . "\n";
        echo $this->color("Failed: ", 'red', true) . $this->failureCount . "\n";
        echo "\n";

        if ($this->successCount > 0) {
            $percentage = round(($this->successCount / $total) * 100, 2);
            echo $this->color("Success Rate: {$percentage}%\n", 'cyan', true);
            echo "\n";

            // Calculate total inventory value
            $totalValue = 0;
            $totalStock = 0;
            foreach ($this->createdProducts as $product) {
                $price = floatval($product['price']);
                $quantity = intval($product['quantity']);
                $totalValue += $price * $quantity;
                $totalStock += $quantity;
            }

            echo $this->color("📊 Inventory Statistics:\n", 'blue', true);
            echo $this->color("   Total Products: ", 'yellow') . count($this->createdProducts) . "\n";
            echo $this->color("   Total Stock Units: ", 'yellow') . number_format($totalStock) . "\n";
            echo $this->color("   Total Inventory Value: ", 'yellow') . "$" . number_format($totalValue, 2) . "\n";
            echo "\n";
        }

        if ($this->failureCount === 0) {
            echo $this->color("🎉 ALL PRODUCTS CREATED SUCCESSFULLY!\n", 'green', true);
        } else {
            echo $this->color("⚠ Some products failed to create.\n", 'yellow', true);
        }

        echo "\n";
        echo $this->color("💡 Next Steps:\n", 'blue', true);
        echo "   • View all products: " . $this->color("curl http://localhost:8000/api/products\n", 'cyan');
        echo "   • Test the API: " . $this->color("php test_all_endpoints.php\n", 'cyan');
        echo "   • Open in browser: " . $this->color("http://localhost:8000/api/products\n", 'cyan');
        echo "\n";
        
        echo $this->color("═══════════════════════════════════════════════════════════\n", 'cyan');
    }

    public function run()
    {
        $this->generate();
        $this->printSummary();
    }
}

// Check for command line options
$options = getopt("h", ["help", "clear"]);

if (isset($options['h']) || isset($options['help'])) {
    echo "Demo Data Generator for Product API\n\n";
    echo "Usage: php create_demo_data.php [OPTIONS]\n\n";
    echo "Options:\n";
    echo "  -h, --help     Show this help message\n";
    echo "  --clear        Clear all products before creating demo data\n\n";
    echo "Examples:\n";
    echo "  php create_demo_data.php           # Create demo data\n";
    echo "  php create_demo_data.php --clear   # Clear and create demo data\n\n";
    exit(0);
}

if (isset($options['clear'])) {
    echo "\033[33m⚠ Warning: This will delete all existing products!\033[0m\n";
    echo "Are you sure? (yes/no): ";
    
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    fclose($handle);
    
    if (trim(strtolower($line)) === 'yes') {
        echo "\033[32m✓ Clearing products...\033[0m\n\n";
        // Note: You would need to implement a clear endpoint or run: php artisan migrate:fresh
        echo "\033[33mℹ To clear products, run: php artisan migrate:fresh\033[0m\n\n";
    } else {
        echo "Cancelled.\n";
        exit(0);
    }
}

// Run the generator
$generator = new DemoDataGenerator();
$generator->run();

