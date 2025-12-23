<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use App\Models\Gallery; // Tambahkan ini
use Illuminate\Http\Request;
use App\Models\Job;

class PageController extends Controller
{
    public function home()
    {
        // Mengambil 3 lowongan terbaru yang aktif
        $jobs = Job::where('is_active', 1)->latest()->take(3)->get();

        // Mengambil semua konten website dengan query yang lebih efisien
        $content_items = SiteContent::all();
        $content = $content_items->groupBy('section_name')
            ->map(function ($items) {
                return $items->pluck('content_value', 'content_key');
            })
            ->toArray();

        // Mengambil data galeri dengan caching
        $gallery = \Cache::remember('gallery_images', 3600, function () {
            return Gallery::latest()->take(4)->get();
        });

        // Mengirim semua data ke view
        return view('home', [
            'jobs' => $jobs,
            'content' => $content,
            'gallery' => $gallery, // Kirim data galeri ke view
        ]);
    }

    public function karir(Request $request)
    {
        // Query dasar untuk mengambil lowongan
        $query = Job::where('is_active', 1);

        // Terapkan filter jika ada
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('location') && $request->location != 'all') {
            $query->where('location', $request->location);
        }

        $jobs = $query->latest()->get();

        // Mengambil daftar lokasi unik untuk dropdown filter
        $locations = Job::where('is_active', 1)->distinct()->pluck('location');

        return view('karir', [
            'jobs' => $jobs,
            'locations' => $locations
        ]);
    }

    public function showJob(Job $job)
    {
        return view('karir_show', [
            'job' => $job
        ]);
    }
}
