<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\EmployeeInvitationController;
use App\Http\Controllers\Auth\EmployeeRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Rute untuk halaman utama
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/karir', [PageController::class, 'karir'])->name('karir'); // Tambahkan baris ini

// Rute untuk halaman dashboard (setelah login), kita arahkan ke halaman utama juga
Route::get('/dashboard', [PageController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');

// --- RUTE PENDAFTARAN KARYAWAN BARU ---
Route::get('/employee/register', [EmployeeRegisterController::class, 'showCodeForm'])->name('employee.register.code');
Route::post('/employee/register/verify', [EmployeeRegisterController::class, 'verifyCode'])->name('employee.register.verify');
Route::get('/employee/register/{code}', [EmployeeRegisterController::class, 'showRegistrationForm'])->name('employee.register.form');
Route::post('/employee/register', [EmployeeRegisterController::class, 'store'])->name('employee.register.store');

// --- RUTE UNTUK PENGGUNA YANG SUDAH LOGIN ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('jobs', JobController::class)->names('admin.jobs');
    Route::get('/content', [ContentController::class, 'edit'])->name('admin.content.edit');
    Route::post('/content', [ContentController::class, 'update'])->name('admin.content.update');
    Route::get('/images', [ImageController::class, 'index'])->name('admin.images.index');
    Route::post('/images', [ImageController::class, 'update'])->name('admin.images.update');
    Route::delete('/gallery/{gallery}', [ImageController::class, 'destroyGalleryImage'])->name('admin.gallery.destroy');
    Route::get('/invitations', [EmployeeInvitationController::class, 'index'])->name('admin.invitations.index');
    Route::post('/invitations', [EmployeeInvitationController::class, 'store'])->name('admin.invitations.store');
    Route::get('/applicants', [ApplicantController::class, 'index'])->name('admin.applicants.index');
    Route::patch('/applicants/{application}/status', [ApplicantController::class, 'updateStatus'])->name('admin.applicants.updateStatus');
    Route::post('/applicants/{application}/talent-pool', [ApplicantController::class, 'addToTalentPool'])->name('admin.applicants.addToTalentPool');
    Route::resource('employees', App\Http\Controllers\Admin\EmployeeController::class)->only(['index', 'show'])->names('admin.employees');
});


// Memuat semua rute autentikasi dari Breeze
require __DIR__.'/auth.php';
