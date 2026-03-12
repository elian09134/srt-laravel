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
            $table->string('formal_photo_path')->nullable()->after('photo_path');
            $table->string('ktp_path')->nullable()->after('formal_photo_path');
            $table->string('kk_path')->nullable()->after('ktp_path');
            $table->string('ijazah_path')->nullable()->after('kk_path');
            $table->string('certificate_path')->nullable()->after('ijazah_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'formal_photo_path',
                'ktp_path',
                'kk_path',
                'ijazah_path',
                'certificate_path'
            ]);
        });
    }
};
