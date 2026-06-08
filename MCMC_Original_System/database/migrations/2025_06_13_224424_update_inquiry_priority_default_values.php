<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, ensure the column exists
        if (!Schema::hasColumn('inquiries', 'InquiryPriority')) {
            Schema::table('inquiries', function (Blueprint $table) {
                $table->string('InquiryPriority', 20)->default('Normal')->after('InquiryStatus');
            });
        }

        // Update all existing records to have a default priority if they don't have one
        DB::table('inquiries')
            ->whereNull('InquiryPriority')
            ->orWhere('InquiryPriority', '')
            ->update(['InquiryPriority' => 'Normal']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is for data updates, no need to reverse
    }
};
