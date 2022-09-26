<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidate;
use App\Models\Recruiter;
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
                'user' => $user_data->only(['id', 'first_name', 'last_name', 'date_of_birth', 'photo', 'about', 'interests', 'education', 'skills', 'telephone', 'cv', 'user_email', 'updated_at']),
                'id' => Auth::user()->id
            ]);
        }
        /* Recruiter */
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', Auth::user()->id)->first();
            return view('dashboard/profile', []);
        }
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
        //
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
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'date_of_birth' => ['string', 'nullable', 'date_format:d/m/Y', 'before:today'],
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'about' => 'string|max:255|nullable',
            'interests' => 'string|max:255|nullable',
            'education' => 'string|max:255|nullable',
            'skills' => 'string|max:255|nullable',
            'telephone' => 'string|max:11|nullable',
            'cv' => 'file|mimes:pdf,doc,docx|max:2048|nullable',
        ]);

        $candidate = Candidate::where('id', $id)->first();

        if ($request->hasFile('photo')) {
            $path = Storage::putFile('public/avatars', $request->file('photo'));
            $photo = Candidate::where('id', $id)->first()->photo;
            if (!is_null($photo) && Storage::exists($photo)) { // delete old photo
                Storage::delete($photo);
            }
            $candidate->update([
                'photo' => $path,
            ]);
        }

        if ($request->hasFile('cv')) {
            $path = Storage::putFile('public/cv', $request->file('cv'));
            $candidate->update([
                'cv' => $path,
            ]);
        }

        if ($request->date_of_birth == null) { // format date
            $birth = null;
        } else {
            $birth = date_create_from_format('!d/m/Y', $request->date_of_birth);
        };

        $candidate->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $birth,
            'about' => $request->about,
            'interests' => $request->interests,
            'education' => $request->education,
            'skills' => $request->skills,
            'telephone' => $request->telephone
        ]);
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
