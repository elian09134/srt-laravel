<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ImageController;
// Employee invitations controller removed for recruitment-only site
// use App\Http\Controllers\Admin\EmployeeInvitationController;
use App\Http\Controllers\Auth\EmployeeRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AI\AgentController;

// Rute untuk halaman utama
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/karir', [PageController::class, 'karir'])->name('karir'); // Tambahkan baris ini
// Public job detail page
Route::get('/karir/{job}', [PageController::class, 'showJob'])->name('karir.show');
// Privacy policy
Route::view('/privacy', 'privacy')->name('privacy');
// Terms & Conditions
Route::view('/terms', 'terms')->name('terms');
// Submit application (user must be authenticated)
Route::post('/karir/{job}/apply', [App\Http\Controllers\ApplicationController::class, 'store'])->name('karir.apply')->middleware('auth');
// API: job search (AJAX)
Route::get('/api/jobs/search', [App\Http\Controllers\Api\JobSearchController::class, 'search'])->name('api.jobs.search');

// --- RUTE PENDAFTARAN KARYAWAN BARU ---
Route::get('/employee/register', [EmployeeRegisterController::class, 'showCodeForm'])->name('employee.register.code');
Route::post('/employee/register/verify', [EmployeeRegisterController::class, 'verifyCode'])->name('employee.register.verify');
Route::get('/employee/register/{code}', [EmployeeRegisterController::class, 'showRegistrationForm'])->name('employee.register.form');
Route::post('/employee/register', [EmployeeRegisterController::class, 'store'])->name('employee.register.store');

// --- RUTE UNTUK PENGGUNA YANG SUDAH LOGIN ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // User application history
    Route::get('/applications', [App\Http\Controllers\User\ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [App\Http\Controllers\User\ApplicationController::class, 'show'])->name('applications.show');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('jobs', JobController::class)->names('admin.jobs');
    // Toggle job active state via AJAX
    Route::patch('/jobs/{job}/toggle-active', [JobController::class, 'toggleActive'])->name('admin.jobs.toggleActive');
    Route::get('/content', [ContentController::class, 'edit'])->name('admin.content.edit');
    Route::post('/content', [ContentController::class, 'update'])->name('admin.content.update');
    Route::get('/images', [ImageController::class, 'index'])->name('admin.images.index');
    Route::post('/images', [ImageController::class, 'update'])->name('admin.images.update');
    Route::delete('/gallery/{gallery}', [ImageController::class, 'destroyGalleryImage'])->name('admin.gallery.destroy');
    // Employee invitation routes removed — site is recruitment-only
    // Route::get('/invitations', [EmployeeInvitationController::class, 'index'])->name('admin.invitations.index');
    // Route::post('/invitations', [EmployeeInvitationController::class, 'store'])->name('admin.invitations.store');
    Route::get('/applicants', [ApplicantController::class, 'index'])->name('admin.applicants.index');
    Route::get('/applicants/{application}', [ApplicantController::class, 'show'])->name('admin.applicants.show');
    Route::patch('/applicants/{application}/status', [ApplicantController::class, 'updateStatus'])->name('admin.applicants.updateStatus');
    Route::post('/applicants/{application}/talent-pool', [ApplicantController::class, 'addToTalentPool'])->name('admin.applicants.addToTalentPool');
    // Talent Pool management
    Route::get('/talent-pool', [App\Http\Controllers\Admin\TalentPoolController::class, 'index'])->name('admin.talent_pool.index');
    Route::get('/talent-pool/{talentPool}', [App\Http\Controllers\Admin\TalentPoolController::class, 'show'])->name('admin.talent_pool.show');
        // Employee management routes removed — site is recruitment-only
        // Route::resource('employees', App\Http\Controllers\Admin\EmployeeController::class)->only(['index', 'show'])->names('admin.employees');
});


// Memuat semua rute autentikasi dari Breeze
require __DIR__.'/auth.php';

// Rute untuk halaman dashboard - redirect berdasarkan role user
Route::get('/dashboard', function () {
    if (request()->user()?->role === 'admin') {
        return redirect('/admin');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// AI agent endpoint (web route returning JSON). Uses throttle to limit requests.
Route::post('/api/ai/agent/query', [AgentController::class, 'query'])->middleware('throttle:10,1');
