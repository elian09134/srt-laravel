@extends('layouts.admin')

@section('title', isset($job) ? 'Edit Lowongan' : 'Tambah Lowongan Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        {{ isset($job) ? 'Edit Lowongan' : 'Tambah Lowongan Baru' }}
    </h1>

    <form action="{{ isset($job) ? route('admin.jobs.update', $job) : route('admin.jobs.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md space-y-6">
        @csrf
        @if(isset($job))
            @method('PUT')
        @endif

        <div>
            <label for="fptk_id" class="block text-sm font-medium text-gray-700">Link ke FPTK (Opsional)</label>
            <select name="fptk_id" id="fptk_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Pilih FPTK (jika ada) --</option>
                @foreach($fptks ?? [] as $fptk)
                    <option value="{{ $fptk->id }}" @if(old('fptk_id', $job->fptk_id ?? '') == $fptk->id) selected @endif>
                        FPTK #{{ $fptk->id }} - {{ $fptk->position }} ({{ $fptk->qty }} orang) - {{ $fptk->user->name }}
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">Link job posting ini dengan FPTK yang sudah disetujui agar pengaju dapat melihat jumlah pelamar</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Posisi Lowongan</label>
                <input type="text" name="title" id="title" value="{{ old('title', $job->title ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="location" id="location" value="{{ old('location', $job->location ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pekerjaan</label>
                <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option @if(old('type', $job->type ?? '') == 'Full Time') selected @endif>Full Time</option>
                    <option @if(old('type', $job->type ?? '') == 'Part Time') selected @endif>Part Time</option>
                    <option @if(old('type', $job->type ?? '') == 'Contract') selected @endif>Contract</option>
                    <option @if(old('type', $job->type ?? '') == 'Internship') selected @endif>Internship</option>
                </select>
            </div>
            <div>
                <label for="salary_range" class="block text-sm font-medium text-gray-700">Gaji (Opsional)</label>
                <input type="text" name="salary_range" id="salary_range" value="{{ old('salary_range', $job->salary_range ?? '') }}" placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        <div>
            <label for="jobdesk" class="block text-sm font-medium text-gray-700">Job Deskripsi</label>
            <textarea name="jobdesk" id="jobdesk" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('jobdesk', $job->jobdesk ?? '') }}</textarea>
        </div>

        <div>
            <label for="requirement" class="block text-sm font-medium text-gray-700">Requirement (satu per baris)</label>
            <textarea name="requirement" id="requirement" rows="6" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('requirement', isset($job) ? json_decode($job->requirement, true) ? implode("\n", json_decode($job->requirement, true)) : '' : '') }}</textarea>
        </div>

        <div>
            <label for="benefits" class="block text-sm font-medium text-gray-700">Benefits (Opsional, satu per baris)</label>
            <textarea name="benefits" id="benefits" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('benefits', isset($job) ? json_decode($job->benefits, true) ? implode("\n", json_decode($job->benefits, true)) : '' : '') }}</textarea>
        </div>

        <div class="pt-6 border-t">
            <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                {{ isset($job) ? 'Simpan Perubahan' : 'Simpan Lowongan' }}
            </button>
            <a href="{{ route('admin.jobs.index') }}" class="ml-4 text-gray-600">Batal</a>
        </div>
    </form>
@endsection
