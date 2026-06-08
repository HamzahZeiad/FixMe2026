<?php

// Test script to verify registration works
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\Models\PublicUser;

// Load Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Testing registration functionality...\n";

    // Test data
    $testData = [
        'UserName' => 'TestUser' . rand(1000, 9999),
        'UserEmail' => 'test' . rand(1000, 9999) . '@example.com',
        'UserPassword' => Hash::make('password123'),
        'UserPhoneNum' => null, // This should work now
    ];

    echo "Creating user with data: " . json_encode($testData, JSON_PRETTY_PRINT) . "\n";

    // Create user
    $user = PublicUser::create($testData);

    echo "✅ SUCCESS: User created successfully!\n";
    echo "User ID: " . $user->UserID . "\n";
    echo "User Name: " . $user->UserName . "\n";
    echo "User Email: " . $user->UserEmail . "\n";
    echo "User Phone: " . ($user->UserPhoneNum ?? 'NULL') . "\n";

    // Clean up - delete the test user
    $user->delete();
    echo "✅ Test user cleaned up.\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
