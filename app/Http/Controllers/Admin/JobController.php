<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jobs.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string',
            'salary_range' => 'nullable|string|max:100',
            'jobdesk' => 'required|string',
            'requirement' => 'required|string',
            'benefits' => 'nullable|string',
        ]);

        Job::create([
            'title' => $validated['title'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'salary_range' => $validated['salary_range'],
            'jobdesk' => $validated['jobdesk'],
            'requirement' => json_encode(array_filter(array_map('trim', explode("\n", $validated['requirement'])))),
            'benefits' => json_encode(array_filter(array_map('trim', explode("\n", $validated['benefits'])))),
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        return view('admin.jobs.form', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'type' => 'required|string',
            'salary_range' => 'nullable|string|max:100',
            'jobdesk' => 'required|string',
            'requirement' => 'required|string',
            'benefits' => 'nullable|string',
        ]);

        $job->update([
            'title' => $validated['title'],
            'location' => $validated['location'],
            'type' => $validated['type'],
            'salary_range' => $validated['salary_range'],
            'jobdesk' => $validated['jobdesk'],
            'requirement' => json_encode(array_filter(array_map('trim', explode("\n", $validated['requirement'])))),
            'benefits' => json_encode(array_filter(array_map('trim', explode("\n", $validated['benefits'])))),
        ]);

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
     * Toggle the active state via AJAX.
     */
    public function toggleActive(Job $job)
    {
        $job->is_active = !$job->is_active;
        $job->save();

        return response()->json([
            'success' => true,
            'is_active' => (bool) $job->is_active,
        ]);
    }
}
