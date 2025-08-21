@extends('layouts.admin')

@section('title', 'Generate Akun Karyawan Baru')

@section('content')
    <a href="{{ route('admin.employees.index') }}" class="text-blue-600 hover:underline mb-6 inline-block"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Generate Akun Karyawan Baru</h1>

    <form action="{{ route('admin.employees.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md max-w-lg">
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
            <button type="submit" class="w-full px-6 py-3 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Generate Akun & Password
            </button>
        </div>
    </form>
@endsection
