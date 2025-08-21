@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Data Karyawan</h1>
        <a href="{{ route('admin.employees.create') }}" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Generate Akun Karyawan
        </a>
    </div>

    <!-- Menampilkan Kredensial Baru (jika ada) -->
    @if(session('generated_credentials'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <h3 class="font-bold text-lg">Akun Karyawan Berhasil Dibuat!</h3>
            <p>Silakan berikan informasi login berikut kepada karyawan:</p>
            <div class="mt-2 font-mono bg-green-200 p-2 rounded">
                <p><strong>Email:</strong> {{ session('generated_credentials')['email'] }}</p>
                <p><strong>Password Sementara:</strong> {{ session('generated_credentials')['password'] }}</p>
            </div>
        </div>
    @endif

    <!-- Tabel Data Karyawan -->
    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Nama Karyawan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Departemen</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Jabatan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Lokasi Penempatan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($employees as $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium">{{ $employee->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $employee->employee_id ?? 'Belum diisi' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->department ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->position ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->location ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.employees.show', $employee) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">Belum ada data karyawan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
