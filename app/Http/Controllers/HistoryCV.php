<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
