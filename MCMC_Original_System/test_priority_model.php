<?php

use App\Models\Inquiry;

echo "Testing InquiryPriority column...\n";

try {
    // Try to get first inquiry and check its priority
    $inquiry = Inquiry::first();
    
    if ($inquiry) {
        echo "✅ Found inquiry: {$inquiry->InquiryTitle}\n";
        echo "📊 Priority: " . ($inquiry->InquiryPriority ?? 'NULL') . "\n";
        
        // Try to update priority
        $inquiry->InquiryPriority = 'High';
        $inquiry->save();
        
        echo "✅ Successfully updated priority to High\n";
    } else {
        echo "❌ No inquiries found in database\n";
    }
    
    // Test ordering by priority
    $inquiries = Inquiry::orderByRaw("
        CASE 
            WHEN COALESCE(InquiryPriority, 'Normal') = 'High' THEN 1
            WHEN COALESCE(InquiryPriority, 'Normal') = 'Medium' THEN 2
            WHEN COALESCE(InquiryPriority, 'Normal') = 'Low' THEN 3
            ELSE 4
        END
    ")->limit(3)->get();
    
    echo "✅ Successfully ordered by priority\n";
    echo "📊 Found {$inquiries->count()} inquiries\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "Test completed!\n";
