@extends('layouts.admin')

@section('title', 'Data Pelamar')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Data Pelamar</h1>
        <a href="#" class="px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
            <i class="fas fa-file-excel mr-2"></i> Export ke CSV
        </a>
    </div>

    <!-- Filter Form -->
    <div class="mb-6 bg-white p-4 rounded-md shadow-sm">
        <form action="{{ route('admin.applicants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="job_id" class="block text-sm font-medium text-gray-700">Filter Posisi</label>
                <select name="job_id" id="job_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Lowongan</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                            {{ $job->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Filter Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2 flex items-end space-x-2">
                <button type="submit" class="w-full md:w-auto px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Filter</button>
                <a href="{{ route('admin.applicants.index') }}" class="w-full md:w-auto px-6 py-2 text-center text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Pelamar -->
    <div class="bg-white rounded-lg shadow-md overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Nama Pelamar</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Posisi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Aksi Cepat</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($applications as $app)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium">{{ $app->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $app->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $app->job->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.applicants.updateStatus', $app) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $app->status == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                             <form action="{{ route('admin.applicants.addToTalentPool', $app) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-yellow-600 hover:text-yellow-800" title="Masukkan ke Talent Pool">
                                    <i class="fas fa-star"></i> Shortlist
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="#" class="text-blue-600 hover:text-blue-800">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">Tidak ada data pelamar yang cocok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $applications->links() }}
    </div>
@endsection
