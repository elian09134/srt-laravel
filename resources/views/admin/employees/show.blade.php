@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')
    <a href="{{ route('admin.employees.index') }}" class="text-blue-600 hover:underline mb-6 inline-block"><i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Karyawan</a>
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Detail Karyawan</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <!-- Informasi Pribadi -->
        <div class="border-b pb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pribadi & Kontak</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div><strong class="block text-gray-500">Nama Lengkap:</strong> {{ $employee->user->name }}</div>
                <div><strong class="block text-gray-500">Email:</strong> {{ $employee->user->email }}</div>
                <div><strong class="block text-gray-500">Nomor HP:</strong> {{ $employee->user->profile->phone_number ?? '-' }}</div>
                <div><strong class="block text-gray-500">Tempat, Tanggal Lahir:</strong> {{ $employee->place_of_birth }}, {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d F Y') }}</div>
                <div><strong class="block text-gray-500">Jenis Kelamin:</strong> {{ $employee->gender }}</div>
                <div><strong class="block text-gray-500">Agama:</strong> {{ $employee->religion }}</div>
                <div><strong class="block text-gray-500">Status Perkawinan:</strong> {{ $employee->marital_status }}</div>
                <div><strong class="block text-gray-500">NIK KTP:</strong> {{ $employee->id_card_number }}</div>
                <div class="md:col-span-2"><strong class="block text-gray-500">Domisili Saat Ini:</strong> {{ $employee->current_address }}</div>
            </div>
        </div>

        <!-- Informasi Pekerjaan -->
        <div class="mt-6 border-b pb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pekerjaan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div><strong class="block text-gray-500">NIK Karyawan:</strong> {{ $employee->employee_id }}</div>
                <div><strong class="block text-gray-500">Status Kepegawaian:</strong> {{ $employee->employment_status }}</div>
                <div><strong class="block text-gray-500">Tanggal Bergabung:</strong> {{ \Carbon\Carbon::parse($employee->join_date)->format('d F Y') }}</div>
                <div><strong class="block text-gray-500">Divisi:</strong> {{ $employee->department }}</div>
                <div><strong class="block text-gray-500">Jabatan:</strong> {{ $employee->position }}</div>
                <div><strong class="block text-gray-500">Lokasi:</strong> {{ $employee->location }}</div>
            </div>
        </div>

        <!-- Riwayat Pendidikan -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Pendidikan</h2>
            <div class="space-y-4">
                @forelse ($employee->user->educationHistory as $edu)
                    <div class="p-4 border rounded-md">
                        <p class="font-bold">{{ $edu->level }} - {{ $edu->institution_name }}</p>
                        <p class="text-sm text-gray-600">{{ $edu->major }} (Lulus: {{ $edu->graduation_year }})</p>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada data riwayat pendidikan.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
