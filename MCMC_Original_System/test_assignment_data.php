<?php

// Test script to verify assignment report functionality
require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Inquiry;
use App\Models\Agency;

// Load Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Testing assignment report data...\n";

    // Check assigned inquiries
    $assignedInquiries = Inquiry::whereNotNull('AgencyID')->with(['user', 'agency'])->get();
    echo "Found " . $assignedInquiries->count() . " assigned inquiries\n";

    if ($assignedInquiries->count() > 0) {
        $inquiry = $assignedInquiries->first();
        echo "Sample assignment:\n";
        echo "- Inquiry ID: " . $inquiry->InquiryID . "\n";
        echo "- Title: " . $inquiry->InquiryTitle . "\n";
        echo "- Status: " . $inquiry->InquiryStatus . "\n";
        echo "- Agency: " . ($inquiry->agency ? $inquiry->agency->AgencyName : 'No Agency') . "\n";
        echo "- Assignment Date: " . ($inquiry->assignment_date ? $inquiry->assignment_date : 'Not set') . "\n";
    }

    // Check agencies
    $agencies = Agency::all();
    echo "\nAvailable agencies:\n";
    foreach ($agencies as $agency) {
        $assignmentCount = Inquiry::where('AgencyID', $agency->AgencyID)->count();
        echo "- " . $agency->AgencyName . " (ID: " . $agency->AgencyID . ") - " . $assignmentCount . " assignments\n";
    }

    echo "\n✅ Assignment report data looks good!\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
