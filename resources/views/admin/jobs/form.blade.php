@extends('layouts.admin')

@section('title', isset($job) ? 'Edit Lowongan' : 'Buat Lowongan Baru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.jobs.index') }}" class="text-slate-500 hover:text-blue-600 text-sm mb-2 inline-flex items-center transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-800">
            {{ isset($job) ? 'Edit Lowongan Kerja' : 'Buat Lowongan Baru' }}
        </h1>
    </div>

    <form action="{{ isset($job) ? route('admin.jobs.update', $job) : route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data" id="jobForm">
        @csrf
        @if(isset($job))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Info -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- General Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Informasi Dasar</h3>
                    
                    <div class="space-y-4">
                        <!-- FPTK Selection -->
                        <div>
                            <label for="fptk_id" class="block text-sm font-medium text-slate-700 mb-1">Link ke FPTK (Opsional)</label>
                            <select name="fptk_id" id="fptk_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm" onchange="fillFromFptk()">
                                <option value="">-- Pilih FPTK (Data akan terisi otomatis) --</option>
                                @foreach($fptks ?? [] as $fptk)
                                    <option value="{{ $fptk->id }}" 
                                        data-position="{{ $fptk->position }}"
                                        data-locations="{{ $fptk->locations }}"
                                        data-notes="{{ htmlspecialchars(json_encode($fptk->notes), ENT_QUOTES, 'UTF-8') }}"
                                        @if(old('fptk_id', $job->fptk_id ?? '') == $fptk->id) selected @endif>
                                        [#{{ $fptk->id }}] {{ $fptk->position }} - {{ $fptk->qty }} Orang (Req: {{ $fptk->user->name }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-slate-500">Memilih FPTK akan mengisi form otomatis berdasarkan data pengajuan.</p>
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Judul Posisi <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $job->title ?? '') }}" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm placeholder-slate-400" placeholder="Contoh: Senior Backend Developer">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-slate-700 mb-1">Lokasi Penempatan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-slate-400 text-xs"></i>
                                    </div>
                                    <input type="text" name="location" id="location" value="{{ old('location', $job->location ?? '') }}" required class="pl-8 w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="Contoh: Jakarta Pusat">
                                </div>
                            </div>
                            
                             <!-- Salary -->
                            <div>
                                <label for="salary_range" class="block text-sm font-medium text-slate-700 mb-1">Range Gaji (Opsional)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-xs font-bold">Rp</span>
                                    </div>
                                    <input type="text" name="salary_range" id="salary_range" value="{{ old('salary_range', $job->salary_range ?? '') }}" class="pl-8 w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm" placeholder="5.000.000 - 8.000.000">
                                </div>
                            </div>
                        </div>

                        <!-- Type -->
                         <div>
                            <label for="type" class="block text-sm font-medium text-slate-700 mb-1">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                            <select name="type" id="type" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                                <option @if(old('type', $job->type ?? '') == 'Full Time') selected @endif>Full Time</option>
                                <option @if(old('type', $job->type ?? '') == 'Part Time') selected @endif>Part Time</option>
                                <option @if(old('type', $job->type ?? '') == 'Contract') selected @endif>Contract</option>
                                <option @if(old('type', $job->type ?? '') == 'Internship') selected @endif>Internship</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Text Areas -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-6">
                    <div>
                        <label for="jobdesk" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi & Tanggung Jawab <span class="text-red-500">*</span></label>
                        <textarea name="jobdesk" id="jobdesk" rows="6" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm" placeholder="Jelaskan detail pekerjaan...">{{ old('jobdesk', $job->jobdesk ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="requirement" class="block text-sm font-medium text-slate-700 mb-1">Kualifikasi (Requirement) <span class="text-red-500">*</span></label>
                            <p class="text-xs text-slate-500 mb-2">Tulis satu poin per baris.</p>
                            <textarea name="requirement" id="requirement" rows="8" required class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm" placeholder="- Pendidikan Min S1&#10;- Pengalaman 2 tahun&#10;- Menguasai Laravel">{{ old('requirement', isset($job) ? json_decode($job->requirement, true) ? implode("\n", json_decode($job->requirement, true)) : '' : '') }}</textarea>
                        </div>
                        <div>
                            <label for="benefits" class="block text-sm font-medium text-slate-700 mb-1">Benefit (Opsional)</label>
                            <p class="text-xs text-slate-500 mb-2">Tulis satu poin per baris.</p>
                            <textarea name="benefits" id="benefits" rows="8" class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm" placeholder="- BPJS Kesehatan&#10;- Makan Siang&#10;- Bonus Tahunan">{{ old('benefits', isset($job) ? json_decode($job->benefits, true) ? implode("\n", json_decode($job->benefits, true)) : '' : '') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Media & Actions -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Media Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Media & Tampilan</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Thumbnail Lowongan</label>
                            
                            @if(isset($job) && $job->image)
                                <div class="mb-3 relative group rounded-lg overflow-hidden border border-slate-200">
                                    <img src="{{ Storage::url($job->image) }}" alt="Current Image" class="w-full h-32 object-cover">
                                </div>
                            @endif

                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 mb-2"></i>
                                        <p class="text-xs text-slate-500"><span class="font-semibold">Klik untuk upload</span></p>
                                        <p class="text-[10px] text-slate-400 mt-1">PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                    <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-200">
                            <div>
                                <label for="show_image" class="text-sm font-medium text-slate-700 block">Tampilkan Gambar</label>
                                <span class="text-xs text-slate-500">Muncul di detail lowongan</span>
                            </div>
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="show_image" id="show_image" value="1" @if(old('show_image', $job->show_image ?? true)) checked @endif class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-slate-300 checked:right-0 checked:border-blue-600"/>
                                <label for="show_image" class="toggle-label block overflow-hidden h-5 rounded-full bg-slate-300 cursor-pointer"></label>
                            </div>
                             <!-- Note: Standard checkbox fallback if custom toggle CSS missing -->
                             <style>
                                 .toggle-checkbox:checked { right: 0; border-color: #2563EB; }
                                 .toggle-checkbox:checked + .toggle-label { background-color: #2563EB; } 
                                 .toggle-checkbox { right: auto; left: 0; transition: all 0.3s; }
                             </style>
                        </div>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 border-b border-slate-100 pb-2">Publikasi</h3>
                    <p class="text-sm text-slate-600 mb-4">Pastikan semua data sudah benar sebelum menyimpan.</p>
                    
                    <div class="space-y-3">
                        <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200">
                            <i class="fas fa-save mr-2"></i> {{ isset($job) ? 'Simpan Perubahan' : 'Terbitkan Lowongan' }}
                        </button>
                        <a href="{{ route('admin.jobs.index') }}" class="block w-full text-center py-2.5 px-4 bg-slate-100 text-slate-600 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <script>
    function fillFromFptk() {
        const select = document.getElementById('fptk_id');
        const selectedOption = select.options[select.selectedIndex];
        
        if (!selectedOption.value) return;

        const position = selectedOption.dataset.position || '';
        const locations = selectedOption.dataset.locations || '';
        const notesJson = selectedOption.dataset.notes || '{}';
        
        // ... (Existing logic preserved) ...
        // Re-implementing logic compactly for new IDs if needed, but IDs are consistent
        let notes = {};
        try { notes = JSON.parse(notesJson); } catch (e) { notes = {}; }

        document.getElementById('title').value = position;
        document.getElementById('location').value = locations || '';
        
        // Salary logic
        if (notes.gaji) {
            let val = notes.gaji;
            if (!isNaN(val)) val = 'Rp ' + parseInt(val).toLocaleString('id-ID');
            document.getElementById('salary_range').value = val;
        } else if (notes.golongan_gaji) {
            document.getElementById('salary_range').value = notes.golongan_gaji;
        }

        if (notes.uraian) document.getElementById('jobdesk').value = notes.uraian;

        let reqs = [];
        if (notes.pendidikan) reqs.push('Pendidikan: ' + notes.pendidikan);
        if (notes.usia) reqs.push('Usia: ' + notes.usia);
        if (notes.pengalaman) reqs.push('Pengalaman: ' + notes.pengalaman);
        if (notes.keterampilan) {
            notes.keterampilan.split(/[,\n]+/).map(s => s.trim()).filter(s => s).forEach(s => reqs.push(s));
        }
        if (reqs.length > 0) document.getElementById('requirement').value = reqs.join('\n');

        alert('Data berhasil diisi dari FPTK!');
    }
    
    // Preview Image Logic (Simple)
    document.getElementById('image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            // Optional: Implement preview if needed, or just let backend handle it
            // For now UI feedback "file chosen" is handled by browser but we styled it as a box
            // Custom text update logic could go here
            const fileName = e.target.files[0].name;
            this.parentElement.querySelector('p span').innerText = fileName;
        }
    });
    </script>
@endsection
