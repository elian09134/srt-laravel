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
        // Hapus tabel lama jika ada, untuk memastikan struktur baru diterapkan
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_education');

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // --- Informasi Pribadi ---
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('ptkp_status')->nullable();
            $table->string('id_card_number')->unique()->nullable();
            $table->text('current_address')->nullable();
            $table->text('id_card_address')->nullable();

            // --- Informasi Kontak & Keluarga ---
            $table->string('npwp_number')->nullable();
            $table->string('family_card_number')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            
            // --- Informasi Pekerjaan ---
            $table->string('employee_id')->unique()->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('location')->nullable();
            $table->date('join_date')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('direct_supervisor_name')->nullable();
            $table->string('direct_supervisor_position')->nullable();

            // --- Informasi Bank ---
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder_name')->nullable();

            // --- Kontak Darurat ---
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relation')->nullable();

            $table->timestamps();
        });

        // Tabel terpisah untuk riwayat pendidikan
        Schema::create('employee_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('level'); // SD, SMP, SMA, S1, S2, S3
            $table->string('institution_name');
            $table->string('major')->nullable();
            $table->year('graduation_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_education');
    }
};
