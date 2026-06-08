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
        Schema::table('administrators', function (Blueprint $table) {
            // Ensure AdminPassword column can accommodate bcrypt hashes (255 characters)
            $table->string('AdminPassword', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrators', function (Blueprint $table) {
            // Revert back to original length if needed
            $table->string('AdminPassword', 60)->change();
        });
    }
};
