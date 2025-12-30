@extends('layouts.admin')

@section('title', 'Talent Pool')

@section('content')
    <div class="bg-white rounded-xl p-6 shadow">
        <h3 class="text-lg font-semibold mb-4">Talent Pool</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="text-left text-sm text-gray-600 border-b">
                        <th class="py-3 px-2">#</th>
                        <th class="py-3 px-2">Nama</th>
                        <th class="py-3 px-2">Email</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2">Preferensi Pekerjaan</th>
                        <th class="py-3 px-2">Dibuat</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse($items as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-2 align-top">{{ $item->id }}</td>
                            <td class="py-3 px-2 align-top">
                                <a href="{{ route('admin.talent_pool.show', $item) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $item->user->name ?? '—' }}
                                </a>
                            </td>
                            <td class="py-3 px-2 align-top">{{ $item->user->email ?? '—' }}</td>
                            <td class="py-3 px-2 align-top"><span class="px-3 py-1 rounded-full text-xs {{ $item->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">{{ $item->status }}</span></td>
                            <td class="py-3 px-2 align-top">
                                @php
                                    $workExps = $item->user->workExperiences ?? collect();
                                    if ($workExps->count() > 0) {
                                        $jobDesc = $workExps->first()->job_description;
                                        $position = $jobDesc ? explode(' — ', $jobDesc)[0] : '-';
                                        echo Str::limit($position, 80);
                                    } else {
                                        echo Str::limit($item->job_preferences ?? '—', 80);
                                    }
                                @endphp
                            </td>
                            <td class="py-3 px-2 align-top">{{ $item->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">Tidak ada kandidat di talent pool.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $items->links() }}</div>
    </div>
@endsection
