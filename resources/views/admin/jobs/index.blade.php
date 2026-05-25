@extends('layouts.admin')

@section('title', 'Kelola Lowongan')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Kelola Lowongan</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen posisi pekerjaan dan status rekrutmen</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Tambah Lowongan
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 font-medium">
                        <th class="px-5 py-3.5">Posisi</th>
                        <th class="px-5 py-3.5">Lokasi & Tipe</th>
                        <th class="px-5 py-3.5">Gaji</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($jobs as $job)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="text-sm font-medium text-slate-800">{{ $job->title }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $job->division ?? 'Divisi Umum' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-xs text-slate-500 space-y-1">
                                    <div><i class="fas fa-map-marker-alt w-3.5 text-slate-400 mr-1"></i> {{ $job->location }}</div>
                                    <div><i class="fas fa-briefcase w-3.5 text-slate-400 mr-1"></i> {{ $job->type }}</div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-500">
                                {{ $job->salary_range ?? '-' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span data-job-id-state="{{ $job->id }}">
                                    @if ($job->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-50 text-slate-500 border border-slate-200">
                                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span> Non-Aktif
                                        </span>
                                    @endif
                                </span>
                                <button data-toggle-job="{{ $job->id }}" class="block mx-auto mt-1.5 text-[11px] text-slate-400 hover:text-indigo-600 transition-colors">Ubah Status</button>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('karir.show', $job->id) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors" title="Lihat di Website">
                                        <i class="fas fa-external-link-alt text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-md transition-colors" title="Edit">
                                        <i class="fas fa-pencil-alt text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus lowongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors" title="Hapus">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <i class="far fa-folder-open text-3xl text-slate-200 mb-3"></i>
                                <p class="text-sm font-medium text-slate-500">Belum ada lowongan kerja</p>
                                <p class="text-xs mt-1">Mulai dengan menambahkan posisi baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($jobs, 'links'))
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('[data-toggle-job]');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-toggle-job');
                    const statusContainer = document.querySelector(`[data-job-id-state="${jobId}"]`);

                    fetch(`/admin/jobs/${jobId}/toggle-active`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.is_active) {
                                statusContainer.innerHTML = `
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Aktif
                                    </span>
                                `;
                            } else {
                                statusContainer.innerHTML = `
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-50 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span> Non-Aktif
                                    </span>
                                `;
                            }
                        } else {
                            alert('Gagal mengubah status');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
