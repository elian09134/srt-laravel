@extends('layouts.admin')

@section('title', 'Talent Pool')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Talent Pool</h1>
            <p class="text-sm text-slate-500 mt-1">Database kandidat potensial untuk masa depan perusahaan</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white rounded-lg border border-slate-100 px-4 py-2.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <div>
                    <div class="text-[10px] font-medium text-slate-400 uppercase">Total Talent</div>
                    <div class="text-sm font-semibold text-slate-800">{{ $items->total() }} Kandidat</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden mb-8">
        <div class="px-5 py-4 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-sm font-semibold text-slate-800 flex items-center">
                <span class="w-1 h-5 bg-indigo-500 rounded-full mr-2.5"></span>
                Daftar Kandidat
            </h2>
            <form action="{{ route('admin.talent_pool.index') }}" method="GET" class="relative w-full md:w-72">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-9 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:bg-white focus:border-indigo-300 focus:ring-2 focus:ring-indigo-50 transition-all"
                       placeholder="Cari nama, email, keahlian...">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.talent_pool.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-red-500">
                        <i class="fas fa-times-circle"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 font-medium">
                        <th class="px-5 py-3.5">Nama Kandidat</th>
                        <th class="px-5 py-3.5">Posisi Terakhir</th>
                        <th class="px-5 py-3.5">Kontak</th>
                        <th class="px-5 py-3.5">Keahlian</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-sm font-medium mr-3 shrink-0 border border-slate-200">
                                        {{ substr($item->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-800">{{ $item->user->name ?? 'Pengguna Terhapus' }}</div>
                                        <div class="text-xs text-slate-400">{{ $item->user->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-500">
                                {{ $item->last_position ?? '-' }}
                            </td>
                            <td class="px-5 py-4">
                                @if($item->user->profile && $item->user->profile->phone_number)
                                    <span class="text-xs text-slate-500">{{ $item->user->profile->phone_number }}</span>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if($item->user->profile && $item->user->profile->skills)
                                    <div class="flex flex-wrap gap-1 max-w-[200px]">
                                        @foreach(explode(',', $item->user->profile->skills) as $skill)
                                            <span class="inline-flex px-1.5 py-0.5 rounded text-[10px] font-medium bg-slate-50 text-slate-500 border border-slate-100">{{ trim($skill) }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('admin.talent_pool.show', $item) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors">
                                    Detail <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center text-slate-400">
                                <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-address-book text-2xl text-slate-200"></i>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Talent pool masih kosong</p>
                                <p class="text-xs mt-1">Tambahkan pelamar ke talent pool dari halaman pelamar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($items, 'links'))
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection
