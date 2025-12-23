@extends('layouts.admin')

@section('title', 'Kelola Konten Website')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Kelola Konten Website</h1>
        <p class="text-sm text-gray-600">Atur dan kelola semua konten yang tampil di halaman utama</p>
    </div>
    
    <form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Section: Hero -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-home text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Hero Section</h2>
                        <p class="text-xs text-gray-600">Banner utama halaman depan</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Utama</label>
                    <input type="text" name="content[hero][title]" id="hero_title" value="{{ old('content.hero.title', $content['hero']['title'] ?? '') }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Masukkan judul hero...">
                </div>
                <div>
                    <label for="hero_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="content[hero][description]" id="hero_description" rows="3" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Deskripsi singkat untuk hero section...">{{ old('content.hero.description', $content['hero']['description'] ?? '') }}</textarea>
                </div>
                
                <!-- Anggota Tim HR - Form Biasa -->
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Anggota Tim HR</label>
                            <p class="text-xs text-gray-500 mt-1">Kelola data tim Human Resources</p>
                        </div>
                        <button type="button" id="addMemberBtn" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <i class="fas fa-plus text-xs"></i>
                            <span>Tambah Anggota</span>
                        </button>
                    </div>
                
                    @php
                        $members = old('content.hr_department.members');
                        if (!$members && isset($content['hr_department']['members'])) {
                            $members = is_string($content['hr_department']['members']) 
                                ? json_decode($content['hr_department']['members'], true) 
                                : $content['hr_department']['members'];
                        }
                        if (empty($members)) {
                            $members = [[]]; // At least one empty member for initial form
                        }
                        $memberCount = count($members);
                    @endphp

                <div id="membersContainer" class="space-y-4" data-initial-count="{{ $memberCount }}">
                    
                    @foreach($members as $index => $member)
                    <div class="member-item border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white hover:shadow-md transition-all">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="member-number text-sm font-semibold text-blue-700">{{ $index + 1 }}</span>
                                </div>
                                <h4 class="font-medium text-gray-900">Anggota Tim</h4>
                            </div>
                            <button type="button" class="removeMemberBtn text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg text-sm transition-colors flex items-center space-x-1">
                                <i class="fas fa-trash-alt text-xs"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="content[hr_department][members][{{ $index }}][name]" 
                                       value="{{ old("content.hr_department.members.$index.name", $member['name'] ?? '') }}"
                                       class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Nama anggota...">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                                <input type="text" name="content[hr_department][members][{{ $index }}][role]" 
                                       value="{{ old("content.hr_department.members.$index.role", $member['role'] ?? '') }}"
                                       class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="HR Manager, Recruiter, dll...">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">Foto <span class="text-red-500">*</span></label>
                                <input type="file" name="content[hr_department][members][{{ $index }}][photo_file]" 
                                       accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="block w-full text-sm text-gray-900 border border-gray-200 rounded-lg cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @if(isset($member['photo']) && $member['photo'])
                                    <input type="hidden" name="content[hr_department][members][{{ $index }}][photo_existing]" value="{{ $member['photo'] }}">
                                    <div class="mt-2 flex items-center space-x-2">
                                        <img src="{{ Storage::url($member['photo']) }}" alt="Current photo" class="w-16 h-16 object-cover rounded-lg border">
                                        <span class="text-xs text-gray-600">Foto saat ini</span>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle"></i> Format: JPG, PNG, WebP. Max 2MB
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">Email</label>
                                <input type="email" name="content[hr_department][members][{{ $index }}][email]" 
                                       value="{{ old("content.hr_department.members.$index.email", $member['email'] ?? '') }}"
                                       class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="email@srtcorp.com">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">No. Telepon</label>
                                <input type="text" name="content[hr_department][members][{{ $index }}][phone]" 
                                       value="{{ old("content.hr_department.members.$index.phone", $member['phone'] ?? '') }}"
                                       placeholder="+62 812-3456-7890"
                                       class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    <i class="fab fa-linkedin text-blue-600"></i> LinkedIn
                                </label>
                                <input type="text" name="content[hr_department][members][{{ $index }}][linkedin]" 
                                       value="{{ old("content.hr_department.members.$index.linkedin", $member['social']['linkedin'] ?? '') }}"
                                       placeholder="https://linkedin.com/in/username"
                                       class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                    <i class="fab fa-instagram text-pink-500"></i> Instagram
                                </label>
                                <input type="text" name="content[hr_department][members][{{ $index }}][instagram]" 
                                       value="{{ old("content.hr_department.members.$index.instagram", $member['social']['instagram'] ?? '') }}"
                                       placeholder="@username"
                                       class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">Bio / Deskripsi Singkat</label>
                                <textarea name="content[hr_department][members][{{ $index }}][bio]" rows="2"
                                          class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                          placeholder="Deskripsi singkat tentang anggota tim...">{{ old("content.hr_department.members.$index.bio", $member['bio'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <p class="text-xs text-gray-500 bg-blue-50 border border-blue-100 rounded-lg p-3 flex items-start space-x-2">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    <span><strong>Catatan:</strong> Field bertanda <span class="text-red-500">*</span> wajib diisi. Upload foto langsung dari device Anda (PC/Laptop/HP). Format yang diterima: JPG, PNG, WebP dengan ukuran maksimal 2MB.</span>
                </p>
            </div>
        </div>
    </div>

        <!-- Section: Departemen HR -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Seksi Departemen HR</h2>
                        <p class="text-xs text-gray-600">Informasi departemen Human Resources</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="hr_department_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Seksi</label>
                    <input type="text" name="content[hr_department][title]" id="hr_department_title" value="{{ old('content.hr_department.title', $content['hr_department']['title'] ?? '') }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" placeholder="Departemen HR / Human Resources">
                </div>
                <div>
                    <label for="hr_department_team_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Tim (Meet Our Team)</label>
                    <input type="text" name="content[hr_department][team_title]" id="hr_department_team_title" value="{{ old('content.hr_department.team_title', $content['hr_department']['team_title'] ?? '') }}" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" placeholder="Meet Our Team">
                </div>
                <div>
                    <label for="hr_department_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Departemen</label>
                    <textarea name="content[hr_department][description]" id="hr_department_description" rows="4" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all" placeholder="Deskripsi singkat tentang departemen HR...">{{ old('content.hr_department.description', $content['hr_department']['description'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section: Tentang Kami -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Seksi Tentang Kami</h2>
                        <p class="text-xs text-gray-600">Sejarah, visi, dan misi perusahaan</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label for="about_us_history_text" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-history text-green-600"></i> Sejarah Kami
                    </label>
                    <textarea name="content[about_us][history_text]" id="about_us_history_text" rows="4" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" placeholder="Ceritakan sejarah singkat perusahaan...">{{ old('content.about_us.history_text', $content['about_us']['history_text'] ?? '') }}</textarea>
                </div>
                <div>
                    <label for="about_us_vision_text" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-eye text-green-600"></i> Visi
                    </label>
                    <textarea name="content[about_us][vision_text]" id="about_us_vision_text" rows="2" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" placeholder="Visi perusahaan...">{{ old('content.about_us.vision_text', $content['about_us']['vision_text'] ?? '') }}</textarea>
                </div>
                <div>
                    <label for="about_us_mission_text" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-bullseye text-green-600"></i> Misi
                    </label>
                    <textarea name="content[about_us][mission_text]" id="about_us_mission_text" rows="5" class="block w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" placeholder="Masukkan poin misi, satu per baris...">{{ old('content.about_us.mission_text', isset($content['about_us']['mission_text']) ? implode("\n", json_decode($content['about_us']['mission_text'])) : '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-2">Pisahkan setiap poin misi dengan enter (satu baris = satu poin)</p>
                </div>
            </div>
        </div>

        <!-- Section: Lingkup Bisnis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Seksi Lingkup Bisnis</h2>
                        <p class="text-xs text-gray-600">5 kartu bisnis utama perusahaan</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <!-- Card 1 -->
                <div class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-orange-50/50 to-white hover:shadow-md transition-all">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">1</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">Wrapping</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Judul Kartu</label>
                            <input type="text" name="content[business_scope][card1_title]" value="{{ old('content.business_scope.card1_title', $content['business_scope']['card1_title'] ?? '') }}" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Judul...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Deskripsi</label>
                            <textarea name="content[business_scope][card1_desc]" rows="2" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Deskripsi singkat...">{{ old('content.business_scope.card1_desc', $content['business_scope']['card1_desc'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Poin-poin (satu per baris)</label>
                            <textarea name="content[business_scope][card1_list]" rows="3" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="• Poin 1&#10;• Poin 2&#10;• Poin 3">{{ old('content.business_scope.card1_list', isset($content['business_scope']['card1_list']) ? implode("\n", json_decode($content['business_scope']['card1_list'])) : '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-orange-50/50 to-white hover:shadow-md transition-all">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">2</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">F&B (Food & Beverage)</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Judul Kartu</label>
                            <input type="text" name="content[business_scope][card2_title]" value="{{ old('content.business_scope.card2_title', $content['business_scope']['card2_title'] ?? '') }}" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Judul...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Deskripsi</label>
                            <textarea name="content[business_scope][card2_desc]" rows="2" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Deskripsi singkat...">{{ old('content.business_scope.card2_desc', $content['business_scope']['card2_desc'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Poin-poin (satu per baris)</label>
                            <textarea name="content[business_scope][card2_list]" rows="3" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="• Poin 1&#10;• Poin 2&#10;• Poin 3">{{ old('content.business_scope.card2_list', isset($content['business_scope']['card2_list']) ? implode("\n", json_decode($content['business_scope']['card2_list'])) : '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-orange-50/50 to-white hover:shadow-md transition-all">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">3</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">Minimarket</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Judul Kartu</label>
                            <input type="text" name="content[business_scope][card3_title]" value="{{ old('content.business_scope.card3_title', $content['business_scope']['card3_title'] ?? '') }}" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Judul...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Deskripsi</label>
                            <textarea name="content[business_scope][card3_desc]" rows="2" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Deskripsi singkat...">{{ old('content.business_scope.card3_desc', $content['business_scope']['card3_desc'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Poin-poin (satu per baris)</label>
                            <textarea name="content[business_scope][card3_list]" rows="3" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="• Poin 1&#10;• Poin 2&#10;• Poin 3">{{ old('content.business_scope.card3_list', isset($content['business_scope']['card3_list']) ? implode("\n", json_decode($content['business_scope']['card3_list'])) : '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-orange-50/50 to-white hover:shadow-md transition-all">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">4</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">Reflexology</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Judul Kartu</label>
                            <input type="text" name="content[business_scope][card4_title]" value="{{ old('content.business_scope.card4_title', $content['business_scope']['card4_title'] ?? '') }}" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Judul...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Deskripsi</label>
                            <textarea name="content[business_scope][card4_desc]" rows="2" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Deskripsi singkat...">{{ old('content.business_scope.card4_desc', $content['business_scope']['card4_desc'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Poin-poin (satu per baris)</label>
                            <textarea name="content[business_scope][card4_list]" rows="3" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="• Poin 1&#10;• Poin 2&#10;• Poin 3">{{ old('content.business_scope.card4_list', isset($content['business_scope']['card4_list']) ? implode("\n", json_decode($content['business_scope']['card4_list'])) : '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-orange-50/50 to-white hover:shadow-md transition-all">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">5</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">Celluler</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Judul Kartu</label>
                            <input type="text" name="content[business_scope][card5_title]" value="{{ old('content.business_scope.card5_title', $content['business_scope']['card5_title'] ?? '') }}" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Judul...">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Deskripsi</label>
                            <textarea name="content[business_scope][card5_desc]" rows="2" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Deskripsi singkat...">{{ old('content.business_scope.card5_desc', $content['business_scope']['card5_desc'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Poin-poin (satu per baris)</label>
                            <textarea name="content[business_scope][card5_list]" rows="3" class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="• Poin 1&#10;• Poin 2&#10;• Poin 3">{{ old('content.business_scope.card5_list', isset($content['business_scope']['card5_list']) ? implode("\n", json_decode($content['business_scope']['card5_list'])) : '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <button type="submit" class="w-full px-6 py-3.5 font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-200 transition-all transform hover:scale-[1.02] active:scale-100 flex items-center justify-center space-x-2">
                <i class="fas fa-save"></i>
                <span>Simpan Semua Perubahan</span>
            </button>
        </div>
    </form>
@endsection

@php
    $memberCount = count($members ?? []);
@endphp

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('membersContainer');
    const addBtn = document.getElementById('addMemberBtn');
    let memberIndex = parseInt(container.dataset.initialCount, 10) || 0;
    
    // Member template
    function createMemberHtml(index) {
        return `
            <div class="member-item border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-gray-50 to-white hover:shadow-md transition-all">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="member-number text-sm font-semibold text-blue-700">${index + 1}</span>
                        </div>
                        <h4 class="font-medium text-gray-900">Anggota Tim</h4>
                    </div>
                    <button type="button" class="removeMemberBtn text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg text-sm transition-colors flex items-center space-x-1">
                        <i class="fas fa-trash-alt text-xs"></i>
                        <span>Hapus</span>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="content[hr_department][members][${index}][name]" 
                               class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Nama anggota...">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="content[hr_department][members][${index}][role]" 
                               class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="HR Manager, Recruiter, dll...">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Foto <span class="text-red-500">*</span></label>
                        <input type="file" name="content[hr_department][members][${index}][photo_file]" 
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="block w-full text-sm text-gray-900 border border-gray-200 rounded-lg cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Format: JPG, PNG, WebP. Max 2MB
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="content[hr_department][members][${index}][email]" 
                               class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="email@srtcorp.com">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" name="content[hr_department][members][${index}][phone]" 
                               placeholder="+62 812-3456-7890"
                               class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            <i class="fab fa-linkedin text-blue-600"></i> LinkedIn
                        </label>
                        <input type="text" name="content[hr_department][members][${index}][linkedin]" 
                               placeholder="https://linkedin.com/in/username"
                               class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">
                            <i class="fab fa-instagram text-pink-500"></i> Instagram
                        </label>
                        <input type="text" name="content[hr_department][members][${index}][instagram]" 
                               placeholder="@username"
                               class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1.5">Bio / Deskripsi Singkat</label>
                        <textarea name="content[hr_department][members][${index}][bio]" rows="2"
                                  class="block w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                  placeholder="Deskripsi singkat tentang anggota tim..."></textarea>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Add member
    addBtn.addEventListener('click', function() {
        const memberHtml = createMemberHtml(memberIndex);
        container.insertAdjacentHTML('beforeend', memberHtml);
        memberIndex++;
        updateMemberNumbers();
    });
    
    // Remove member (event delegation)
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeMemberBtn')) {
            if (container.children.length > 1) {
                e.target.closest('.member-item').remove();
                updateMemberNumbers();
            } else {
                alert('Minimal harus ada satu anggota tim.');
            }
        }
    });
    
    // Update member numbers
    function updateMemberNumbers() {
        const memberItems = container.querySelectorAll('.member-item');
        memberItems.forEach((item, idx) => {
            item.querySelector('.member-number').textContent = idx + 1;
        });
    }
});
</script>
@endsection
