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
        Schema::table('jobs', function (Blueprint $table) {
            // Mengganti nama kolom agar lebih jelas
            $table->renameColumn('description', 'jobdesk');
            $table->renameColumn('responsibilities', 'requirement');
            $table->renameColumn('qualifications', 'benefits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Logika untuk mengembalikan jika diperlukan
            $table->renameColumn('jobdesk', 'description');
            $table->renameColumn('requirement', 'responsibilities');
            $table->renameColumn('benefits', 'qualifications');
        });
    }
};
