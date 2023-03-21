<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verify(Request $request){
        $password = $request->input('password');

        if ($password === 'BsB*SFh2WQ53')
        return view('auth.register');

        else
        return back()->with('error', 'Invalid passcode.');
    }

}
