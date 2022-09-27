<?php

use App\Http\Controllers\DownloadCV;
use App\Http\Controllers\HistoryCV;
use App\Http\Controllers\EmailUpdate;
use App\Http\Controllers\PasswordUpdate;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferFilterController;
use App\Http\Controllers\ResponseController;
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
            'user' => $user_data->only(['id', 'first_name', 'last_name', 'user_email']),
        ]);
    }
    /* Recruiter */
    if (Auth::user()->hasRole('recruiter')) {
        $user_data = Recruiter::where('user_id', Auth::user()->id)->first();
        return view('dashboard/main', [
            'user' => $user_data->only(['id', 'first_name', 'last_name', 'user_email']),
        ]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

/* Profile */
Route::resource('profile', ProfileController::class)->middleware(['auth', 'verified'])->only([
    'index', 'update', 'show'
]);
Route::put('/email-update', [EmailUpdate::class, 'update'])->middleware(['auth', 'verified'])->name('email-update');
Route::put('/password-update', [PasswordUpdate::class, 'update'])->middleware(['auth', 'verified'])->name('password-update');

/* Offers */
Route::resource('offers', OfferController::class)->middleware(['auth', 'verified'])->only([
    'index', 'create', 'store',  'show', 'edit', 'update', 'destroy'
]);
Route::get('/my-offers/{id}', [OfferFilterController::class, 'myOffers'])->middleware(['auth', 'verified'])->name('my_offers');

/* Responses */
Route::resource('responses', ResponseController::class)->middleware(['auth', 'verified'])->only([
    'index', 'store', 'show', 'update'
]);

/* CV */
Route::get('/cv/history', [HistoryCV::class, 'index'])->middleware(['auth', 'verified'])->name('history-cv');
Route::get('/cv/{id}', [DownloadCV::class, 'downloadById'])->middleware(['auth', 'verified'])->name('download-cv');

require __DIR__ . '/auth.php';
