<x-app-layout>
    <main>
        <section class="py-12 bg-white">
            <div class="container mx-auto px-6">
                <a href="{{ route('karir') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali ke daftar lowongan</a>

                <div class="mt-6 bg-white rounded-2xl shadow-md p-8">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $job->title }}</h1>
                    <p class="text-blue-600 font-medium mt-1">{{ $job->division }}</p>

                    <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-600">
                        <div class="flex items-center"><i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>Lokasi: {{ $job->location }}</div>
                        @if(!empty($job->salary_range))
                            <div class="flex items-center"><i class="fas fa-money-bill-wave mr-2 text-blue-500"></i>Gaji: {{ $job->salary_range }}</div>
                        @endif
                        @if(!empty($job->employment_type))
                            <div class="flex items-center">Tipe: {{ $job->employment_type }}</div>
                        @endif
                        @if(!empty($job->closing_date))
                            <div class="flex items-center">Batas aplikasi: {{ $job->closing_date }}</div>
                        @endif
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h2 class="text-xl font-semibold text-gray-800">Deskripsi Pekerjaan</h2>
                            <div class="prose mt-3 text-gray-700">
                                {!! nl2br(e($job->jobdesk)) !!}
                            </div>

                            <h3 class="mt-6 text-lg font-semibold">Persyaratan</h3>
                            <div class="prose mt-2 text-gray-700">{!! nl2br(e($job->requirement)) !!}</div>

                            <h3 class="mt-6 text-lg font-semibold">Manfaat</h3>
                            <div class="prose mt-2 text-gray-700">{!! nl2br(e($job->benefits)) !!}</div>
                        </div>

                        <aside class="bg-gray-50 rounded-xl p-4">
                            <div class="text-sm text-gray-600">Status Lowongan</div>
                            <div class="mt-2 font-semibold text-green-600">{{ $job->is_active ? 'Dibuka' : 'Ditutup' }}</div>

                            <div class="mt-6">
                                @auth
                                    @php
                                        $hasApplied = \App\Models\Application::where('job_id', $job->id)
                                                    ->where('user_id', auth()->id())
                                                    ->exists();
                                    @endphp

                                    @if($hasApplied)
                                        <div class="space-y-2">
                                            <button disabled class="w-full inline-block text-center px-4 py-2 bg-gray-300 text-gray-700 rounded-xl cursor-not-allowed">Sudah Melamar</button>
                                            <a href="{{ route('applications.index') }}" class="w-full inline-block text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50">Lihat Riwayat Lamaran</a>
                                        </div>
                                    @else
                                        <form method="post" action="{{ route('karir.apply', $job) }}">
                                            @csrf
                                            <textarea name="cover_letter" rows="4" class="w-full border-gray-200 rounded-md p-2 mb-2" placeholder="Surat Lamaran (opsional)"></textarea>
                                            <button type="submit" class="w-full inline-block text-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Daftar / Kirim Lamaran</button>
                                        </form>
                                    @endif

                                @else
                                    <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="w-full inline-block text-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Masuk untuk Melamar</a>
                                @endauth
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
