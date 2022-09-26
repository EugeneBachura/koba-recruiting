<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailUpdate extends Controller
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
            'email' => 'required|string|email|max:255|unique:users',
            're-email' => 'required|same:email',
        ]);

        $user = Auth::user();

        $user->update([
            'email' => $request->email,
        ]);

        return redirect()->back()->withSuccess('Email updated successfully');
    }
}
