@extends('layouts.admin')

@section('title', 'Detail Pelamar')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pelamar</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi lengkap pelamar untuk lowongan: {{ $application->job->title ?? '—' }}</p>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-4">
                        @if($application->user && $application->user->profile && $application->user->profile->photo_path)
                            <img class="h-24 w-24 rounded-full object-cover" src="{{ asset('storage/' . $application->user->profile->photo_path) }}" alt="Foto">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">—</div>
                        @endif
                        <div>
                            <div class="font-medium text-lg">{{ $application->user->name ?? 'Pengguna Terhapus' }}</div>
                            <div class="text-sm text-gray-500">{{ $application->user->email ?? '—' }}</div>
                        </div>
                    </div>

                    @php
                        $rawPhone = $application->applicant_phone ?? optional($application->user->profile)->phone_number ?? null;
                        $waNumber = null;
                        if ($rawPhone) {
                            // remove non-digit characters
                            $num = preg_replace('/\D+/', '', $rawPhone);
                            // if starts with 0, assume Indonesian number and replace with 62
                            if (strlen($num) > 0 && $num[0] === '0') {
                                $num = '62' . substr($num, 1);
                            }
                            // strip leading plus if any (preg_replace removed it)
                            $waNumber = $num;
                        }
                        $waMessage = '';
                        if ($waNumber) {
                            $name = $application->applicant_name ?? ($application->user->name ?? 'Kandidat');
                            $waMessage = urlencode("Halo $name, saya dari tim Recruitment TERANG By SRT ingin berdiskusi mengenai lamaran Anda.");
                        }
                    @endphp

                    @if($waNumber)
                        <div class="mt-4">
                            <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" rel="noopener" class="inline-flex items-center px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    @endif

                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-600">Status Lamaran</h4>
                        <div class="mt-2 text-sm text-gray-800">{{ $application->status }}</div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-600">Diterima Pada</h4>
                        <div class="mt-2 text-sm text-gray-800">{{ optional($application->created_at)->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-sm font-semibold text-gray-600">Informasi Lowongan</h4>
                    <div class="mt-2 text-sm text-gray-800 mb-4">
                        <div class="font-medium">{{ $application->job->title ?? '—' }}</div>
                        <div class="text-gray-500">{{ $application->job->company ?? '' }} • {{ $application->job->location ?? '' }}</div>
                    </div>

                    <h4 class="text-sm font-semibold text-gray-600">Surat Lamaran</h4>
                    <div class="mt-2 bg-gray-50 border p-4 rounded text-sm text-gray-800 whitespace-pre-wrap">{{ $application->cover_letter ?? '—' }}</div>

                    <h4 class="text-sm font-semibold text-gray-600 mt-6">Data Pendaftaran (Snapshot)</h4>
                    <div class="mt-2 text-sm text-gray-800 space-y-2">
                        <div><strong>Nama saat daftar:</strong> {{ $application->applicant_name ?? ($application->user->name ?? '—') }}</div>
                        <div><strong>Email saat daftar:</strong> {{ $application->applicant_email ?? ($application->user->email ?? '—') }}</div>
                        <div><strong>Telepon saat daftar:</strong> {{ $application->applicant_phone ?? optional($application->user->profile)->phone_number ?? '—' }}</div>
                        <div><strong>Pendidikan terakhir saat daftar:</strong> {{ $application->applicant_last_education ?? optional($application->user->profile)->education_level ?? '—' }}</div>
                        <div><strong>Posisi terakhir saat daftar:</strong> {{ $application->applicant_last_position ?? optional($application->user->profile)->last_position ?? '—' }}</div>
                        <div><strong>Sedang Bekerja saat daftar:</strong> {{ optional($application->user->profile)->currently_employed ? 'Ya' : 'Tidak' }}</div>
                        <div><strong>Ekspektasi Gaji saat daftar:</strong> {{ optional($application->user->profile)->expected_salary ? number_format(optional($application->user->profile)->expected_salary,0,',','.') . ' IDR' : '—' }}</div>

                        @php
                            $regExps = $application->user->workExperiences ?? collect();
                        @endphp
                        @if($regExps->isNotEmpty())
                            <div class="pt-2">
                                <div class="font-medium">Riwayat Pekerjaan saat Daftar</div>
                                <ul class="mt-2 list-disc list-inside text-sm text-gray-700">
                                    @foreach($regExps->take(5) as $we)
                                        @php
                                            $parts = $we->job_description ? explode(' — ', $we->job_description) : [];
                                            $pos = $parts[0] ?? null;
                                            $desc = $parts[1] ?? null;
                                        @endphp
                                        <li>
                                            <strong>{{ $we->company_name }}</strong>@if($pos) — {{ $pos }}@endif @if($we->duration) ({{ $we->duration }})@endif
                                            @if($desc)<div class="text-xs text-gray-600">{{ $desc }}</div>@endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <h4 class="text-sm font-semibold text-gray-600 mt-6">Profil Pelamar (Terkini)</h4>
                    <div class="mt-2 text-sm text-gray-800 space-y-2">
                        <div><strong>Telepon:</strong> {{ optional($application->user->profile)->phone ?? '—' }}</div>
                        <div><strong>Alamat:</strong> {{ optional($application->user->profile)->address ?? '—' }}</div>
                        <div><strong>Pendidikan Terakhir:</strong> {{ optional($application->user->profile)->last_education ?? '—' }}</div>
                        <div><strong>Posisi Terakhir:</strong> {{ optional($application->user->profile)->last_position ?? '—' }}</div>
                    </div>

                    <h4 class="text-sm font-semibold text-gray-600 mt-6">Timeline Status</h4>
                    <div class="mt-4">
                        @php
                            $steps = [
                                'Baru',
                                'Lamaran Dilihat',
                                'Psikotest',
                                'Wawancara HR',
                                'Wawancara User',
                                'Offering Letter',
                                'Shortlist',
                                'Diterima',
                                'Tidak Lanjut',
                            ];
                            $currentIndex = array_search($application->status, $steps);
                            if ($currentIndex === false) {
                                // if status not in defined steps, set to -1
                                $currentIndex = -1;
                            }
                        @endphp

                        <ol class="border-l border-gray-200">
                            @foreach($steps as $i => $step)
                                @php
                                    $state = 'future';
                                    if ($i < $currentIndex) $state = 'done';
                                    if ($i === $currentIndex) $state = 'current';
                                @endphp

                                <li class="mb-6 ml-6">
                                    <span class="-left-3.5 absolute mt-1 flex items-center justify-center h-7 w-7 rounded-full text-white">
                                    </span>
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($state === 'done')
                                                <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white">✓</div>
                                            @elseif($state === 'current')
                                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">●</div>
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700">○</div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-medium @if($state === 'current') text-blue-600 @elseif($state === 'done') text-gray-700 @else text-gray-500 @endif">{{ $step }}</div>
                                            @if($state === 'done' || $state === 'current')
                                                @php
                                                    $h = $application->statusHistories->firstWhere('status', $step);
                                                @endphp
                                                @if($h)
                                                    <div class="text-xs text-gray-500">{{ optional($h->created_at)->format('d M Y H:i') ?? '' }}{{ $h->changer ? ' — oleh ' . $h->changer->name : '' }}</div>
                                                    @if($h->note)
                                                        <div class="text-sm text-gray-700 mt-1">{{ $h->note }}</div>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Psikotest">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Psikotest</button>
                        </form>

                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Wawancara HR">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Interview HR</button>
                        </form>

                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Wawancara User">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Interview User</button>
                        </form>

                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Offering Letter">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Offering Letter</button>
                        </form>

                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Diterima">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tandai Diterima</button>
                        </form>

                        <form action="{{ route('admin.applicants.updateStatus', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Tidak Lanjut">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Tandai Ditolak</button>
                        </form>

                        <form action="{{ route('admin.applicants.addToTalentPool', $application) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">Tambahkan ke Talent Pool</button>
                        </form>

                        <a href="{{ route('admin.applicants.index') }}" class="ml-auto inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded">Kembali</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
