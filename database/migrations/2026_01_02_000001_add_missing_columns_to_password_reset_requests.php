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
        Schema::table('password_reset_requests', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('password_reset_requests', 'phone')) {
                $table->string('phone')->after('email');
            }
            if (!Schema::hasColumn('password_reset_requests', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('phone')->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('password_reset_requests', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('password_reset_requests', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
            if (!Schema::hasColumn('password_reset_requests', 'reason')) {
                $table->text('reason')->nullable()->after('user_agent');
            }
            if (!Schema::hasColumn('password_reset_requests', 'admin_id')) {
                $table->foreignId('admin_id')->nullable()->after('status')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('password_reset_requests', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('admin_id');
            }
            if (!Schema::hasColumn('password_reset_requests', 'temporary_password')) {
                $table->string('temporary_password')->nullable()->after('admin_note');
            }
            if (!Schema::hasColumn('password_reset_requests', 'processed_at')) {
                $table->timestamp('processed_at')->nullable()->after('temporary_password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'user_id', 'ip_address', 'user_agent', 'reason',
                'admin_id', 'admin_note', 'temporary_password', 'processed_at'
            ]);
        });
    }
};
