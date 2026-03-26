<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite: recreate column as string since ALTER ENUM is not supported
        if (DB::getDriverName() === 'sqlite') {
            // SQLite doesn't enforce enum, so string values already work.
            // Just add the new columns.
        } else {
            // MySQL: change enum to include 'completed'
            DB::statement("ALTER TABLE fptks MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'pending'");
        }

        Schema::table('fptks', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable()->after('admin_signature');
            $table->foreignId('completed_by')->nullable()->after('completed_at')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('fptks', function (Blueprint $table) {
            $table->dropForeign(['completed_by']);
            $table->dropColumn(['completed_at', 'completed_by']);
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE fptks MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
        }
    }
};
