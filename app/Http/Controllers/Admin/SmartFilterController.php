<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use App\Services\GroqAiService;

class SmartFilterController extends Controller
{
    protected $groqService;

    public function __construct(GroqAiService $groqService)
    {
        $this->groqService = $groqService;
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id'
        ]);

        $job = Job::findOrFail($request->job_id);

        // Fetch candidates. To keep tokens low, let's fetch all candidates from Talent Pool or those who applied to this job.
        // For demonstration, let's fetch top 50 users who have a UserProfile and role='user'.
        $users = User::where('role', 'user')->whereHas('profile')->with('profile')->take(50)->get();

        $candidateData = [];
        foreach ($users as $user) {
            $profile = $user->profile;
            $candidateData[] = [
                'id' => $user->id,
                'name' => $user->name,
                'education' => $profile->education_level . ' in ' . $profile->major,
                'experience' => rtrim($profile->last_position . ' at ' . $profile->last_company . ' (' . $profile->last_company_duration . ')'),
                'skills' => $profile->skills,
                'summary' => $profile->about_me
            ];
        }

        if (empty($candidateData)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada kandidat untuk dianalisis.']);
        }

        $jobRequirements = strip_tags($job->requirement . ' ' . $job->jobdesk);

        $results = $this->groqService->analyzeCandidates($job->title, $jobRequirements, $candidateData);

        if (empty($results)) {
             return response()->json(['success' => false, 'message' => 'Gagal menghubungi AI Server atau AI mengembalikan format yang salah.']);
        }

        // Map results back to User models
        $finalCandidates = [];
        foreach ($results as $res) {
            if (isset($res['id'])) {
                $user = User::with('profile')->find($res['id']);
                if ($user) {
                    $finalCandidates[] = [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'photo' => $user->profile?->photo_path ? asset('storage/' . $user->profile?->photo_path) : null,
                        'match_score' => intval($res['match_score'] ?? 0),
                        'reasoning' => $res['reasoning'] ?? '',
                        'last_position' => $user->profile?->last_position ?? 'Tidak dipaparkan',
                    ];
                }
            }
        }

        // Sort descending locally to ensure correct order
        usort($finalCandidates, function($a, $b) {
            return $b['match_score'] <=> $a['match_score'];
        });

        return response()->json([
            'success' => true,
            'job_title' => $job->title,
            'candidates' => $finalCandidates
        ]);
    }
}
