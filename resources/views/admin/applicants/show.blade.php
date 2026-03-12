@extends('layouts.admin')

@section('title', 'Detail Pelamar')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.applicants.index') }}" class="text-slate-500 hover:text-blue-600 text-sm mb-2 inline-flex items-center transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Detail Pelamar</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
    <!-- Left Column: Profile & Summary -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="h-24 bg-gradient-to-r from-blue-600 to-indigo-700"></div>
            <div class="px-6 pb-6">
                <div class="relative flex justify-center -mt-12 mb-4">
                    @if($application->user && $application->user->profile && $application->user->profile->photo_path)
                        <img class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white shadow-md" src="{{ asset('storage/' . $application->user->profile->photo_path) }}" alt="Foto">
                    @else
                        <div class="h-24 w-24 rounded-2xl bg-slate-100 ring-4 ring-white shadow-md flex items-center justify-center text-slate-400 font-bold text-2xl border border-slate-100">
                            {{ substr($application->user->name ?? $application->applicant_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <div class="text-center">
                    <h2 class="text-xl font-bold text-slate-800">{{ $application->user->name ?? $application->applicant_name ?? 'Pengguna Terhapus' }}</h2>
                    <p class="text-sm text-slate-500">{{ $application->user->email ?? $application->applicant_email ?? '—' }}</p>
                </div>

                @php
                    $rawPhone = $application->applicant_phone ?? optional($application->user->profile)->phone_number ?? null;
                    $waNumber = null;
                    if ($rawPhone) {
                        $num = preg_replace('/\D+/', '', $rawPhone);
                        if (strlen($num) > 0 && $num[0] === '0') $num = '62' . substr($num, 1);
                        $waNumber = $num;
                    }
                    $waMessage = '';
                    if ($waNumber) {
                        $name = $application->applicant_name ?? ($application->user->name ?? 'Kandidat');
                        $waMessage = urlencode("Halo $name, saya dari tim Recruitment TERANG By SRT ingin berdiskusi mengenai lamaran Anda.");
                    }
                @endphp

                <div class="mt-6 flex flex-col gap-2">
                    @if($waNumber)
                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" class="flex items-center justify-center px-4 py-2.5 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-all font-medium border-b-4 border-green-700 active:border-b-0 active:translate-y-1 shadow-md">
                            <i class="fab fa-whatsapp mr-2 text-lg"></i> Hubungi WhatsApp
                        </a>
                    @endif
                    
                    @php
                        $snapshot = json_decode($application->snapshot_data, true) ?? [];
                        $cvPath = $snapshot['cv_path'] ?? optional($application->user->profile)->cv_path;
                    @endphp

                    @if($cvPath)
                        <a href="{{ asset('storage/' . $cvPath) }}" target="_blank" class="flex items-center justify-center px-4 py-2.5 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-all font-medium border border-blue-100 shadow-sm">
                            <i class="fas fa-file-pdf mr-2"></i> Lihat CV / Resume
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Status Saat Ini</h3>
            
            <div class="flex items-center justify-between mb-4">
                 @php
                    $statusColors = [
                        'Baru' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'Diterima' => 'bg-green-100 text-green-700 border-green-200',
                        'Ditolak' => 'bg-red-100 text-red-700 border-red-200',
                        'Shortlist' => 'bg-purple-100 text-purple-700 border-purple-200',
                        'Offering' => 'bg-amber-100 text-amber-700 border-amber-200',
                    ];
                    $badgeClass = $statusColors[$application->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                    {{ strtoupper($application->status) }}
                </span>
                <span class="text-[10px] text-slate-400 font-medium">Updated: {{ $application->updated_at->diffForHumans() }}</span>
            </div>

            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center mr-3 text-slate-400">
                        <i class="fas fa-calendar-alt text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tgl Daftar</p>
                        <p class="text-sm text-slate-700 font-medium">{{ optional($application->created_at)->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>
                
                @if($application->status == 'Diterima')
                <div class="flex items-start">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center mr-3 text-green-500">
                        <i class="fas fa-check-circle text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tgl Bergabung</p>
                        <p class="text-sm text-green-600 font-bold">{{ $application->join_date ? \Carbon\Carbon::parse($application->join_date)->format('d M Y') : '-' }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: Details & Timeline -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Application Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="border-b border-slate-50 bg-slate-50/50 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-800">Review Lamaran</h3>
            </div>
            
            <div class="p-6 space-y-8">
                <!-- Applied Position -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Posisi Dilamar</h4>
                    <div class="flex items-center p-4 bg-blue-50/50 rounded-2xl border border-blue-100/50">
                        <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center text-white mr-4 shadow-blue-200 shadow-lg">
                            <i class="fas fa-briefcase text-lg"></i>
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 text-lg">{{ $application->job->title ?? '—' }}</div>
                            <div class="text-sm text-blue-600 font-medium">{{ $application->job->location ?? 'Head Office' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Cover Letter -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Surat Lamaran</h4>
                    <div class="p-6 bg-slate-50 rounded-2xl text-slate-700 text-sm leading-relaxed whitespace-pre-wrap border border-slate-100 italic quill-style">
                        {{ $application->cover_letter ?? 'Tidak ada surat lamaran dilampirkan.' }}
                    </div>
                </div>

                <!-- Snapshot Info & Documents -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Informasi Saat Daftar</h4>
                        <div class="space-y-3 bg-white p-4 rounded-xl border border-slate-100">
                             <div class="flex justify-between text-sm py-1 border-b border-slate-50">
                                <span class="text-slate-500">Pendidikan</span>
                                <span class="font-medium text-slate-800">{{ $application->applicant_last_education ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between text-sm py-1 border-b border-slate-50">
                                <span class="text-slate-500">Posisi Terakhir</span>
                                <span class="font-medium text-slate-800 text-right">{{ $application->applicant_last_position ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between text-sm py-1">
                                <span class="text-slate-500">Ekspektasi Gaji</span>
                                <span class="font-bold text-blue-600">{{ optional($application->user->profile)->expected_salary ? number_format(optional($application->user->profile)->expected_salary,0,',','.') . ' IDR' : '—' }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                         <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Kontak Info</h4>
                         <div class="space-y-3 bg-white p-4 rounded-xl border border-slate-100">
                             <div class="flex items-center text-sm py-1">
                                <i class="fas fa-envelope w-6 text-slate-400"></i>
                                <span class="text-slate-700">{{ $application->applicant_email ?? ($application->user->email ?? '—') }}</span>
                            </div>
                            <div class="flex items-center text-sm py-1">
                                <i class="fas fa-phone w-6 text-slate-400"></i>
                                <span class="text-slate-700">{{ $application->applicant_phone ?? '—' }}</span>
                            </div>
                            <div class="flex items-center text-sm py-1">
                                <i class="fas fa-map-marker-alt w-6 text-slate-400"></i>
                                <span class="text-slate-700 break-words line-clamp-1">{{ optional($application->user->profile)->address ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumen Pendukung -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Dokumen Pendukung</h4>
                    @php
                        $userProfile = optional($application->user)->profile;
                        $docs = [
                            ['title' => 'Foto Formal', 'path' => optional($userProfile)->formal_photo_path, 'icon' => 'fa-id-badge', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'],
                            ['title' => 'KTP', 'path' => optional($userProfile)->ktp_path, 'icon' => 'fa-address-card', 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-50'],
                            ['title' => 'Kartu Keluarga (KK)', 'path' => optional($userProfile)->kk_path, 'icon' => 'fa-users', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50'],
                            ['title' => 'NPWP', 'path' => optional($userProfile)->npwp_path, 'icon' => 'fa-file-invoice-dollar', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'],
                            ['title' => 'Ijazah Terakhir', 'path' => optional($userProfile)->ijazah_path, 'icon' => 'fa-graduation-cap', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50'],
                            ['title' => 'Sertifikat', 'path' => optional($userProfile)->certificate_path, 'icon' => 'fa-certificate', 'color' => 'text-rose-500', 'bg' => 'bg-rose-50'],
                        ];
                    @endphp
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($docs as $doc)
                            @if($doc['path'])
                                <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" 
                                   class="group flex flex-col items-center p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all text-center">
                                    <div class="w-12 h-12 {{ $doc['bg'] }} {{ $doc['color'] }} rounded-xl flex items-center justify-center text-xl mb-3 group-hover:scale-110 transition-transform">
                                        <i class="fas {{ $doc['icon'] }}"></i>
                                    </div>
                                    <h5 class="text-xs font-bold text-slate-700 leading-tight">{{ $doc['title'] }}</h5>
                                    <span class="text-[10px] text-blue-500 font-medium mt-1 opacity-0 group-hover:opacity-100 transition-opacity">Tinjau Dokumen &rarr;</span>
                                </a>
                            @else
                                <div class="flex flex-col items-center p-4 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200 text-center opacity-60">
                                    <div class="w-12 h-12 bg-slate-100 text-slate-300 rounded-xl flex items-center justify-center text-xl mb-3">
                                        <i class="fas {{ $doc['icon'] }}"></i>
                                    </div>
                                    <h5 class="text-xs font-medium text-slate-500 leading-tight">{{ $doc['title'] }}</h5>
                                    <span class="text-[10px] text-slate-400 mt-1">Belum Tersedia</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Timeline -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Timeline Perubahan Status</h4>
                    <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-100">
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
                                if ($application->status === 'Ditolak' && $step === 'Tidak Lanjut') {
                                    $state = 'current';
                                }
                            @endphp
                            
                            @if($state !== 'future' || $i <= $currentIndex + 1)
                            <div class="relative">
                                <div class="absolute -left-[20px] top-1 h-3 w-3 rounded-full border-2 border-white 
                                    {{ $state === 'done' ? 'bg-green-500 shadow-[0_0_0_2px_#22c55e33]' : ($state === 'current' ? 'bg-blue-600 animate-pulse ring-4 ring-blue-100 shadow-[0_0_0_2px_#2563eb33]' : 'bg-slate-200') }}">
                                </div>
                                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-1">
                                    <div class="font-bold text-sm {{ $state === 'current' ? 'text-slate-800' : 'text-slate-500' }}">{{ $step }}</div>
                                    @php $h = $application->statusHistories->firstWhere('status', $step); @endphp
                                    @if($h)
                                        <div class="text-[10px] text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full border border-slate-100">
                                            {{ optional($h->created_at)->format('d M, H:i') }} • {{ $h->changer->name ?? 'System' }}
                                        </div>
                                    @endif
                                </div>
                                @if($h && $h->note)
                                    <p class="text-[11px] text-slate-500 mt-1 italic leading-tight bg-yellow-50/50 p-2 rounded-lg border-l-2 border-yellow-200">{{ $h->note }}</p>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="pt-6 border-t border-slate-100">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Ganti Status Kandidat</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Psikotest' => 'bg-amber-100 text-amber-600', 'Wawancara HR' => 'bg-blue-100 text-blue-600', 'Wawancara User' => 'bg-indigo-100 text-indigo-600', 'Offering Letter' => 'bg-emerald-100 text-emerald-600'] as $st => $cls)
                            <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $st }}">
                                <button type="submit" class="px-3 py-1.5 {{ $cls }} text-[11px] font-bold rounded-lg hover:brightness-95 transition-all uppercase tracking-tight">
                                    {{ $st }}
                                </button>
                            </form>
                        @endforeach
                        
                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST" class="inline-flex">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Tidak Lanjut">
                            <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-600 text-[11px] font-bold rounded-lg hover:brightness-95 transition-all uppercase tracking-tight">
                                Tolak Kandidat
                            </button>
                        </form>
                    </div>

                    <!-- Acceptance Form -->
                    <div class="mt-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[11px] font-bold text-slate-500 uppercase mb-3">Tandai Diterima (Hired)</p>
                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="Diterima">
                            <input name="join_date" type="date" class="flex-1 rounded-xl border-slate-200 text-sm focus:ring-green-500 focus:border-green-500 shadow-sm" required />
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white text-sm font-bold rounded-xl hover:bg-green-700 shadow-sm shadow-green-200 transition-all">
                                <i class="fas fa-check mr-2"></i> Konfirmasi Diterima
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
