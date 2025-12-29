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
        Schema::table('applications', function (Blueprint $table) {
            $table->text('cover_letter')->nullable()->after('status');
            $table->string('applicant_name')->nullable()->after('cover_letter');
            $table->string('applicant_email')->nullable()->after('applicant_name');
            $table->string('applicant_phone')->nullable()->after('applicant_email');
            $table->string('applicant_last_position')->nullable()->after('applicant_phone');
            $table->string('applicant_last_education')->nullable()->after('applicant_last_position');
            $table->json('snapshot_data')->nullable()->after('applicant_last_education');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'cover_letter',
                'applicant_name',
                'applicant_email',
                'applicant_phone',
                'applicant_last_position',
                'applicant_last_education',
                'snapshot_data',
            ]);
        });
    }
};
