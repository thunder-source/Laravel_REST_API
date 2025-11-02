<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configure the database
$db = new DB;
$db->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database/database.sqlite',
    'prefix' => '',
]);

// Make this Capsule instance available globally
$db->setAsGlobal();
$db->bootEloquent();

try {
    // Test the connection
    DB::connection()->getPdo();
    echo "✅ Database connection successful!\n";
    
    // Check if migrations table exists
    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name='migrations'");
    if (count($tables) > 0) {
        echo "✅ Migrations table exists\n";
        
        // List all tables
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        echo "\n📋 Database tables:\n";
        foreach ($tables as $table) {
            echo "- {$table->name}\n";
        }
    } else {
        echo "❌ Migrations table does not exist. Did you run migrations?\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    
    // Additional debug info
    echo "\nDebug info:\n";
    echo "- PHP Version: " . phpversion() . "\n";
    echo "- PDO Drivers: " . implode(', ', PDO::getAvailableDrivers()) . "\n";
    echo "- Database file exists: " . (file_exists(__DIR__ . '/database/database.sqlite') ? 'Yes' : 'No') . "\n";
    echo "- Database file is writable: " . (is_writable(__DIR__ . '/database/database.sqlite') ? 'Yes' : 'No') . "\n";
}
