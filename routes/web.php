<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\HrdController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/test', function() {
    return 'Server berjalan';
});

// Route untuk serve CV files
Route::get('/storage/cv/{filename}', function ($filename) {
    $path = storage_path('app/public/cv/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('cv.show');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('jobs.search');
Route::get('/job/{id}', [HomeController::class, 'showJob'])->name('jobs.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Pelamar Routes
|--------------------------------------------------------------------------
*/
Route::prefix('pelamar')->name('pelamar.')->middleware(['auth', 'role:pelamar'])->group(function () {
    Route::get('/dashboard', [PelamarController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PelamarController::class, 'profile'])->name('profile');
    Route::put('/profile', [PelamarController::class, 'updateProfile'])->name('profile.update');
    Route::get('/applications', [PelamarController::class, 'applications'])->name('applications');
    Route::post('/apply/{jobId}', [PelamarController::class, 'apply'])->name('apply');
    Route::delete('/application/{id}/cancel', [PelamarController::class, 'cancelApplication'])->name('application.cancel');
});

/*
|--------------------------------------------------------------------------
| HRD Routes
|--------------------------------------------------------------------------
*/
Route::prefix('hrd')->name('hrd.')->middleware(['auth', 'role:hrd'])->group(function () {
    Route::get('/dashboard', [HrdController::class, 'dashboard'])->name('dashboard');

    // Company Profile
    Route::get('/company', [HrdController::class, 'companyProfile'])->name('company');
    Route::get('/company/create', [HrdController::class, 'createCompany'])->name('company.create');
    Route::post('/company', [HrdController::class, 'storeCompany'])->name('company.store');
    Route::put('/company', [HrdController::class, 'updateCompany'])->name('company.update');

    // Job Management
    Route::get('/jobs', [HrdController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create', [HrdController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [HrdController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [HrdController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}', [HrdController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{id}', [HrdController::class, 'deleteJob'])->name('jobs.delete');

    // Applicant Management
    Route::get('/applicants/{jobId?}', [HrdController::class, 'applicants'])->name('applicants');
    Route::get('/applicant/{id}', [HrdController::class, 'showApplicant'])->name('applicant.show');
    Route::put('/applicant/{id}/status', [HrdController::class, 'updateApplicationStatus'])->name('applicant.status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Company Verification
    Route::get('/companies', [AdminController::class, 'companies'])->name('companies');
    Route::get('/companies/pending', [AdminController::class, 'pendingCompanies'])->name('companies.pending');
    Route::post('/companies/{id}/approve', [AdminController::class, 'approveCompany'])->name('companies.approve');
    Route::post('/companies/{id}/reject', [AdminController::class, 'rejectCompany'])->name('companies.reject');
    Route::get('/companies/{id}/edit', [AdminController::class, 'editCompany'])->name('companies.edit');
    Route::put('/companies/{id}', [AdminController::class, 'updateCompany'])->name('companies.update');
    Route::delete('/companies/{id}', [AdminController::class, 'destroyCompany'])->name('companies.destroy');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Job Management
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs');

    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // HRD List
    Route::get('/hrd', [AdminController::class, 'hrdList'])->name('hrd');

    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

