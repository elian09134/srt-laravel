@extends('m28.layouts.admin')

@section('title', 'Detail Kandidat')

@section('content')
<div class="mb-6">
    <a href="{{ route('m28.candidates.index') }}" class="text-slate-500 hover:text-purple-600 text-sm mb-2 inline-flex items-center transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Detail Kandidat</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="h-24 bg-gradient-to-r from-purple-600 to-indigo-700"></div>
            <div class="px-6 pb-6">
                <div class="relative flex justify-center -mt-12 mb-4">
                    @if($candidate->profile && $candidate->profile->photo_path)
                        <img class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white shadow-md" src="{{ asset('storage/' . $candidate->profile->photo_path) }}" alt="Foto">
                    @else
                        <div class="h-24 w-24 rounded-2xl bg-purple-100 ring-4 ring-white shadow-md flex items-center justify-center text-purple-600 font-bold text-2xl border border-purple-100">
                            {{ substr($candidate->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-slate-800">{{ $candidate->name }}</h2>
                    <p class="text-sm text-slate-500">{{ $candidate->email }}</p>
                </div>

                @php
                    $rawPhone = optional($candidate->profile)->phone_number;
                    $waNumber = null;
                    if ($rawPhone) {
                        $num = preg_replace('/\D+/', '', $rawPhone);
                        if (strlen($num) > 0 && $num[0] === '0') $num = '62' . substr($num, 1);
                        $waNumber = $num;
                    }
                @endphp

                <div class="mt-6 flex flex-col gap-2">
                    @if($waNumber)
                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode("Halo $candidate->name, saya dari tim M28 ingin menindaklanjuti lamaran Anda.") }}" target="_blank" class="flex items-center justify-center px-4 py-2.5 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all font-medium border-b-4 border-green-700 active:border-b-0 active:translate-y-1 shadow-md">
                            <i class="fab fa-whatsapp mr-2 text-lg"></i> Hubungi WhatsApp
                        </a>
                    @endif
                    @if(optional($candidate->profile)->cv_path)
                        <a href="{{ asset('storage/' . $candidate->profile->cv_path) }}" target="_blank" class="flex items-center justify-center px-4 py-2.5 bg-purple-50 text-purple-600 rounded-xl hover:bg-purple-100 transition-all font-medium border border-purple-100 shadow-sm">
                            <i class="fas fa-file-pdf mr-2"></i> Lihat CV / Resume
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if($candidate->profile)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Pribadi</h3>
            <div class="space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">No. HP</span>
                    <span class="font-medium text-slate-800">{{ $candidate->profile->phone_number ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Tgl. Lahir</span>
                    <span class="font-medium text-slate-800">{{ $candidate->profile->date_of_birth ? \Carbon\Carbon::parse($candidate->profile->date_of_birth)->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Pendidikan</span>
                    <span class="font-medium text-slate-800">{{ $candidate->profile->education_level ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Institusi</span>
                    <span class="font-medium text-slate-800">{{ $candidate->profile->institution ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Jurusan</span>
                    <span class="font-medium text-slate-800">{{ $candidate->profile->major ?? '-' }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="lg:col-span-2 space-y-6">
        @foreach($candidate->applications as $application)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="border-b border-slate-50 bg-slate-50/50 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-800">Lamaran: {{ $application->job?->title ?? '-' }}</h3>
            </div>
            <div class="p-6 space-y-6">
                @if($application->cover_letter)
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Surat Lamaran</h4>
                    <div class="p-4 bg-slate-50 rounded-2xl text-sm text-slate-700 whitespace-pre-wrap border border-slate-100">
                        {{ $application->cover_letter }}
                    </div>
                </div>
                @endif

                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Timeline Status</h4>
                    <div class="relative pl-6 space-y-4 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-100">
                        @php
                            $steps = ['Baru', 'Lamaran Dilihat', 'Psikotest', 'Wawancara HR', 'Wawancara User', 'Offering Letter', 'Shortlist', 'Diterima', 'Tidak Lanjut'];
                            $currentIndex = array_search($application->status, $steps);
                            if ($currentIndex === false) $currentIndex = -1;
                        @endphp
                        @foreach($steps as $i => $step)
                            @php
                                $state = 'future';
                                if ($i < $currentIndex) $state = 'done';
                                if ($i === $currentIndex) $state = 'current';
                            @endphp
                            @if($state !== 'future' || $i <= $currentIndex + 1)
                            <div class="relative">
                                <div class="absolute -left-[20px] top-1 h-3 w-3 rounded-full border-2 border-white
                                    {{ $state === 'done' ? 'bg-green-500 shadow-[0_0_0_2px_#22c55e33]' : ($state === 'current' ? 'bg-purple-600 animate-pulse ring-4 ring-purple-100 shadow-[0_0_0_2px_#9333ea33]' : 'bg-slate-200') }}">
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-sm {{ $state === 'current' ? 'text-slate-800' : 'text-slate-500' }}">{{ $step }}</span>
                                    @php $h = $application->statusHistories->firstWhere('status', $step); @endphp
                                    @if($h)
                                        <span class="text-[10px] text-slate-400">{{ optional($h->created_at)->format('d M, H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="pt-2">
                    <span class="text-xs font-bold text-slate-400 uppercase">Status Saat Ini:</span>
                    @php
                        $status = $application->status;
                        $colors = ['Baru' => 'bg-blue-100 text-blue-700', 'Lamaran Dilihat' => 'bg-yellow-100 text-yellow-700', 'Psikotest' => 'bg-amber-100 text-amber-700', 'Wawancara HR' => 'bg-indigo-100 text-indigo-700', 'Wawancara User' => 'bg-purple-100 text-purple-700', 'Shortlist' => 'bg-teal-100 text-teal-700', 'Offering Letter' => 'bg-emerald-100 text-emerald-700', 'Diterima' => 'bg-green-100 text-green-700', 'Tidak Lanjut' => 'bg-red-100 text-red-700'];
                        $badgeClass = $colors[$status] ?? 'bg-slate-100 text-slate-700';
                    @endphp
                    <span class="ml-2 inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">{{ $status }}</span>
                </div>
            </div>
        </div>
        @endforeach

        @if($candidate->workExperiences->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="border-b border-slate-50 bg-slate-50/50 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-800">Riwayat Pekerjaan</h3>
            </div>
            <div class="p-6 space-y-4">
                @foreach($candidate->workExperiences as $exp)
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $exp->company_name }}</h4>
                            @if($exp->duration)
                                <p class="text-xs text-slate-500">{{ $exp->duration }}</p>
                            @endif
                            @if($exp->job_description)
                                <p class="text-sm text-slate-600 mt-1">{{ $exp->job_description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
