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
        Schema::create('public_users', function (Blueprint $table) {
            $table->bigIncrements('UserID');
            $table->string('UserName', 50);
            $table->string('UserEmail', 50)->unique();
            $table->string('UserPhoneNum', 20);
            $table->string('UserPassword');
            $table->string('UserProfilePicture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_users');
    }
};
