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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->bigIncrements('InquiryID');
            $table->string('InquiryTitle', 50);
            $table->string('InquiryStatus', 50);
            $table->string('VerificationDescription', 255)->nullable();
            $table->string('InquirySource', 100);
            $table->date('InquirySendDate');
            $table->string('InquiryDescription', 255);
            $table->text('InquiryEvidence');
            $table->unsignedBigInteger('AgencyID')->nullable();
            $table->unsignedBigInteger('AdminID')->nullable();
            $table->unsignedBigInteger('UserID')->nullable();
            $table->timestamps();

            $table->foreign('AgencyID')->references('AgencyID')->on('agencies')->onDelete('set null');
            $table->foreign('AdminID')->references('AdminID')->on('administrators')->onDelete('set null');
            $table->foreign('UserID')->references('UserID')->on('public_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
