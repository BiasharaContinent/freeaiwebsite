<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\AiResumeController; // Added AiResumeController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome'); // Or your desired landing page
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Resume Builder Routes (Protected by auth middleware)
Route::middleware(['auth'])->prefix('resumes')->name('resumes.')->group(function () {
    Route::get('/create', [ResumeController::class, 'create'])->name('create');
    Route::post('/', [ResumeController::class, 'store'])->name('store');
    Route::get('/{resume}/edit', [ResumeController::class, 'edit'])->name('edit');
    Route::put('/{resume}', [ResumeController::class, 'update'])->name('update');
    Route::delete('/{resume}', [ResumeController::class, 'destroy'])->name('destroy');

    // Routes for managing resume sections dynamically (e.g., adding a work experience via AJAX)
    // These might be more specific, e.g., /resumes/{resume}/work-experience
    // For simplicity, we'll assume main form submission handles this for now,
    // but for a better UX, dedicated AJAX routes for sub-resources are good.
});

// Fallback route for Vue/React SPA if you choose that path for frontend later (optional)
// Route::get('/{any}', function () {
//     return view('app'); // Assuming you have a single 'app.blade.php' for SPA
// })->where('any', '.*');

// Route to serve dynamic form partials
Route::get('/resume-partials/{partialName}', [ResumeController::class, 'getFormPartial'])->name('resumes.partials');

// Route for PDF download
Route::get('/{resume}/download-pdf', [ResumeController::class, 'downloadPdf'])->name('downloadPdf');

// AI Resume Builder Routes
Route::middleware(['auth'])->prefix('ai-builder')->name('ai.')->group(function () {
    Route::get('/upload-resume', [AiResumeController::class, 'showUploadForm'])->name('uploadForm');
    Route::post('/parse-resume', [AiResumeController::class, 'parseResume'])->name('parse');
    Route::get('/confirm-prefill', [AiResumeController::class, 'showConfirmPrefill'])->name('confirmPrefill');

    // Routes for AI content suggestions
    Route::post('/suggest-summary', [AiResumeController::class, 'suggestSummary'])->name('suggest.summary');
    Route::post('/suggest-bullets', [AiResumeController::class, 'suggestExperienceBullets'])->name('suggest.bullets');
});

// Admin Routes
Route::middleware(['auth', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Template Management Routes (will be created in next step)
    Route::resource('templates', App\Http\Controllers\Admin\TemplateController::class)->except(['show']);
    // We might not need a public 'show' for admin, list & edit is usually enough.

    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    // UserController does not have create/store enabled, but index, show, edit, update, destroy are used.

    // Analytics (Placeholder)
    // Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
});
