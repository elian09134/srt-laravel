<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the current user's applications.
     */
    public function index()
    {
        $user = Auth::user();

        $applications = $user->applications()->with('job')->latest()->paginate(10);

        return view('applications.index', compact('applications'));
    }

    /**
     * Display the specified application for the current user.
     */
    public function show(Application $application)
    {
        $user = Auth::user();

        if ($application->user_id !== $user->id) {
            abort(403);
        }

        $application->load('job');

        return view('applications.show', compact('application'));
    }
}
