@extends('layouts.admin')

@section('title', 'Kelola Lowongan')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Lowongan</h1>
        <a href="{{ route('admin.jobs.create') }}" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Tambah Lowongan Baru
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Judul Posisi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Lokasi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($jobs as $job)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $job->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $job->location }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($job->is_active)
                                <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-4">
                            <a href="{{ route('admin.jobs.edit', $job) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menghapus lowongan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-500">Belum ada data lowongan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
