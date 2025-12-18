<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
