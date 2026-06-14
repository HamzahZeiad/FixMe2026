<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiry_progress_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id');
            $table->text('note');
            $table->string('note_type')->default('progress'); // progress, internal, customer_facing, resolution
            $table->unsignedBigInteger('added_by')->nullable();
            $table->string('added_by_type')->nullable(); // admin, agency
            $table->string('added_by_name')->nullable();
            $table->boolean('is_internal')->default(false);
            $table->boolean('is_visible_to_user')->default(true);
            $table->string('priority_level')->nullable();
            $table->boolean('requires_action')->default(false);
            $table->timestamp('action_due_date')->nullable();
            $table->timestamps();

            $table->foreign('inquiry_id')->references('InquiryID')->on('inquiries')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_progress_notes');
    }
};
