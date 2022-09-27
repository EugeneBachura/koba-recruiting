<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HistoryCV extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('candidate')) {
            $user_data = Candidate::where('user_id', $user->id)->first();
            return view('dashboard/history-cv', [
                'user' => $user_data->only(['id', 'first_name', 'last_name', 'photo', 'user_email', 'cv', 'cv_history']),
            ]);
        } else {
            abort(404);
        }
    }

    public function download($num)
    {
        $user = Auth::user();
        if ($user->hasRole('candidate')) {
            $user_data = Candidate::where('user_id', $user->id)->first();
            $cv_history = json_decode($user_data->cv_history, true);
            $cv_history = array_reverse($cv_history);
            $cv = $cv_history[$num - 1];
            return Storage::download($cv['path'], $cv['name']);
        } else {
            abort(404);
        }
    }
}
