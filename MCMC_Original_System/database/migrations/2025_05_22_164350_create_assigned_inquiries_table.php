<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assigned_inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('AdminID');
            $table->unsignedBigInteger('AgencyID');
            $table->unsignedBigInteger('InquiryID');
            $table->date('AssignedDate');
            $table->string('AdminNote', 255)->nullable();

            $table->primary(['AdminID', 'AgencyID', 'InquiryID']);

            $table->foreign('AdminID')->references('AdminID')->on('administrators');
            $table->foreign('AgencyID')->references('AgencyID')->on('agencies');
            $table->foreign('InquiryID')->references('InquiryID')->on('inquiries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_inquiries');
    }
};
