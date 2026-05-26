@extends('layouts.admin')

@section('title', 'Kelola Konten Website')

@section('content')
@php
    $members = old('content.hr_department.members');
    if (!$members && isset($content['hr_department']['members'])) {
        $members = is_string($content['hr_department']['members'])
            ? json_decode($content['hr_department']['members'], true)
            : $content['hr_department']['members'];
    }
    if (empty($members)) {
        $members = [[]];
    }
    $memberCount = count($members);

    $missionValue = $content['about_us']['mission_text'] ?? '';
    if ($missionValue && is_string($missionValue)) {
        $decoded = json_decode($missionValue, true);
        if (is_array($decoded)) {
            $missionValue = implode("\n", $decoded);
        }
    }
    $cardLists = [];
    for ($i = 1; $i <= 5; $i++) {
        $val = $content['business_scope']['card'.$i.'_list'] ?? '';
        if ($val && is_string($val)) {
            $decoded = json_decode($val, true);
            if (is_array($decoded)) {
                $val = implode("\n", $decoded);
            }
        }
        $cardLists[$i] = $val;
    }
@endphp
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800 mb-1">Kelola Konten Website</h1>
        <p class="text-sm text-gray-600">Atur dan kelola semua konten yang tampil di halaman utama</p>
    </div>

    <form action="{{ route('admin.content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <x-admin.content-section icon="fa-home" icon-bg="bg-indigo-600" title="Hero Section" desc="Banner utama halaman depan">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <x-admin.input label="Judul Utama" name="content[hero][title]" :value="$content['hero']['title'] ?? ''" placeholder="Masukkan judul hero..." />
                </div>
                <div class="md:col-span-2">
                    <x-admin.textarea label="Deskripsi" name="content[hero][description]" rows="3" :value="$content['hero']['description'] ?? ''" placeholder="Deskripsi singkat untuk hero section..." />
                </div>
                <x-admin.input label="Teks Badge (Atas Judul)" name="content[hero][badge_text]" :value="$content['hero']['badge_text'] ?? '✨ Bergabung dengan Tim Terbaik'" />
                <x-admin.input label="Teks Tombol Utama" name="content[hero][button_text]" :value="$content['hero']['button_text'] ?? 'Lihat Lowongan'" />
            </div>

            <div class="border-t border-gray-100 pt-4">
                <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-3">Statistik</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-admin.input label="Jumlah Karyawan" name="content[hero][stats_employees]" :value="$content['hero']['stats_employees'] ?? '1000+'" />
                    <x-admin.input label="Label Keamanan" name="content[hero][stats_security]" :value="$content['hero']['stats_security'] ?? 'Terpercaya'" />
                    <x-admin.input label="Label Jangkauan" name="content[hero][stats_global]" :value="$content['hero']['stats_global'] ?? 'Global'" />
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-3">Kartu Melayang <span class="text-gray-400 font-normal normal-case">(Floating Card)</span></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <x-admin.input label="Judul Kartu" name="content[hero][floating_card_title]" :value="$content['hero']['floating_card_title'] ?? 'Pertumbuhan Karir Cepat'" />
                    <x-admin.input label="Deskripsi Kartu" name="content[hero][floating_card_desc]" :value="$content['hero']['floating_card_desc'] ?? 'Mulai perjalanan profesionalmu hari ini'" />
                </div>
            </div>
        </x-admin.content-section>

        <x-admin.content-section icon="fa-users" icon-bg="bg-purple-600" title="Seksi Departemen HR" desc="Informasi departemen Human Resources">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-admin.input label="Judul Seksi" name="content[hr_department][title]" :value="$content['hr_department']['title'] ?? ''" placeholder="Departemen HR / Human Resources" />
                <x-admin.input label="Judul Tim (Meet Our Team)" name="content[hr_department][team_title]" :value="$content['hr_department']['team_title'] ?? ''" placeholder="Meet Our Team" />
                <div class="md:col-span-2">
                    <x-admin.textarea label="Deskripsi Departemen" name="content[hr_department][description]" rows="3" :value="$content['hr_department']['description'] ?? ''" placeholder="Deskripsi singkat tentang departemen HR..." />
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider">Anggota Tim HR</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Kelola data tim Human Resources</p>
                    </div>
                    <button type="button" id="addMemberBtn" class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-1.5">
                        <i class="fas fa-plus text-[10px]"></i>
                        <span>Tambah</span>
                    </button>
                </div>

                <div id="membersContainer" class="space-y-3" data-initial-count="{{ $memberCount }}">
                    @foreach($members as $index => $member)
                    <div class="member-item border border-gray-200 rounded-lg p-4 bg-white hover:border-gray-300 transition-all">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="member-number text-xs font-semibold text-indigo-700">{{ $index + 1 }}</span>
                                </div>
                                <h4 class="text-sm font-medium text-gray-900">Anggota Tim</h4>
                            </div>
                            <button type="button" class="removeMemberBtn text-red-400 hover:text-red-600 hover:bg-red-50 px-2 py-1 rounded text-xs transition-colors flex items-center gap-1">
                                <i class="fas fa-trash-alt text-[10px]"></i>
                                <span>Hapus</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <x-admin.input label="Nama Lengkap" name="content[hr_department][members][{{ $index }}][name]" :value="$member['name'] ?? ''" placeholder="Nama anggota..." required />
                            <x-admin.input label="Jabatan" name="content[hr_department][members][{{ $index }}][role]" :value="$member['role'] ?? ''" placeholder="HR Manager, Recruiter..." required />
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Foto @if(!isset($member['photo']))<span class="text-red-500">*</span>@endif</label>
                                <input type="file" name="content[hr_department][members][{{ $index }}][photo_file]"
                                       accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="block w-full text-xs text-gray-900 border border-gray-200 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-3 file:py-1.5 file:px-3 file:rounded-l-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @if(isset($member['photo']) && $member['photo'])
                                    <input type="hidden" name="content[hr_department][members][{{ $index }}][photo_existing]" value="{{ $member['photo'] }}">
                                    <div class="mt-1.5 flex items-center gap-2">
                                        <img src="{{ Storage::url($member['photo']) }}" alt="Current photo" class="w-10 h-10 object-cover rounded-lg border">
                                        <span class="text-[10px] text-gray-500">Foto saat ini</span>
                                    </div>
                                @endif
                            </div>
                            <x-admin.input label="Email" type="email" name="content[hr_department][members][{{ $index }}][email]" :value="$member['email'] ?? ''" placeholder="email@terang.id" />
                            <x-admin.input label="No. Telepon" name="content[hr_department][members][{{ $index }}][phone]" :value="$member['phone'] ?? ''" placeholder="+62 812-3456-7890" />
                            <x-admin.input label="LinkedIn" name="content[hr_department][members][{{ $index }}][linkedin]" :value="$member['social']['linkedin'] ?? ''" placeholder="https://linkedin.com/in/username" />
                            <x-admin.input label="Instagram" name="content[hr_department][members][{{ $index }}][instagram]" :value="$member['social']['instagram'] ?? ''" placeholder="@username" icon="fab fa-instagram text-pink-500" />
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Departemen</label>
                                <select name="content[hr_department][members][{{ $index }}][department]"
                                        class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                                    <option value="">Pilih Departemen</option>
                                    <option value="HCM Manager" {{ ($member['department'] ?? '') == 'HCM Manager' ? 'selected' : '' }}>HCM Manager</option>
                                    <option value="Digital Technology" {{ ($member['department'] ?? '') == 'Digital Technology' ? 'selected' : '' }}>Digital Technology</option>
                                    <option value="Personalia" {{ ($member['department'] ?? '') == 'Personalia' ? 'selected' : '' }}>Personalia</option>
                                    <option value="Legal" {{ ($member['department'] ?? '') == 'Legal' ? 'selected' : '' }}>Legal</option>
                                    <option value="HR Comben DM" {{ ($member['department'] ?? '') == 'HR Comben DM' ? 'selected' : '' }}>HR Comben DM</option>
                                    <option value="HR Comben" {{ ($member['department'] ?? '') == 'HR Comben' ? 'selected' : '' }}>HR Comben</option>
                                    <option value="HR Recruitment" {{ ($member['department'] ?? '') == 'HR Recruitment' ? 'selected' : '' }}>HR Recruitment</option>
                                    <option value="General Affairs" {{ ($member['department'] ?? '') == 'General Affairs' ? 'selected' : '' }}>General Affairs</option>
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <x-admin.textarea label="Bio Singkat" name="content[hr_department][members][{{ $index }}][bio]" rows="2" :value="$member['bio'] ?? ''" placeholder="Deskripsi singkat tentang anggota tim..." />
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-3 flex items-start gap-2 text-[11px] text-gray-500 bg-indigo-50/50 border border-indigo-100 rounded-lg px-3 py-2.5">
                    <i class="fas fa-info-circle text-indigo-400 mt-0.5"></i>
                    <span>Field bertanda <span class="text-red-500">*</span> wajib diisi. Format foto: JPG, PNG, WebP. Maks 2MB.</span>
                </div>
            </div>
        </x-admin.content-section>

        <x-admin.content-section icon="fa-info-circle" icon-bg="bg-green-600" title="Seksi Tentang Kami" desc="Sejarah, visi, dan misi perusahaan">
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fas fa-history text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <x-admin.textarea label="Sejarah Kami" name="content[about_us][history_text]" rows="3" :value="$content['about_us']['history_text'] ?? ''" placeholder="Ceritakan sejarah singkat perusahaan..." />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-eye text-green-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <x-admin.textarea label="Visi" name="content[about_us][vision_text]" rows="2" :value="$content['about_us']['vision_text'] ?? ''" placeholder="Visi perusahaan..." />
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-bullseye text-green-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <x-admin.textarea label="Misi" name="content[about_us][mission_text]" rows="4" :value="$missionValue" placeholder="Masukkan poin misi, satu per baris..." />
                            <p class="text-[11px] text-gray-500 mt-1">Pisahkan setiap poin misi dengan enter (satu baris = satu poin)</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-admin.content-section>

        <x-admin.content-section icon="fa-briefcase" icon-bg="bg-orange-600" title="Seksi Lingkup Bisnis" desc="Kelola kartu bisnis perusahaan">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-admin.input label="Judul Section" name="content[business_scope][title]" :value="$content['business_scope']['title'] ?? 'Scope Bisnis'" placeholder="Scope Bisnis" />
                <x-admin.textarea label="Deskripsi Section" name="content[business_scope][description]" rows="2" :value="$content['business_scope']['description'] ?? 'Lini Bisnis Kami'" placeholder="Deskripsi singkat..." />
            </div>

            <div class="pt-3 border-t border-gray-100">
                <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-2">Kartu Bisnis</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    @foreach(['Wrapping' => 1, 'F&B (Food & Beverage)' => 2, 'Minimarket' => 3, 'Reflexology' => 4, 'Celluler' => 5] as $label => $num)
                    <div class="border border-gray-200 rounded-lg p-2.5 bg-white hover:border-orange-200 transition-all">
                        <div class="flex items-center gap-1.5 mb-1.5">
                            <div class="w-4 h-4 bg-orange-600 rounded flex items-center justify-center">
                                <span class="text-white font-bold text-[8px]">{{ $num }}</span>
                            </div>
                            <h4 class="text-[11px] font-medium text-gray-900">{{ $label }}</h4>
                        </div>
                        <div class="space-y-1.5">
                            <x-admin.input label="Judul Kartu" name="content[business_scope][card{{ $num }}_title]" :value="$content['business_scope']['card'.$num.'_title'] ?? ''" placeholder="Judul..." />
                            <x-admin.textarea label="Deskripsi" name="content[business_scope][card{{ $num }}_desc]" rows="1" :value="$content['business_scope']['card'.$num.'_desc'] ?? ''" placeholder="Deskripsi singkat..." />
                            <x-admin.textarea label="Poin-poin" name="content[business_scope][card{{ $num }}_list]" rows="1" :value="$cardLists[$num]" placeholder="• Poin 1&#10;• Poin 2" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </x-admin.content-section>

        <div class="bg-gradient-to-br from-indigo-50 to-white rounded-xl border border-indigo-100 p-5">
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:ring-4 focus:ring-indigo-200 transition-all hover:shadow-md flex items-center justify-center gap-2 text-sm">
                <i class="fas fa-save"></i>
                <span>Simpan Semua Perubahan</span>
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('membersContainer');
    const addBtn = document.getElementById('addMemberBtn');
    let memberIndex = parseInt(container.dataset.initialCount, 10) || 0;

    function createMemberHtml(index) {
        return `
            <div class="member-item border border-gray-200 rounded-lg p-4 bg-white hover:border-gray-300 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="member-number text-xs font-semibold text-indigo-700">${index + 1}</span>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900">Anggota Tim</h4>
                    </div>
                    <button type="button" class="removeMemberBtn text-red-400 hover:text-red-600 hover:bg-red-50 px-2 py-1 rounded text-xs transition-colors flex items-center gap-1">
                        <i class="fas fa-trash-alt text-[10px]"></i>
                        <span>Hapus</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="content[hr_department][members][${index}][name]"
                               class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Nama anggota...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="content[hr_department][members][${index}][role]"
                               class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="HR Manager, Recruiter...">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Foto <span class="text-red-500">*</span></label>
                        <input type="file" name="content[hr_department][members][${index}][photo_file]"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="block w-full text-xs text-gray-900 border border-gray-200 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-3 file:py-1.5 file:px-3 file:rounded-l-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="content[hr_department][members][${index}][email]"
                               class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="email@srtcorp.com">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="content[hr_department][members][${index}][phone]"
                               placeholder="+62 812-3456-7890"
                               class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1"><i class="fab fa-linkedin text-blue-600"></i> LinkedIn</label>
                        <input type="text" name="content[hr_department][members][${index}][linkedin]"
                               placeholder="https://linkedin.com/in/username"
                               class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1"><i class="fab fa-instagram text-pink-500"></i> Instagram</label>
                        <input type="text" name="content[hr_department][members][${index}][instagram]"
                               placeholder="@username"
                               class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Departemen</label>
                        <select name="content[hr_department][members][${index}][department]"
                                class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                            <option value="">Pilih Departemen</option>
                            <option value="HCM Manager">HCM Manager</option>
                            <option value="Digital Technology">Digital Technology</option>
                            <option value="Personalia">Personalia</option>
                            <option value="Legal">Legal</option>
                            <option value="HR Comben DM">HR Comben DM</option>
                            <option value="HR Comben">HR Comben</option>
                            <option value="HR Recruitment">HR Recruitment</option>
                            <option value="General Affairs">General Affairs</option>
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Bio Singkat</label>
                        <textarea name="content[hr_department][members][${index}][bio]" rows="2"
                                  class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                  placeholder="Deskripsi singkat tentang anggota tim..."></textarea>
                    </div>
                </div>
            </div>
        `;
    }

    addBtn.addEventListener('click', function() {
        container.insertAdjacentHTML('beforeend', createMemberHtml(memberIndex));
        memberIndex++;
        updateMemberNumbers();
    });

    container.addEventListener('click', function(e) {
        const btn = e.target.closest('.removeMemberBtn');
        if (btn && container.children.length > 1) {
            btn.closest('.member-item').remove();
            updateMemberNumbers();
        }
    });

    function updateMemberNumbers() {
        container.querySelectorAll('.member-number').forEach((el, i) => el.textContent = i + 1);
    }
});
</script>
@endpush
