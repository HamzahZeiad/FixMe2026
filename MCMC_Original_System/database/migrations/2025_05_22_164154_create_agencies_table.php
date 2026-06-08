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
        Schema::create('agencies', function (Blueprint $table) {
            $table->bigIncrements('AgencyID');
            $table->string('AgencyName', 50);
            $table->string('AgencyEmail', 50)->unique();
            $table->string('AgencyPhoneNum', 20);
            $table->string('AgencyType', 50);
            $table->string('AgencyUserName', 50)->unique();
            $table->string('AgencyPassword');
            $table->string('AgencyProfilePicture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
