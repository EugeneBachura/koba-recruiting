<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Offer;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_data = null;
        if (Auth::user()->hasRole('candidate')) {
            $user_data = Candidate::where('user_id', $user_id)->first();
        }
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', $user_id)->first();
        }
        return view('dashboard/offers/index', [
            'user' => $user_data->only(['id', 'first_name', 'last_name', 'photo', 'user_email']),
            'offers' => Offer::where('active', 1)->orderBy('created_at', 'ASC')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $user_data = null;
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', $user_id)->first();
        } else {
            return abort(404);
        }
        return view('dashboard/offers/create', [
            'user' => $user_data->only(['id', 'first_name', 'last_name', 'photo', 'user_email']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', $user_id)->first();
        } else {
            return abort(404);
        }

        /* Validate the data */
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255|min:3',
            'level' => 'string|max:255|nullable',
            'description' => 'required|string|max:65535|min:3',
            'skills' => 'string|max:255|nullable',
            'active' => 'required|boolean',
            'duration' => ['required', 'string', 'nullable', 'date_format:Y-m-d', 'after:today'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        };

        $offer = new Offer();
        $offer->position = $request->position;
        $offer->level = $request->level;
        $offer->description = $request->description;
        $offer->skills = $request->skills;
        $offer->active = $request->active;
        $offer->duration = $request->duration;
        $offer->recruiter_id = $user_data->id;
        $offer->save();

        return redirect()->back()->withSuccess('Offer created successfully');
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
    public function edit($id)
    {
        $user_id = Auth::user()->id;
        $user_data = null;
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', $user_id)->first();
        } else {
            return abort(404);
        }
        if (Offer::where('id', $id)->where('recruiter_id', $user_data->id)->exists()) {
            return view('dashboard/offers/edit', [
                'user' => $user_data->only(['id', 'first_name', 'last_name', 'photo', 'user_email']),
                'offer' => Offer::where('id', $id)->where('recruiter_id', $user_data->id)->first(),
            ]);
        } else {
            return abort(404);
        }
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
        if (Offer::where('id', $id)->exists()) { //check if offer exists
            $offer = Offer::find($id);
            if ($offer->recruiter_id === Recruiter::where('user_id', Auth::user()->id)->first()->id) { // update only this recruiter's offers

                /* Validate the data */
                $validator = Validator::make($request->all(), [
                    'position' => 'required|string|max:255|min:3',
                    'level' => 'string|max:255|nullable',
                    'description' => 'required|string|max:65535|min:3',
                    'skills' => 'string|max:255|nullable',
                    'active' => 'required|boolean',
                    'duration' => ['required', 'string', 'nullable', 'date_format:Y-m-d', 'after:today'],
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                };

                /* Update */
                $offer->position = $request->position;
                $offer->level = $request->level;
                $offer->description = $request->description;
                $offer->skills = $request->skills;
                $offer->active = $request->active;
                $offer->duration = $request->duration;
                $offer->save();

                return redirect()->back()->withSuccess('Offer updated successfully');
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Offer::where('id', $id)->exists()) { //check if offer exists
            $offer = Offer::find($id);
            if ($offer->recruiter_id === Recruiter::where('user_id', Auth::user()->id)->first()->id) { // delete only created by this recruiter
                $offer->delete();
                return redirect()->back()->withSuccess('Offer deleted successfully');
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }
}
