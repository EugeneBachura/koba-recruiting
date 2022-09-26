<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Recruiter;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|numeric|regex:/[1,2]/',
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        /* Check for role */
        if (!DB::table('roles')->where('name', 'candidate')->first()) {
            Role::create(['name' => 'candidate']);
        }
        if (!DB::table('roles')->where('name', 'recruiter')->first()) {
            Role::create(['name' => 'recruiter']);
        }

        event(new Registered($user));

        /* Getting role */
        if ($request->role == 1) {
            $user->assignRole('candidate');
            Candidate::create([
                'user_id' => $user->id,
                'first_name' => ucfirst(strtolower($request->first_name)),
                'last_name' => ucfirst(strtolower($request->last_name)),
                'user_email' => $user->email,
            ]);
        }
        if ($request->role == 2) {
            $user->assignRole('recruiter');
            Recruiter::create([
                'user_id' => $user->id,
                'first_name' => ucfirst(strtolower($request->first_name)),
                'last_name' => ucfirst(strtolower($request->last_name)),
                'user_email' => $user->email,
            ]);
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
