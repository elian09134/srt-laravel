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
        Schema::table('user_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('user_profiles', 'currently_employed')) {
                $table->boolean('currently_employed')->default(false)->after('last_company_duration');
            }

            if (!Schema::hasColumn('user_profiles', 'expected_salary')) {
                $table->unsignedBigInteger('expected_salary')->nullable()->after('currently_employed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('user_profiles', 'expected_salary')) {
                $table->dropColumn('expected_salary');
            }

            if (Schema::hasColumn('user_profiles', 'currently_employed')) {
                $table->dropColumn('currently_employed');
            }
        });
    }
};
