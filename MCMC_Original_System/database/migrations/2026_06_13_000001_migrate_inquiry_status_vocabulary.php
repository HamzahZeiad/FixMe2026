<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migrate existing inquiry status values from the old non-SDD vocabulary
 * to the authoritative SDD vocabulary.
 *
 * Mapping:
 *   Old                  → New
 *   Pending              → Submitted   (not yet reviewed by admin)
 *   Under Investigation  → In Progress (agency is working on it)
 *   Verified as True     → Resolved    (agency resolved as true)
 *   Identified as Fake   → Closed      (agency closed as fake)
 *   Rejected             → Rejected    (unchanged)
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('inquiries')->where('InquiryStatus', 'Pending')->update(['InquiryStatus' => 'Submitted']);
        DB::table('inquiries')->where('InquiryStatus', 'Under Investigation')->update(['InquiryStatus' => 'In Progress']);
        DB::table('inquiries')->where('InquiryStatus', 'Verified as True')->update(['InquiryStatus' => 'Resolved']);
        DB::table('inquiries')->where('InquiryStatus', 'Identified as Fake')->update(['InquiryStatus' => 'Closed']);
        // 'Rejected' stays as-is
    }

    public function down(): void
    {
        DB::table('inquiries')->where('InquiryStatus', 'Submitted')->update(['InquiryStatus' => 'Pending']);
        DB::table('inquiries')->where('InquiryStatus', 'In Progress')->update(['InquiryStatus' => 'Under Investigation']);
        DB::table('inquiries')->where('InquiryStatus', 'Resolved')->update(['InquiryStatus' => 'Verified as True']);
        DB::table('inquiries')->where('InquiryStatus', 'Closed')->update(['InquiryStatus' => 'Identified as Fake']);
    }
};
