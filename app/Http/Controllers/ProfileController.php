<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Candidate */
        if (Auth::user()->hasRole('candidate')) {
            $user_data = Candidate::where('user_id', Auth::user()->id)->first();
            return view('dashboard/profile', [
                'user' => $user_data->only(['id', 'first_name', 'last_name', 'date_of_birth', 'photo', 'about', 'interests', 'education', 'skills', 'telephone', 'cv', 'user_email'])
            ]);
        }
        /* Recruiter */
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', Auth::user()->id)->first();
            return view('dashboard/profile', [
                'user' => $user_data->only(['id', 'first_name', 'last_name', 'firm_name', 'photo', 'position', 'telephone', 'user_email']),
            ]);
        }
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //exist user
        if (!User::where('id', $id)->exists()) {
            return abort(404);
        }

        $user_show = User::where('id', $id)->first();
        $role = null;
        $user_show_data = null;
        if ($user_show->hasRole('candidate')) {
            $user_show_data = Candidate::where('user_id', $user_show->id)->first()->only(['id', 'first_name', 'last_name', 'date_of_birth', 'photo', 'about', 'interests', 'education', 'skills', 'telephone', 'cv', 'user_email']);
            $role = 'candidate';
        }
        if ($user_show->hasRole('recruiter')) {
            $user_show_data = Recruiter::where('user_id', $user_show->id)->first()->only(['id', 'first_name', 'last_name', 'firm_name', 'photo', 'position', 'telephone', 'user_email']);
            $role = 'recruiter';
        }

        /* Candidate */
        if (Auth::user()->hasRole('candidate')) {
            $user_data = Candidate::where('user_id', Auth::user()->id)->first();
            return view('dashboard/profile_by_id', [
                'user' => $user_data->only(['id', 'first_name', 'last_name', 'date_of_birth', 'photo', 'about', 'interests', 'education', 'skills', 'telephone', 'cv', 'user_email']),
                'profile' => $user_show_data,
                'role' => $role
            ]);
        }
        /* Recruiter */
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', Auth::user()->id)->first();
            return view('dashboard/profile_by_id', [
                'user' => $user_data->only(['id', 'first_name', 'last_name', 'firm_name', 'photo', 'position', 'telephone', 'user_email']),
                'profile' => $user_show_data,
                'role' => $role
            ]);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        /* Candidate update profile */
        if ($user->hasRole('candidate')) {
            $request->validate([
                'first_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
                'last_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
                'date_of_birth' => ['string', 'nullable', 'date_format:Y-m-d', 'before:today', 'after:1900-01-01'],
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
                'about' => 'string|max:255|nullable',
                'interests' => 'string|max:255|nullable',
                'education' => 'string|max:255|nullable',
                'skills' => 'string|max:255|nullable',
                'telephone' => 'string|max:11|nullable',
                'cv' => 'file|mimes:pdf,doc,docx|max:2048|nullable',
            ]);

            $user_data = Candidate::where('id', $id)->first();


            /* Upload CV */
            if ($request->hasFile('cv')) {
                $path = Storage::putFile('public/cv', $request->file('cv'));

                /* CV history */
                $cv_history = $user_data->cv_history;
                if ($cv_history == null) {
                    $cv_history = [];
                } else {
                    $cv_history = json_decode($cv_history);
                }
                if (count($cv_history) > 10) { //max 10 cv history
                    Storage::delete($cv_history[0]->path);
                    array_shift($cv_history);
                }
                $cv_history_data = [
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'path' => $path,
                    'size' => Storage::size($path),
                    'name' => $request->file('cv')->getClientOriginalName()
                ];
                $cv_history[] = $cv_history_data;
                /* End CV history */

                $user_data->update([
                    'cv' => $path,
                    'cv_history' => json_encode($cv_history)
                ]);
            }

            /* Format date of birth */
            if ($request->date_of_birth == null) {
                $birth = null;
            } else {
                $birth = $request->date_of_birth;
            };

            $user_data->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $birth,
                'about' => $request->about,
                'interests' => $request->interests,
                'education' => $request->education,
                'skills' => $request->skills,
                'telephone' => $request->telephone
            ]);
        };

        /* Recruiter update profile */
        if ($user->hasRole('recruiter')) {
            $request->validate([
                'first_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
                'last_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
                'firm_name' => 'string|max:255|nullable',
                'position' => 'string|max:255|nullable',
                'telephone' => 'string|max:11|nullable',
            ]);

            $user_data = Recruiter::where('id', $id)->first();

            $user_data->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'firm_name' => $request->firm_name,
                'position' => $request->position,
                'telephone' => $request->telephone
            ]);
        };

        /* Update photo */
        if ($request->hasFile('photo')) {
            $path = Storage::putFile('public/avatars', $request->file('photo'));
            $photo = $user_data->photo;
            if (!is_null($photo) && Storage::exists($photo)) { // delete old photo
                Storage::delete($photo);
            }
            $user_data->update([
                'photo' => $path,
            ]);
        }

        return redirect()->back()->withSuccess('Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
