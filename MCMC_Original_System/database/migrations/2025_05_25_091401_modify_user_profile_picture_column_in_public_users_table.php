<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('public_users', function (Blueprint $table) {
            $table->string('UserProfilePicture', 512)->nullable()->change(); // Increase length to 512
        });
    }

    public function down(): void
    {
        Schema::table('public_users', function (Blueprint $table) {
            $table->string('UserProfilePicture', 512)->nullable()->change(); // Revert to 255 if needed
        });
    }
};
