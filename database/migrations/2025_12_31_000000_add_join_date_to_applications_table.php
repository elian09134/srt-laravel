<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('applications', 'join_date')) {
            Schema::table('applications', function (Blueprint $table) {
                $table->date('join_date')->nullable()->after('status');
            });
        }
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('join_date');
        });
    }
};
