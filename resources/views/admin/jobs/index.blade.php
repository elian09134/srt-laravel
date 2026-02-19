@extends('layouts.admin')

@section('title', 'Kelola Lowongan')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Lowongan</h1>
            <p class="text-sm text-slate-500">Manajemen posisi pekerjaan dan status rekrutmen</p>
        </div>
        <a href="{{ route('admin.jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200">
            <i class="fas fa-plus mr-2"></i> Tambah Lowongan
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Optional: Toolbar/Filter could go here -->
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="px-6 py-4">Posisi</th>
                        <th class="px-6 py-4">Lokasi & Tipe</th>
                        <th class="px-6 py-4">Gaji</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jobs as $job)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $job->title }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $job->division ?? 'Divisi Umum' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-700 space-y-1">
                                    <div class="flex items-center text-xs">
                                        <i class="fas fa-map-marker-alt w-4 text-slate-400"></i> {{ $job->location }}
                                    </div>
                                    <div class="flex items-center text-xs">
                                        <i class="fas fa-briefcase w-4 text-slate-400"></i> {{ $job->type }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $job->salary_range ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span data-job-id-state="{{ $job->id }}">
                                    @if ($job->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 bg-slate-500 rounded-full mr-1.5"></span> Non-Aktif
                                        </span>
                                    @endif
                                </span>
                                <!-- Optional: AJAX toggle button could be styled better or kept functional -->
                                <button data-toggle-job="{{ $job->id }}" class="block mx-auto mt-2 text-[10px] underline text-slate-400 hover:text-blue-600">Ubah Status</button>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('karir.show', $job->id) }}" target="_blank" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat di Website">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus lowongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="far fa-folder-open text-4xl text-slate-200 mb-3"></i>
                                    <p class="text-base font-medium">Belum ada lowongan kerja</p>
                                    <p class="text-sm mt-1">Mulai dengan menambahkan posisi baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (if applicable) -->
        @if(method_exists($jobs, 'links'))
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>

    <!-- Script for Toggle (Preserved functionality) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('[data-toggle-job]');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const jobId = this.getAttribute('data-toggle-job');
                    const statusContainer = document.querySelector(`[data-job-id-state="${jobId}"]`);
                    
                    // Simple AJAX request to toggle status
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
                            // Update UI
                            if (data.is_active) {
                                statusContainer.innerHTML = `
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Aktif
                                    </span>
                                `;
                            } else {
                                statusContainer.innerHTML = `
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 bg-slate-500 rounded-full mr-1.5"></span> Non-Aktif
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
