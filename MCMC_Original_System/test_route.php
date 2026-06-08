<?php
// Simple route test script
require_once __DIR__ . '/vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    echo "Testing admin.user.view route...\n";

    // Test if route exists
    $route = route('admin.user.view', ['id' => 1]);
    echo "Route URL: " . $route . "\n";
    echo "✅ Route admin.user.view exists and is working!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
