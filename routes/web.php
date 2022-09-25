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
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $user_id = $user->id;
    $role = $user->getRoleNames();
    $user_data = null;
    if ($user->hasRole('candidate')) {
        $user_data = Candidate::where('user_id', $user_id)->first();
    };
    if ($user->hasRole('recruiter')) {
        $user_data = Recruiter::where('user_id', $user_id)->first();
    };
    return view('dashboard/main', [
        'user' => $user_data->only(['first_name', 'last_name', 'firm_name', 'position', 'telephone', 'user_email']),
        'role' => $role,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
