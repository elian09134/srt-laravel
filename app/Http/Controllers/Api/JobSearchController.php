<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobSearchController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $query = Job::query();
        if (! empty($q)) {
            $safeQ = \App\Support\Security::escapeLike($q);
            $query->where(function ($qry) use ($safeQ) {
                $qry->where('title', 'like', "%{$safeQ}%")
                    ->orWhere('location', 'like', "%{$safeQ}%")
                    ->orWhere('type', 'like', "%{$safeQ}%");
            });
        }
        $jobs = $query->latest()->limit(20)->get(['id', 'title', 'location', 'type', 'salary_range']);

        return response()->json([
            'data' => $jobs,
        ]);
    }
}
