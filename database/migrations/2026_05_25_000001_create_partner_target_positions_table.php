<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_target_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_target_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->integer('target_count');
            $table->timestamps();

            $table->unique(['partner_target_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_target_positions');
    }
};
