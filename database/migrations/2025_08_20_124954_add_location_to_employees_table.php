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
            $table->string('nickname')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable(); // Jenis Kelamin
            $table->string('religion')->nullable(); // Agama
            $table->string('marital_status')->nullable(); // Status Perkawinan
            $table->string('ptkp_status')->nullable(); // Status PTKP
            $table->string('id_card_number')->unique()->nullable(); // NIK KTP
            $table->text('current_address')->nullable(); // Domisili saat ini
            $table->text('id_card_address')->nullable(); // Alamat KTP

            // --- Informasi Kontak & Keluarga ---
            $table->string('npwp_number')->nullable(); // NPWP (opsional)
            $table->string('family_card_number')->nullable(); // Nomor KK
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable(); // Nama suami/istri (opsional)
            
            // --- Informasi Pekerjaan ---
            $table->string('employee_id')->unique()->nullable(); // NIK Karyawan
            $table->string('department')->nullable(); // Divisi
            $table->string('position')->nullable(); // Jabatan
            $table->string('location')->nullable(); // Lokasi Penempatan
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
            $table->string('major')->nullable(); // Jurusan
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
