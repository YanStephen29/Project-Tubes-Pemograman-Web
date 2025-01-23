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
        
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('address');
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('restaurant_photo')->nullable()->after('profile_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['restaurant_photo', 'profile_photo']);
        });
    }
};
