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
        Schema::create('administrators', function (Blueprint $table) {
            $table->bigIncrements('AdminID');
            $table->string('AdminName', 50);
            $table->string('AdminEmail', 50)->unique();
            $table->string('AdminRole', 50);
            $table->string('AdminPhoneNum', 20);
            $table->string('AdminAddress', 255);
            $table->string('AdminUserName', 50)->unique();
            $table->string('AdminPassword');
            $table->string('AdminProfilePicture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrators');
    }
};
