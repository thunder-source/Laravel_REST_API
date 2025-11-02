<?php

/**
 * Complete API Endpoint Testing Script
 * Tests all CRUD operations for the Product API
 */

class APITester
{
    private $baseUrl = 'http://localhost:8000/api';
    private $testProductId = null;
    private $passedTests = 0;
    private $failedTests = 0;

    // Color codes for terminal output
    private const COLOR_GREEN = "\033[32m";
    private const COLOR_RED = "\033[31m";
    private const COLOR_YELLOW = "\033[33m";
    private const COLOR_BLUE = "\033[34m";
    private const COLOR_CYAN = "\033[36m";
    private const COLOR_RESET = "\033[0m";
    private const COLOR_BOLD = "\033[1m";

    public function __construct()
    {
        echo $this->color("╔═══════════════════════════════════════════════════════════╗\n", 'cyan', true);
        echo $this->color("║     Laravel Product REST API - Endpoint Testing          ║\n", 'cyan', true);
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
            default => self::COLOR_RESET,
        };

        $boldCode = $bold ? self::COLOR_BOLD : '';
        return $boldCode . $colorCode . $text . self::COLOR_RESET;
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

    private function printTestHeader($testNumber, $testName)
    {
        echo $this->color("\n┌─────────────────────────────────────────────────────────┐\n", 'blue');
        echo $this->color("│ Test #{$testNumber}: {$testName}", 'blue', true);
        echo str_repeat(' ', 55 - strlen($testName) - strlen($testNumber));
        echo $this->color("│\n", 'blue');
        echo $this->color("└─────────────────────────────────────────────────────────┘\n", 'blue');
    }

    private function printResult($success, $message, $data = null)
    {
        if ($success) {
            echo $this->color("✓ PASSED: ", 'green', true) . $message . "\n";
            $this->passedTests++;
        } else {
            echo $this->color("✗ FAILED: ", 'red', true) . $message . "\n";
            $this->failedTests++;
        }
        
        if ($data !== null) {
            echo $this->color("Response: ", 'yellow');
            echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
        }
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

    public function test1_GetAllProductsEmpty()
    {
        $this->printTestHeader(1, "GET /api/products (Initial - Empty List)");
        
        $response = $this->makeRequest('GET', $this->baseUrl . '/products');
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        $success = $response['http_code'] === 200;
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " (Expected: 200)",
            $response['body']
        );
        
        return $success;
    }

    public function test2_CreateProduct()
    {
        $this->printTestHeader(2, "POST /api/products (Create New Product)");
        
        $productData = [
            'name' => 'Gaming Laptop',
            'description' => 'High-performance gaming laptop with RTX 4080',
            'price' => 1899.99,
            'quantity' => 25,
            'sku' => 'LAPTOP-GAMING-001'
        ];
        
        echo $this->color("Request Data: ", 'yellow');
        echo json_encode($productData, JSON_PRETTY_PRINT) . "\n\n";
        
        $response = $this->makeRequest('POST', $this->baseUrl . '/products', $productData);
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        $success = $response['http_code'] === 201 || $response['http_code'] === 200;
        
        if ($success && isset($response['body']['data']['id'])) {
            $this->testProductId = $response['body']['data']['id'];
            echo $this->color("→ Created Product ID: {$this->testProductId}\n\n", 'cyan');
        }
        
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " (Expected: 201 or 200)",
            $response['body']
        );
        
        return $success;
    }

    public function test3_GetAllProducts()
    {
        $this->printTestHeader(3, "GET /api/products (After Creation)");
        
        $response = $this->makeRequest('GET', $this->baseUrl . '/products');
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        $success = $response['http_code'] === 200 && 
                   isset($response['body']['data']) && 
                   is_array($response['body']['data']) &&
                   count($response['body']['data']) > 0;
        
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " | Products Count: " . (count($response['body']['data'] ?? [])),
            $response['body']
        );
        
        return $success;
    }

    public function test4_GetSingleProduct()
    {
        $this->printTestHeader(4, "GET /api/products/{id} (Get Specific Product)");
        
        if (!$this->testProductId) {
            $this->printResult(false, "No product ID available from previous test");
            return false;
        }
        
        echo $this->color("→ Fetching Product ID: {$this->testProductId}\n\n", 'cyan');
        
        $response = $this->makeRequest('GET', $this->baseUrl . '/products/' . $this->testProductId);
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        $success = $response['http_code'] === 200 && 
                   isset($response['body']['data']['id']) &&
                   $response['body']['data']['id'] == $this->testProductId;
        
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " | Product ID matches: " . ($success ? 'Yes' : 'No'),
            $response['body']
        );
        
        return $success;
    }

    public function test5_UpdateProduct()
    {
        $this->printTestHeader(5, "PUT /api/products/{id} (Update Product)");
        
        if (!$this->testProductId) {
            $this->printResult(false, "No product ID available from previous test");
            return false;
        }
        
        $updateData = [
            'name' => 'Gaming Laptop - UPDATED',
            'price' => 1699.99,
            'quantity' => 30
        ];
        
        echo $this->color("→ Updating Product ID: {$this->testProductId}\n", 'cyan');
        echo $this->color("Update Data: ", 'yellow');
        echo json_encode($updateData, JSON_PRETTY_PRINT) . "\n\n";
        
        $response = $this->makeRequest('PUT', $this->baseUrl . '/products/' . $this->testProductId, $updateData);
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        $success = $response['http_code'] === 200 &&
                   isset($response['body']['data']['name']) &&
                   $response['body']['data']['name'] === 'Gaming Laptop - UPDATED';
        
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " | Product updated successfully",
            $response['body']
        );
        
        return $success;
    }

    public function test6_DeleteProduct()
    {
        $this->printTestHeader(6, "DELETE /api/products/{id} (Delete Product)");
        
        if (!$this->testProductId) {
            $this->printResult(false, "No product ID available from previous test");
            return false;
        }
        
        echo $this->color("→ Deleting Product ID: {$this->testProductId}\n\n", 'cyan');
        
        $response = $this->makeRequest('DELETE', $this->baseUrl . '/products/' . $this->testProductId);
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        $success = $response['http_code'] === 200 || $response['http_code'] === 204;
        
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " | Product deleted successfully",
            $response['body']
        );
        
        return $success;
    }

    public function test7_GetDeletedProduct()
    {
        $this->printTestHeader(7, "GET /api/products/{id} (Verify Deletion)");
        
        if (!$this->testProductId) {
            $this->printResult(false, "No product ID available from previous test");
            return false;
        }
        
        echo $this->color("→ Attempting to fetch deleted Product ID: {$this->testProductId}\n\n", 'cyan');
        
        $response = $this->makeRequest('GET', $this->baseUrl . '/products/' . $this->testProductId);
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        // Should return 404 for deleted product
        $success = $response['http_code'] === 404;
        
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " (Expected: 404 - Product Not Found)",
            $response['body']
        );
        
        return $success;
    }

    public function test8_ValidationError()
    {
        $this->printTestHeader(8, "POST /api/products (Test Validation)");
        
        $invalidData = [
            'name' => '', // Invalid: empty name
            'price' => -50, // Invalid: negative price
            // Missing required fields: sku, quantity
        ];
        
        echo $this->color("Request Data (Invalid): ", 'yellow');
        echo json_encode($invalidData, JSON_PRETTY_PRINT) . "\n\n";
        
        $response = $this->makeRequest('POST', $this->baseUrl . '/products', $invalidData);
        
        if (!$response['success']) {
            $this->printResult(false, "Request failed: " . $response['error']);
            return false;
        }
        
        // Should return 422 for validation errors
        $success = $response['http_code'] === 422 && isset($response['body']['errors']);
        
        $this->printResult(
            $success,
            "Status Code: " . $response['http_code'] . " (Expected: 422 - Validation Error)",
            $response['body']
        );
        
        return $success;
    }

    public function printSummary()
    {
        $total = $this->passedTests + $this->failedTests;
        
        echo "\n";
        echo $this->color("╔═══════════════════════════════════════════════════════════╗\n", 'cyan', true);
        echo $this->color("║                    TEST SUMMARY                           ║\n", 'cyan', true);
        echo $this->color("╚═══════════════════════════════════════════════════════════╝\n", 'cyan', true);
        echo "\n";
        
        echo $this->color("Total Tests: ", 'yellow', true) . $total . "\n";
        echo $this->color("Passed: ", 'green', true) . $this->passedTests . "\n";
        echo $this->color("Failed: ", 'red', true) . $this->failedTests . "\n";
        echo "\n";
        
        $percentage = $total > 0 ? round(($this->passedTests / $total) * 100, 2) : 0;
        
        if ($this->failedTests === 0) {
            echo $this->color("🎉 ALL TESTS PASSED! ({$percentage}%)\n", 'green', true);
        } else {
            echo $this->color("⚠ Some tests failed. Success rate: {$percentage}%\n", 'yellow', true);
        }
        
        echo "\n";
        echo $this->color("═══════════════════════════════════════════════════════════\n", 'cyan');
    }

    public function runAllTests()
    {
        // Check server connection first
        if (!$this->checkServerConnection()) {
            return;
        }
        
        // Run all tests in sequence
        $this->test1_GetAllProductsEmpty();
        $this->test2_CreateProduct();
        $this->test3_GetAllProducts();
        $this->test4_GetSingleProduct();
        $this->test5_UpdateProduct();
        $this->test6_DeleteProduct();
        $this->test7_GetDeletedProduct();
        $this->test8_ValidationError();
        
        // Print summary
        $this->printSummary();
    }
}

// Run the tests
$tester = new APITester();
$tester->runAllTests();


