@extends('layouts.admin')

@section('title', 'Kelola Gambar Website')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Kelola Gambar Website</h1>

    <form action="{{ route('admin.images.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white p-8 rounded-lg shadow-md space-y-12">
            
            <!-- Gambar Utama per Seksi -->
            <div class="space-y-6">
                <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3">Gambar Utama Halaman</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Hero Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Hero</label>
                        <img src="{{ asset('storage/' . ($images['hero']->content_value ?? '')) }}" alt="Preview Gambar Hero" class="mt-2 h-32 w-full object-cover rounded-md border">
                        <input type="file" name="hero_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-slate-100">
                    </div>
                    <!-- HR Dept Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Departemen HR</label>
                        <img src="{{ asset('storage/' . ($images['hr_department']->content_value ?? '')) }}" alt="Preview Gambar HR" class="mt-2 h-32 w-full object-cover rounded-md border">
                        <input type="file" name="hr_department_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-slate-100">
                    </div>
                    <!-- About Us Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Tentang Kami</label>
                        <img src="{{ asset('storage/' . ($images['about_us']->content_value ?? '')) }}" alt="Preview Gambar Tentang Kami" class="mt-2 h-32 w-full object-cover rounded-md border">
                        <input type="file" name="about_us_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-slate-100">
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t">
                <button type="submit" class="px-8 py-3 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Simpan Perubahan Gambar Utama
                </button>
            </div>
        </div>
    </form>

    <!-- Galeri Perusahaan -->
    <div class="mt-12 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3 mb-6">Kelola Galeri Perusahaan</h2>
        <!-- Form Upload -->
        <form action="{{ route('admin.images.update') }}" method="POST" enctype="multipart/form-data" class="mb-8 p-4 border rounded-md">
            @csrf
            <h3 class="font-medium mb-4">Unggah Gambar Baru ke Galeri</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="gallery_alt_text" class="block text-sm font-medium text-gray-700">Deskripsi Gambar</label>
                    <input type="text" name="gallery_alt_text" id="gallery_alt_text" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="gallery_image" class="block text-sm font-medium text-gray-700">Pilih File</label>
                    <input type="file" name="gallery_image" id="gallery_image" required accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-slate-100">
                </div>
                <div class="self-end">
                    <button type="submit" class="w-full px-4 py-2 text-white bg-green-600 rounded-md hover:bg-green-700">Unggah ke Galeri</button>
                </div>
            </div>
        </form>
        <!-- Tampilan Galeri -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($galleryImages as $img)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $img->file_path) }}" alt="{{ $img->alt_text }}" class="w-full h-48 object-cover rounded-lg shadow-md">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all flex items-center justify-center">
                        <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus gambar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-trash fa-2x"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Galeri masih kosong.</p>
            @endforelse
        </div>
    </div>
@endsection
