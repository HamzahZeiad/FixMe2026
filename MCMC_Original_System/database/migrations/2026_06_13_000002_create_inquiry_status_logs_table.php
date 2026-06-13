<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the inquiry_status_logs table.
 * Required by SDD for StatusesController::statusHistory()
 * and the InquiryCommunicationLogPage / timeline view.
 *
 * Every time an inquiry status changes, a row is written here.
 * This provides a full audit trail.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiry_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('InquiryID');
            $table->string('status', 50);                          // new status value
            $table->string('previous_status', 50)->nullable();     // what it was before
            $table->text('notes')->nullable();                     // investigation notes / clarification message
            $table->string('actor_type', 20);                     // 'agency', 'admin', 'system'
            $table->unsignedBigInteger('actor_id')->nullable();   // AgencyID or AdminID
            $table->string('actor_name', 100)->nullable();        // denormalized for display
            $table->timestamps();

            $table->foreign('InquiryID')->references('InquiryID')->on('inquiries')->onDelete('cascade');
            $table->index('InquiryID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_status_logs');
    }
};
