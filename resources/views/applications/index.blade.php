@extends('layouts.app')

@section('title', 'Riwayat Lamaran')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Riwayat Lamaran Saya</h1>

    @if($applications->isEmpty())
        <div class="bg-white p-6 rounded shadow text-gray-600">Anda belum mengirimkan lamaran.</div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach($applications as $app)
                    <li class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900">{{ $app->job->title ?? 'Lowongan Dihapus' }}</div>
                            <div class="text-sm text-gray-500">{{ $app->job->location ?? '-' }} • {{ $app->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-600">Status</div>
                            <div class="mt-1 font-semibold @if(in_array($app->status, ['Diterima','Offering Letter'])) text-green-600 @elseif(in_array($app->status, ['Tidak Lanjut','Ditolak'])) text-red-600 @else text-gray-800 @endif">{{ $app->status }}</div>
                            <a href="{{ route('admin.applicants.show', $app) }}" class="mt-2 inline-block text-sm text-blue-600">Lihat Detail</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
