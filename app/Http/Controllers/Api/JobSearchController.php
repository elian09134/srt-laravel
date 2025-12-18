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
        if (!empty($q)) {
            $query->where(function ($qry) use ($q) {
                $qry->where('title', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%");
            });
        }
        $jobs = $query->latest()->limit(20)->get(['id','title','location','type','salary_range']);

        return response()->json([
            'data' => $jobs,
        ]);
    }
}
