<?php

use App\Models\Candidate;
use App\Models\Recruiter;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('main');

/* Main dashboard */
Route::get('/dashboard', function () {
    /* Candidate */
    if (Auth::user()->hasRole('candidate')) {
        $user_data = Candidate::where('user_id', Auth::user()->id)->first();
        return view('dashboard/main', [
            'user' => $user_data->only(['first_name', 'last_name', 'user_email']),
        ]);
    }
    /* Recruiter */
    if (Auth::user()->hasRole('recruiter')) {
        $user_data = Recruiter::where('user_id', Auth::user()->id)->first();
        return view('dashboard/main', [
            'user' => $user_data->only(['first_name', 'last_name', 'user_email']),
        ]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

/* Profile */
Route::get('/profile', function () {
    /* Candidate */
    if (Auth::user()->hasRole('candidate')) {
        $user_data = Candidate::where('user_id', Auth::user()->id)->first();
        return view('dashboard/profile', [
            'user' => $user_data->only(['first_name', 'last_name', 'date_of_birth', 'interests', 'education', 'skills', 'telephone', 'cv_link', 'user_email', 'updated_at']),
        ]);
    }
    /* Recruiter */
    if (Auth::user()->hasRole('recruiter')) {
        $user_data = Recruiter::where('user_id', Auth::user()->id)->first();
        return view('dashboard/profile', []);
    }
})->middleware(['auth', 'verified'])->name('profile');


require __DIR__ . '/auth.php';
