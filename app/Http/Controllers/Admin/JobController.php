<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJobRequest;
use App\Http\Requests\Admin\UpdateJobRequest;
use App\Models\Job;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->paginate(20);

        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fptks = \App\Models\Fptk::where('status', 'approved')
            ->whereDoesntHave('job')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.jobs.form', compact('fptks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request, FileUploadService $fileUploadService)
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $fileUploadService->storePublicImage($request->file('image'), 'jobs');
        }

        Job::create([
            'title' => $validated['title'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'salary_range' => $validated['salary_range'] ?? null,
            'jobdesk' => $validated['jobdesk'],
            'requirement' => json_encode(array_values(array_filter(array_map('trim', explode("\n", $validated['requirement'] ?? ''))))),
            'benefits' => json_encode(array_values(array_filter(array_map('trim', explode("\n", $validated['benefits'] ?? ''))))),
            'fptk_id' => $validated['fptk_id'] ?? null,
            'image' => $imagePath,
            'show_image' => $request->has('show_image'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $fptks = \App\Models\Fptk::where('status', 'approved')
            ->where(function ($q) use ($job) {
                $q->whereDoesntHave('job')
                    ->orWhere('id', $job->fptk_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.jobs.form', compact('job', 'fptks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job, FileUploadService $fileUploadService)
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'salary_range' => $validated['salary_range'] ?? null,
            'jobdesk' => $validated['jobdesk'],
            'requirement' => json_encode(array_values(array_filter(array_map('trim', explode("\n", $validated['requirement'] ?? ''))))),
            'benefits' => json_encode(array_values(array_filter(array_map('trim', explode("\n", $validated['benefits'] ?? ''))))),
            'fptk_id' => $validated['fptk_id'] ?? null,
            'show_image' => $request->has('show_image'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : false,
        ];

        if ($request->hasFile('image')) {
            $fileUploadService->deleteFile($job->image, ['public']);
            $data['image'] = $fileUploadService->storePublicImage($request->file('image'), 'jobs');
        }

        $job->update($data);

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil dihapus.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $job->load(['applications.user.profile']);

        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Toggle the active state via AJAX or direct request.
     */
    public function toggleActive(Request $request, Job $job)
    {
        $job->is_active = ! $job->is_active;
        $job->save();

        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => true,
                'is_active' => (bool) $job->is_active,
                'status_label' => $job->is_active ? 'Aktif' : 'Non-Aktif',
                'message' => 'Status lowongan "' . $job->title . '" berhasil diubah menjadi ' . ($job->is_active ? 'Aktif' : 'Non-Aktif') . '.',
            ]);
        }

        return redirect()->back()->with('success', 'Status lowongan "' . $job->title . '" berhasil diubah menjadi ' . ($job->is_active ? 'Aktif' : 'Non-Aktif') . '.');
    }
}
