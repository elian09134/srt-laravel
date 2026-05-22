@extends('layouts.admin')

@section('title', 'Target Mitra - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Target Mitra</h1>
            <p class="text-sm text-slate-500 mt-1">Atur target pendaftaran kandidat untuk setiap mitra (M28, dll).</p>
        </div>
    </div>

    @foreach($partners as $partner)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold">
                        {{ substr($partner->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $partner->name }}</h2>
                        <p class="text-sm text-slate-500">{{ $partner->email }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @php
                    $yearlyTargets = $partner->partnerTargets->where('month', null);
                    $monthlyTargets = $partner->partnerTargets->where('month', '!=', null)->sortBy('month');
                @endphp

                @if($yearlyTargets->isEmpty() && $monthlyTargets->isEmpty())
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                            <i class="fas fa-bullseye text-2xl text-slate-400"></i>
                        </div>
                        <p class="text-slate-500">Belum ada target untuk mitra ini.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($yearlyTargets as $target)
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-slate-700">Target Tahunan {{ $target->year }}</span>
                                    <form action="{{ route('admin.partner-targets.destroy', $target) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus target ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($target->target_count) }} <span class="text-sm font-normal text-slate-500">kandidat</span></p>
                            </div>
                        @endforeach

                        @foreach($monthlyTargets as $target)
                            <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-slate-700">{{ $months[$target->month] }} {{ $target->year }}</span>
                                    <form action="{{ route('admin.partner-targets.destroy', $target) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus target ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($target->target_count) }} <span class="text-sm font-normal text-slate-500">kandidat</span></p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Add Target Form -->
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Tambah Target Baru</h3>
                    <form action="{{ route('admin.partner-targets.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $partner->id }}">

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Tahun</label>
                            <select name="year" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                @for($y = $currentYear; $y <= $currentYear + 2; $y++)
                                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Bulan (opsional)</label>
                            <select name="month" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="">-- Target Tahunan --</option>
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ $num == now()->month ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Jumlah Target</label>
                            <input type="number" name="target_count" required min="1"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="Contoh: 20">
                        </div>

                        <button type="submit"
                                class="w-full px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-plus mr-1"></i> Simpan Target
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
