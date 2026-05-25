@extends('layouts.admin')

@section('title', 'Generate Akun Karyawan Baru')

@section('content')
    <a href="{{ route('admin.employees.index') }}" class="text-slate-400 hover:text-indigo-600 text-sm inline-flex items-center transition-colors mb-2">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
    <h1 class="text-xl font-semibold text-slate-800 mb-6">Generate Akun Karyawan Baru</h1>

    <form action="{{ route('admin.employees.store') }}" method="POST" class="bg-white rounded-xl border border-slate-100 p-6 max-w-lg">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap Karyawan</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Karyawan</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                 @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mt-8 pt-6 border-t">
            <button type="submit" class="w-full px-6 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                Generate Akun & Password
            </button>
        </div>
    </form>
@endsection
