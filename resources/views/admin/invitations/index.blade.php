@extends('layouts.admin')

@section('title', 'Undang Karyawan Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Undang Karyawan Baru</h1>

    <!-- Form Buat Undangan -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-semibold mb-4">Buat Undangan</h2>
        <form action="{{ route('admin.invitations.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap Karyawan</label>
                    <input type="text" name="full_name" id="full_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                    <input type="tel" name="phone_number" id="phone_number" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="text-right">
                    <button type="submit" class="w-full px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Buat Kode Undangan</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Daftar Undangan yang Sudah Ada -->
    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Kode Undangan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">QR Code</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($invitations as $invitation)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $invitation->full_name }}</td>
                        <td class="px-6 py-4 font-mono text-sm bg-gray-100 rounded">{{ $invitation->invitation_code }}</td>
                        <td class="px-6 py-4">
                            <img src="{{ $qrcodes[$invitation->id] }}" alt="QR Code" class="w-24 h-24">
                        </td>
                        <td class="px-6 py-4">
                            @if($invitation->used_at)
                                <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Sudah Digunakan</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Belum Digunakan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-500">Belum ada undangan yang dibuat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
