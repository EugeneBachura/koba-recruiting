<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Offer;
use App\Models\Recruiter;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
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
        /* Candidate */
        if (Auth::user()->hasRole('candidate')) {
            $user_data = Candidate::where('user_id', $user_id)->first();
            $responses = Response::where('candidate_id', $user_data->id)->orderBy('created_at', 'DESC')->paginate(10);
        }
        /* Recruiter */
        if (Auth::user()->hasRole('recruiter')) {
            $user_data = Recruiter::where('user_id', $user_id)->first();
            $responses = Response::where('recruiter_id', $user_data->id)->orderBy('created_at', 'DESC')->paginate(10);
        }
        return view('dashboard/response/index', [
            'user' => $user_data->only(['id', 'first_name', 'last_name', 'photo', 'user_email']),
            'responses' => $responses,
        ]);
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
        $user_id = Auth::user()->id;
        if (Auth::user()->hasRole('candidate')) {
            $user_data = Candidate::where('user_id', $user_id)->first();
        } else {
            return abort(404);
        }

        /* Validate the request */
        $validator = Validator::make($request->all(), [
            'offer' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        };

        /* Check if offer inactivated */
        if (!Offer::where('id', $request->offer)->where('active', 1)->exists()) {
            return redirect()->back()->withErrors(['offer' => 'Offer inactivated'])->withInput();
        }

        /* Check if the response exists */
        if (Response::where('offer_id', $request->offer)->where('candidate_id', $user_data->id)->exists()) {
            return redirect()->back()->withErrors(['response' => 'You have already responded to this offer.']);
        }

        $response = new Response();
        $response->candidate_id = $user_data->id;
        $response->offer_id = $request->offer;
        $response->recruiter_id = Offer::where('id', $request->offer)->first()->recruiter_id;
        $response->status = 'responded';
        $response->save();

        return redirect()->back()->withSuccess('Response successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Response::where('id', $id)->exists()) { //check if response exists
            return abort(404);
        }

        $user_id = Auth::user()->id;
        $user_data = null;
        $response = Response::where('id', $id)->first();

        /* Candidate */
        if (Auth::user()->hasRole('candidate')) {
            if (Candidate::where('user_id', $user_id)->first()->id != $response->candidate_id) {
                return abort(404);
            }
            $user_data = Candidate::where('user_id', $user_id)->first();
        }
        /* Recruiter */
        if (Auth::user()->hasRole('recruiter')) {
            if (Recruiter::where('user_id', $user_id)->first()->id != $response->recruiter_id) {
                return abort(404);
            }
            $user_data = Recruiter::where('user_id', $user_id)->first();
            if ($response->status == 'responded') {
                $response->status = 'viewed';
                $response->save();
            }
        }

        return view('dashboard/response/show', [
            'user' => $user_data->only(['id', 'first_name', 'last_name', 'photo', 'user_email']),
            'response' => $response,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        if (!Response::where('id', $id)->exists()) { //check if response exists
            return abort(404);
        }

        $user_id = Auth::user()->id;
        $response = Response::where('id', $id)->first();

        /* Recruiter */
        if (Auth::user()->hasRole('recruiter')) {
            if (Recruiter::where('user_id', $user_id)->first()->id != $response->recruiter_id) {
                return abort(404);
            }
        } else {
            return abort(404);
        }

        /* Validate the request */
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:denied,invited'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        };

        $response->status = $request->status;
        $response->save();

        return redirect()->back()->withSuccess('Response changed status successfully');
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
