@extends('layouts.admin')

@section('title', 'Detail Lowongan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.jobs.index') }}" class="text-sm text-gray-600">&larr; Kembali ke daftar lowongan</a>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold">{{ $job->title }}</h1>
            <div class="text-sm text-gray-500">{{ $job->location ?? '-' }} • {{ $job->employment_type ?? '-' }}</div>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">Pelamar</div>
            <div class="text-3xl font-bold">{{ $job->applications->count() }}</div>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold">Deskripsi Pekerjaan</h3>
        <div class="mt-2 text-sm text-gray-700">{!! nl2br(e($job->jobdesk)) !!}</div>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold">Daftar Pelamar</h3>
        @if($job->applications->isEmpty())
            <div class="text-sm text-gray-500 mt-3">Belum ada pelamar untuk lowongan ini.</div>
        @else
            <div class="mt-3 bg-gray-50 rounded-md p-3">
                <ul class="divide-y divide-gray-200">
                    @foreach($job->applications as $app)
                        <li class="py-3 flex items-center justify-between">
                            <div>
                                <div class="font-medium">{{ $app->applicant_name ?? ($app->user->name ?? '—') }}</div>
                                <div class="text-sm text-gray-500">{{ $app->applicant_email ?? ($app->user->email ?? '—') }}</div>
                            </div>
                            <div class="text-right space-x-3">
                                <a href="{{ route('admin.applicants.show', $app) }}" class="text-blue-600 hover:text-blue-800 text-sm">Detail</a>
                                <span class="text-sm text-gray-600">{{ $app->status }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection