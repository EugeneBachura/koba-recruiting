<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class PasswordUpdate extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'new_password' => ['required', Rules\Password::defaults()],
            'password' => 'required',
            'confirmed' => 'required|same:new_password',
        ]);
        $user = Auth::user();
        if (Hash::check($request->password, Auth::user()->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->back()->withSuccess('Password updated successfully');
        } else {
            return redirect()->back()->withErrors(['wrong' => 'Incorrect current password']);;
        }
    }
}
