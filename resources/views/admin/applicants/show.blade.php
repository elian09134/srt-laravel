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
                            $waMessage = urlencode("Halo $name, saya dari tim SRT ingin berdiskusi mengenai lamaran Anda.");
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
                        <div class="mt-2 text-sm text-gray-800">{{ $application->created_at->format('d M Y H:i') }}</div>
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
                        <div><strong>Telepon saat daftar:</strong> {{ $application->applicant_phone ?? optional($application->user->profile)->phone ?? '—' }}</div>
                        <div><strong>Pendidikan terakhir saat daftar:</strong> {{ $application->applicant_last_education ?? optional($application->user->profile)->last_education ?? '—' }}</div>
                        <div><strong>Posisi terakhir saat daftar:</strong> {{ $application->applicant_last_position ?? optional($application->user->profile)->last_position ?? '—' }}</div>
                    </div>

                    <h4 class="text-sm font-semibold text-gray-600 mt-6">Profil Pelamar (Terkini)</h4>
                    <div class="mt-2 text-sm text-gray-800 space-y-2">
                        <div><strong>Telepon:</strong> {{ optional($application->user->profile)->phone ?? '—' }}</div>
                        <div><strong>Alamat:</strong> {{ optional($application->user->profile)->address ?? '—' }}</div>
                        <div><strong>Pendidikan Terakhir:</strong> {{ optional($application->user->profile)->last_education ?? '—' }}</div>
                        <div><strong>Posisi Terakhir:</strong> {{ optional($application->user->profile)->last_position ?? '—' }}</div>
                    </div>

                    <h4 class="text-sm font-semibold text-gray-600 mt-6">Timeline Status</h4>
                    <div class="mt-3 space-y-3">
                        @forelse($application->statusHistories as $history)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-sm text-gray-700">{{ \Carbon\Carbon::parse($history->created_at)->format('d') }}</div>
                                </div>
                                <div class="flex-1 text-sm text-gray-800">
                                    <div class="font-medium">{{ $history->status }}</div>
                                    <div class="text-xs text-gray-500">{{ $history->created_at->format('d M Y H:i') }}{{ $history->changer ? ' — oleh ' . $history->changer->name : '' }}</div>
                                    @if($history->note)
                                        <div class="mt-1 text-gray-700">{{ $history->note }}</div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-gray-500">Belum ada riwayat status.</div>
                        @endforelse
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
