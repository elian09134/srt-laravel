@extends('layouts.admin')

@section('title', 'Target Mitra - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Target Mitra</h1>
        <p class="text-sm text-slate-500 mt-1">Atur target pendaftaran kandidat per posisi untuk setiap mitra.</p>
    </div>

    @foreach($partners as $partner)
        @php
            $yearlyTargets = $partner->partnerTargets->where('month', null);
            $monthlyTargets = $partner->partnerTargets->where('month', '!=', null)->sortBy('month');
        @endphp

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
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
                @if($yearlyTargets->isNotEmpty())
                    <div class="flex flex-wrap gap-3 mb-6">
                        @foreach($yearlyTargets as $target)
                            <div class="bg-slate-50 rounded-lg px-4 py-3 border border-slate-200 flex items-center gap-4">
                                <div>
                                    <span class="text-xs font-semibold text-slate-500 uppercase">Tahunan {{ $target->year }}</span>
                                    <p class="text-xl font-bold text-purple-600">{{ number_format($target->target_count) }} <span class="text-sm font-normal text-slate-500">kandidat</span></p>
                                </div>
                                <form action="{{ route('admin.partner-targets.destroy', $target) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus target tahunan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 text-sm p-1"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($monthlyTargets->isEmpty())
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                            <i class="fas fa-bullseye text-2xl text-slate-400"></i>
                        </div>
                        <p class="text-slate-500">Belum ada target bulanan untuk mitra ini.</p>
                    </div>
                @else
                    <div class="flex gap-4 overflow-x-auto pb-4 snap-x">
                        @foreach($monthlyTargets as $target)
                            @php
                                $targetActual = \App\Models\User::where('referral_source', $partner->name)
                                    ->whereYear('created_at', $target->year)
                                    ->whereMonth('created_at', $target->month)
                                    ->count();
                                $targetPct = $target->target_count > 0 ? round(($targetActual / $target->target_count) * 100) : 0;
                            @endphp
                            <div class="min-w-[260px] max-w-[260px] bg-slate-50 rounded-xl border border-slate-200 flex flex-col snap-start">
                                <div class="px-4 py-3 border-b border-slate-200 bg-white rounded-t-xl">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="text-sm font-bold text-slate-800">{{ $months[$target->month] }} {{ $target->year }}</h3>
                                        <form action="{{ route('admin.partner-targets.destroy', $target) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Hapus target bulan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-400 hover:text-red-600 text-xs"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                        <span>Target: <strong class="text-slate-700">{{ $target->target_count }}</strong></span>
                                        <span>Realisasi: <strong class="{{ $targetPct >= 100 ? 'text-green-600' : 'text-amber-600' }}">{{ $targetActual }}</strong></span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        @php
                                            $barColor = $targetPct >= 100 ? 'bg-green-500' : ($targetPct >= 50 ? 'bg-amber-500' : 'bg-blue-500');
                                        @endphp
                                        <div class="h-full rounded-full transition-all {{ $barColor }}" style="width: {{ min($targetPct, 100) }}%"></div>
                                    </div>
                                    <span class="text-xs {{ $targetPct >= 100 ? 'text-green-600 font-bold' : 'text-slate-400' }} mt-0.5 block">{{ $targetPct }}%</span>
                                </div>

                                <div class="p-3 space-y-2 flex-1">
                                    @if($target->positions->isEmpty())
                                        <p class="text-xs text-slate-400 text-center py-4">Belum ada target posisi</p>
                                    @else
                                        @foreach($target->positions as $posTarget)
                                            @php
                                                $progress = $positionProgress[$target->id][$posTarget->id] ?? ['actual' => 0, 'pct' => 0];
                                                $posBarColor = $progress['pct'] >= 100 ? 'bg-green-500' : ($progress['pct'] >= 50 ? 'bg-amber-500' : ($progress['pct'] > 0 ? 'bg-blue-500' : 'bg-slate-200'));
                                            @endphp
                                            <div class="bg-white rounded-lg p-3 border border-slate-200 shadow-sm">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="text-xs font-semibold text-slate-700 truncate">{{ $posTarget->position }}</span>
                                                    <form action="{{ route('admin.partner-targets.positions.destroy', $posTarget) }}" method="POST" class="inline"
                                                          onsubmit="return confirm('Hapus target posisi ini?')">
                                                        @csrf @method('DELETE')
                                                        <button class="text-red-300 hover:text-red-500 text-xs"><i class="fas fa-times"></i></button>
                                                    </form>
                                                </div>
                                                <div class="flex items-center justify-between text-xs text-slate-500 mb-1">
                                                    <span>{{ $progress['actual'] }}/{{ $posTarget->target_count }}</span>
                                                    <span class="font-bold {{ $progress['pct'] >= 100 ? 'text-green-600' : ($progress['pct'] >= 50 ? 'text-amber-600' : 'text-slate-500') }}">{{ $progress['pct'] }}%</span>
                                                </div>
                                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full rounded-full transition-all {{ $posBarColor }}" style="width: {{ min($progress['pct'], 100) }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="p-3 border-t border-slate-200 bg-white rounded-b-xl">
                                    <p class="text-xs text-slate-400 text-center">Target posisi diatur saat menambah target</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6 pt-6 border-t border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Tambah Target Bulanan Baru</h3>
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
                            <label class="block text-xs font-medium text-slate-600 mb-1">Bulan</label>
                            <select name="month" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="">-- Pilih Bulan --</option>
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ $num == now()->month ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-4">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-medium text-slate-600 mb-1">Target Posisi</label>
                                <button type="button" onclick="addPositionRow()"
                                        class="text-xs text-purple-600 hover:text-purple-800 font-medium">
                                    <i class="fas fa-plus mr-0.5"></i> Tambah Posisi
                                </button>
                            </div>
                            <div id="position-rows" class="space-y-2">
                                <div class="position-row flex gap-2 items-start">
                                    <select name="positions[0][position]"
                                            class="flex-1 px-2 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <option value="">-- Pilih Posisi --</option>
                                        @foreach($availablePositions as $pos)
                                            <option value="{{ $pos }}">{{ $pos }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="positions[0][target_count]" min="1" placeholder="Target"
                                           class="w-20 px-2 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <button type="button" onclick="removePositionRow(this)"
                                            class="text-red-400 hover:text-red-600 text-sm p-1.5">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Opsional: atur target per posisi untuk mitra ini.</p>
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

@push('scripts')
<script>
let positionIndex = 1;

function addPositionRow() {
    const container = document.getElementById('position-rows');
    const template = container.querySelector('.position-row');
    const newRow = template.cloneNode(true);

    newRow.querySelectorAll('[name]').forEach(el => {
        el.name = el.name.replace(/\[\d+\]/, '[' + positionIndex + ']');
        el.value = '';
    });

    container.appendChild(newRow);
    positionIndex++;
}

function removePositionRow(btn) {
    const container = document.getElementById('position-rows');
    const rows = container.querySelectorAll('.position-row');
    if (rows.length > 1) {
        btn.closest('.position-row').remove();
    }
}
</script>
@endpush
