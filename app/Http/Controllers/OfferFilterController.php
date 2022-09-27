<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferFilterController extends Controller
{
    public function myOffers($id) //show only this recruiter's offers for edit or delete
    {
        $user_id = Auth::user()->id;
        $user_data = null;
        if ((Auth::user()->hasRole('recruiter')) && (Recruiter::where('user_id', $user_id)->first()->id == $id)) {
            $user_data = Recruiter::where('id', $id)->first();
        } else {
            return abort(404);
        }
        return view('dashboard/offers/show_my', [
            'user' => $user_data->only(['id', 'first_name', 'last_name', 'photo', 'user_email', 'firm_name']),
            'offers' => Offer::where('recruiter_id', $user_data->id)->orderBy('updated_at', 'DESC')->paginate(10),
        ]);
    }
}
