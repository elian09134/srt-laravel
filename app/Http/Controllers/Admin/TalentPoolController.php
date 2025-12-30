<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TalentPool;
use Illuminate\Http\Request;

class TalentPoolController extends Controller
{
    public function index(Request $request)
    {
        $items = TalentPool::with(['user.workExperiences'])->latest()->paginate(20);

        return view('admin.talent_pool.index', [
            'items' => $items,
        ]);
    }

    public function show(TalentPool $talentPool)
    {
        $talentPool->load(['user.profile', 'user.workExperiences']);

        return view('admin.talent_pool.show', [
            'talent' => $talentPool,
            'user' => $talentPool->user,
            'profile' => $talentPool->user->profile,
            'workExperiences' => $talentPool->user->workExperiences,
        ]);
    }
}
