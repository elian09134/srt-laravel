<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display the image management view.
     */
    public function index()
    {
        // Mengambil data gambar utama dari database
        $images = SiteContent::whereIn('section_name', ['hero', 'hr_department', 'about_us'])
            ->where('content_key', 'image')
            ->get()
            ->keyBy('section_name');

        $galleryImages = Gallery::latest()->get();

        return view('admin.images.index', compact('images', 'galleryImages'));
    }

    /**
     * Handle updating site images and gallery.
     */
    public function update(Request $request)
    {
        // Pemetaan dari nama input form ke nama seksi di database
        $imageMap = [
            'hero_image' => 'hero',
            'hr_department_image' => 'hr_department',
            'about_us_image' => 'about_us',
        ];

        foreach ($imageMap as $inputName => $sectionName) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                
                // Validasi file
                $request->validate([
                    $inputName => 'image|max:2048', // maks 2MB
                ]);

                try {
                    // Hapus gambar lama jika ada
                    $oldImage = SiteContent::where('section_name', $sectionName)->where('content_key', 'image')->first();
                    if ($oldImage && $oldImage->content_value && Storage::disk('public')->exists($oldImage->content_value)) {
                        Storage::disk('public')->delete($oldImage->content_value);
                    }

                    // Simpan gambar baru
                    $path = $file->store('images', 'public');
                    SiteContent::updateOrCreate(
                        ['section_name' => $sectionName, 'content_key' => 'image'],
                        ['content_value' => $path]
                    );
                } catch (\Exception $e) {
                    return back()->with('error', 'Gagal memperbarui gambar ' . $sectionName . ': ' . $e->getMessage());
                }
            }
        }

        // Handle gallery image upload
        if ($request->hasFile('gallery_image')) {
            $request->validate([
                'gallery_alt_text' => 'required|string|max:255',
                'gallery_image' => 'required|image|max:2048', // maks 2MB
            ]);

            try {
                $path = $request->file('gallery_image')->store('gallery', 'public');
                Gallery::create([
                    'file_path' => $path,
                    'alt_text' => $request->gallery_alt_text,
                ]);
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengunggah gambar galeri: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Gambar berhasil diperbarui.');
    }

    /**
     * Handle deleting a gallery image.
     */
    public function destroyGalleryImage(Gallery $gallery)
    {
        try {
            if (Storage::disk('public')->exists($gallery->file_path)) {
                Storage::disk('public')->delete($gallery->file_path);
            }
            $gallery->delete();
            return back()->with('success', 'Gambar galeri berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus gambar galeri: ' . $e->getMessage());
        }
    }
}
