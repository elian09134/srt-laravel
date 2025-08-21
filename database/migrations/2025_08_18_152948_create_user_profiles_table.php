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
        Schema::create('user_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Kolom Baru
        $table->string('nickname')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->text('about_me')->nullable();
        $table->string('photo_path')->nullable(); // Untuk menyimpan path foto profil

        // Kolom yang sudah ada
        $table->string('phone_number')->nullable();
        $table->text('address')->nullable();
        $table->string('education_level')->nullable();
        $table->string('institution')->nullable();
        $table->string('major')->nullable();
        $table->text('skills')->nullable();
        $table->text('languages')->nullable();
        $table->text('job_interest')->nullable();
        $table->string('cv_path')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
