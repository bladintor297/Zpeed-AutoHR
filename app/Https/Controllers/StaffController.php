<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use App\Models\Certificate;
use PDF;
class StaffController extends Controller
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
        return view('staff.staff-main');
    }

    public function approve(){
        $svs = Staff::where('role', 2)->get();
        $staffs = Staff::orderBy('name')->where('approve',0)->get();
        return view('staff.approve-staff')->with(['staffs   ' => $staffs, 'svs' => $svs]);
    }

    public function list(){
        $defaultImage = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';

	$all = Staff::orderby('staff_id')->simplePaginate(7);;
        $active = Staff::where('approve','0')->orderby('staff_id')->simplePaginate(7);
        $resign = Staff::where('approve','2')->orderby('staff_id')->simplePaginate(7);;
        return view('staff.staff-list')->with(['all'=>$all, 'active'=>$active, 'resign'=>$resign, 'defaultImage'=>$defaultImage]);
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
        $staff = Staff::where('staff_id', $request->input('staff_id'))->first();
        $staff->resign_date =  $request->input('resign_date');
        $staff->resign_remark = $request->input('resign_remark');
        $staff->status = '2';
        $staff->approve = '2';
        $staff->save();

        return back()->with('success', 'One staff has been terminated');
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
        $defaultImage = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';
        $svs = Staff::where('role', '2')->orWhere('role', '1')->pluck('name');
        $staff = Staff::where('staff_id', $id)->first();
        $certificates = Certificate::where('staff_id', $id)->get();

        return view('staff.edit-details')->with(['staff'=>$staff, 'svs'=>$svs, 'defaultImage'=>$defaultImage, 'certificates'=>$certificates]);
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
        $this->validate($request,[
            'name'=>'required',
            'nric'=>'required',
            'phone'=>'required',
            'marry'=>'required',
            'bank'=>'required',
            'bank_acc'=>'required',
            'supervisor'=>'required_if:role,3',
            'child'=>'required',
            'ml'=>'required',
            'al'=>'required',
        ]);
        $staff = Staff::where('staff_id', $id)->first();
        $user = User::find(ltrim($staff->staff_id, "0"));
        $user->name = $request->input('name');
        $user->save();
        //Personal Details
        $staff->name = $request->input('name');
        $staff->nric = $request->input('nric');
        $staff->phone = $request->input('phone');
        $staff->address = $request->input('address');
        $staff->marrital_status = $request->input('marry');
        $staff->child = $request->input('child');
        $staff->designation = $request->input('designation');
        $staff->role = $request->input('role');
        $staff->supervisor = $request->input('supervisor');
        $staff->epf = $request->input('epf');

        //Banking Detials
        $staff->bank_name = $request->input('bank');
        $staff->bank_acc = $request->input('bank_acc');
        $staff->income_tax = $request->input('tax');

         //Qualification Detials
        $staff->qualification = $request->input('qualification');
        $staff->university = $request->input('university');
        $staff->year = $request->input('year');

        //Leave Entitlement
        $staff->start_date = $request->input('start_date');
        $staff->ent_al = $request->input('al');
        $staff->ent_ml = $request->input('ml');

        $staff->save();

        return redirect('/staff')->with('success', $staff->name.' profile has been updated !');
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

    public function generatePDF(){
        
        $staffs = Staff:: all()->sortBy('staff_id');

        $pdf = PDF::loadView('staff.list-pdf', compact(['staffs']));
        
        $name = 'Report_'.date('Y-m-d H:i:s'); 
        return $pdf->stream($name.'.pdf');
    }
}
