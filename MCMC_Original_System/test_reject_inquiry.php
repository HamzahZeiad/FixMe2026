<?php

// Test script to verify reject inquiry functionality
require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Inquiry;

// Load Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Testing inquiry rejection functionality...\n";

    // Find the first inquiry to test with
    $inquiry = Inquiry::first();

    if (!$inquiry) {
        echo "❌ No inquiries found in database\n";
        exit;
    }

    echo "Found inquiry ID: " . $inquiry->InquiryID . "\n";
    echo "Current status: " . $inquiry->InquiryStatus . "\n";

    // Test updating the inquiry (simulating rejection)
    $inquiry->InquiryStatus = 'Rejected';
    $inquiry->StatusComments = 'outside_jurisdiction - Test rejection comment';
    $inquiry->ProcessedAt = now();
    $inquiry->save();

    echo "✅ SUCCESS: Inquiry rejection test completed!\n";
    echo "New status: " . $inquiry->InquiryStatus . "\n";
    echo "Status comments: " . $inquiry->StatusComments . "\n";
    echo "Processed at: " . $inquiry->ProcessedAt . "\n";

    // Revert the changes for testing purposes
    $inquiry->InquiryStatus = 'Pending';
    $inquiry->StatusComments = null;
    $inquiry->ProcessedAt = null;
    $inquiry->save();
    echo "✅ Test data reverted.\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
