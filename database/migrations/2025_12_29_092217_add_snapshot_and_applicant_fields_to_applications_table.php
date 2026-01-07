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
            if (!Schema::hasColumn('applications', 'cover_letter')) {
                $table->text('cover_letter')->nullable()->after('status');
            }
            if (!Schema::hasColumn('applications', 'applicant_name')) {
                $table->string('applicant_name')->nullable()->after('cover_letter');
            }
            if (!Schema::hasColumn('applications', 'applicant_email')) {
                $table->string('applicant_email')->nullable()->after('applicant_name');
            }
            if (!Schema::hasColumn('applications', 'applicant_phone')) {
                $table->string('applicant_phone')->nullable()->after('applicant_email');
            }
            if (!Schema::hasColumn('applications', 'applicant_last_position')) {
                $table->string('applicant_last_position')->nullable()->after('applicant_phone');
            }
            if (!Schema::hasColumn('applications', 'applicant_last_education')) {
                $table->string('applicant_last_education')->nullable()->after('applicant_last_position');
            }
            if (!Schema::hasColumn('applications', 'snapshot_data')) {
                $table->json('snapshot_data')->nullable()->after('applicant_last_education');
            }
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
