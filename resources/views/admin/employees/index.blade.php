@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Data Karyawan</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen data karyawan dan akun</p>
        </div>
        <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Generate Akun Karyawan
        </a>
    </div>

    @if(session('generated_credentials'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4" role="alert">
            <h3 class="font-medium text-emerald-800 text-sm">Akun Karyawan Berhasil Dibuat!</h3>
            <p class="text-sm text-emerald-700 mt-1">Silakan berikan informasi login berikut kepada karyawan:</p>
            <div class="mt-2 font-mono bg-emerald-100 rounded-lg p-3 text-sm text-emerald-800">
                <p><strong>Email:</strong> {{ session('generated_credentials')['email'] }}</p>
                <p><strong>Password Sementara:</strong> {{ session('generated_credentials')['password'] }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 font-medium">
                        <th class="px-5 py-3.5">Nama Karyawan</th>
                        <th class="px-5 py-3.5">Departemen</th>
                        <th class="px-5 py-3.5">Jabatan</th>
                        <th class="px-5 py-3.5">Lokasi Penempatan</th>
                        <th class="px-5 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($employees as $employee)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="text-sm font-medium text-slate-800">{{ $employee->user->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $employee->employee_id ?? 'Belum diisi' }}</div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-500">{{ $employee->department ?? '-' }}</td>
                            <td class="px-5 py-4 text-sm text-slate-500">{{ $employee->position ?? '-' }}</td>
                            <td class="px-5 py-4 text-sm text-slate-500">{{ $employee->location ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.employees.show', $employee) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 transition-colors">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <i class="fas fa-users text-3xl text-slate-200 mb-3"></i>
                                <p class="text-sm font-medium text-slate-500">Belum ada data karyawan</p>
                                <p class="text-xs mt-1">Generate akun karyawan untuk mulai menambahkan data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($employees, 'links'))
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
@endsection
