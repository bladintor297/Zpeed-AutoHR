<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Storage;
use PDF;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = str_pad(Auth::id(), 3, '0', STR_PAD_LEFT);
        // return $id;
        $defaultImage = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';
        $staff = Staff::where('staff_id', $id)->first();
        $certificates = Certificate::where('staff_id', $id)->get();
        return view('profile.my-profile')->with(['staff'=>$staff, 'defaultImage'=>$defaultImage, 'certificates'=>$certificates]);
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
        $staff = Staff::where('staff_id',$id)->first();
	$request->validate([
    		'picture' => 'max:5120', //5MB 
	],
	[
		'picture.max' => 'File size exceeds limit 5MB',
	]
	);
        
        $imageName = ($staff->staff_id).'_profile_picture'.'.'.$request->picture->extension();
        Storage::delete('public/upload/profile/'.$staff->picture);
        $request->picture->storeAs('public/upload/profile/', $imageName);

        $staff->picture = $imageName;
        $staff->save();

        return back()->with('success', 'Profile picture has been updated.');
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

    public function generatePDF($id, Request $request){
        $skill_summary = $request->input('skill_summary');
        $staff = Staff::where('staff_id', $id)->first();
        $certs = Certificate::where('staff_id', $id)->get();
        
        $pdf = PDF::loadView('profile.cv-pdf', compact(['staff', 'skill_summary', 'certs']));
        $name = 'CV_U'.$id; 
        return $pdf->stream($name.'.pdf');
    }

    public function changePassword()
    {
        return view('profile.change-password');
    }

    public function updatePassword(Request $request)
{
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
}
}
