@extends('layouts.admin')

@section('title', 'Kelola Konten Website')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Kelola Konten Halaman Utama</h1>
    
    <form action="{{ route('admin.content.update') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md space-y-12">
        @csrf
        
        <!-- Section: Hero -->
        <div class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3">Hero Section</h2>
            <div>
                <label for="hero_title" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="content[hero][title]" id="hero_title" value="{{ old('content.hero.title', $content['hero']['title'] ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label for="hero_description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="content[hero][description]" id="hero_description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content.hero.description', $content['hero']['description'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Section: Tentang Kami -->
        <div class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3">Seksi Tentang Kami</h2>
            <div>
                <label for="about_us_history_text" class="block text-sm font-medium text-gray-700">Sejarah Kami</label>
                <textarea name="content[about_us][history_text]" id="about_us_history_text" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content.about_us.history_text', $content['about_us']['history_text'] ?? '') }}</textarea>
            </div>
             <div>
                <label for="about_us_vision_text" class="block text-sm font-medium text-gray-700">Visi</label>
                <textarea name="content[about_us][vision_text]" id="about_us_vision_text" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content.about_us.vision_text', $content['about_us']['vision_text'] ?? '') }}</textarea>
            </div>
             <div>
                <label for="about_us_mission_text" class="block text-sm font-medium text-gray-700">Misi (satu per baris)</label>
                <textarea name="content[about_us][mission_text]" id="about_us_mission_text" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content.about_us.mission_text', isset($content['about_us']['mission_text']) ? implode("\n", json_decode($content['about_us']['mission_text'])) : '') }}</textarea>
            </div>
        </div>

        <!-- Section: Lingkup Bisnis -->
        <div class="space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3">Seksi Lingkup Bisnis</h2>
            <!-- Card 1 -->
            <div class="border p-4 rounded-md bg-slate-50 space-y-4">
                <h3 class="font-medium">Kartu 1: Pengembangan Teknologi</h3>
                <input type="text" name="content[business_scope][card1_title]" value="{{ old('content.business_scope.card1_title', $content['business_scope']['card1_title'] ?? '') }}" class="block w-full border-gray-300 rounded-md shadow-sm">
                <textarea name="content[business_scope][card1_desc]" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm">{{ old('content.business_scope.card1_desc', $content['business_scope']['card1_desc'] ?? '') }}</textarea>
                <textarea name="content[business_scope][card1_list]" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm" placeholder="Poin list (satu per baris)">{{ old('content.business_scope.card1_list', isset($content['business_scope']['card1_list']) ? implode("\n", json_decode($content['business_scope']['card1_list'])) : '') }}</textarea>
            </div>
            <!-- Card 2 & 3 (Lanjutkan dengan pola yang sama) -->
        </div>

        <div class="mt-8 pt-6 border-t">
            <button type="submit" class="w-full px-8 py-3 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
                Simpan Semua Perubahan
            </button>
        </div>
    </form>
@endsection
