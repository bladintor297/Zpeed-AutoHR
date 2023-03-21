<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveRecord;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;

use Mail;
use App\Mail\NotifyMail;

class LeaveController extends Controller
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
        $currentyear = date("Y");
        $leave_record = LeaveRecord::where('year',$currentyear)->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->get();
        $staff = Staff::where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->first();
        return view('leave.leave-main')->with(['leave_record'=>$leave_record, 'staff'=>$staff]);
    }

    public function status(){
        $all = Leave::where('staff_id',str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->orderBy('status')->get();
        $pendings = Leave::where('staff_id',str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->where('status', '0')->orderBy('start_date')->get();
        $approved = Leave::where('staff_id',str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->where('status', '1')->orderBy('start_date')->get();
        $rejected = Leave::where('staff_id',str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->where('status', '2')->orderBy('start_date')->get();
        return view('leave.leave-status')->with(['pendings'=>$pendings, 'all'=>$all, 'approved'=>$approved, 'rejected'=>$rejected]);
    }

    public function list(){
	
	
    if (Session::get('role') === '1'){
        $pendings = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->where('leave.status', '=', '0')
                    ->orderBy('leave.created_at', 'desc')
                    ->get();

        $all = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->orderBy('leave.updated_at', 'desc')
                    ->get();

        $approved = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->where('leave.status', '=', '1')
                    ->orderBy('leave.updated_at', 'desc')
                    ->get();

        $rejected = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->where('leave.status', '=', '2')
                    ->orderBy('leave.updated_at', 'desc')
                    ->get();
    }
    else{
        $pendings = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->where('leave.status', '=', '0')
                    ->where('staff.supervisor', '=', Auth()->user()->name)
                    ->orderBy('leave.created_at', 'desc')
                    ->get();

        $all = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->where('staff.supervisor', '=', Auth()->user()->name)
                    ->orderBy('leave.updated_at', 'desc')
                    ->get();

        $approved = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->where('leave.status', '=', '1')
                    ->where('staff.supervisor', '=', Auth()->user()->name)
                    ->orderBy('leave.updated_at', 'desc')
                    ->get();

        $rejected = DB::table('staff')
                    ->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                    ->where('staff.supervisor', '=', Auth()->user()->name)
                    ->where('leave.status', '=', '2')
                    ->orderBy('leave.updated_at', 'desc')
                    ->get();

    }
 
    
        return view('leave.leave-list')->with(['pendings'=>$pendings, 'all'=>$all, 'approved'=>$approved, 'rejected'=>$rejected]);
    }

    public function report(){
        $defaultImage = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';
       
	if (Session::get('role')==='2')
        $staffs = Staff::where('approve', '0')->where('supervisor', Auth()->user()->name)->get();
	
	else
	$staffs = Staff::where('approve', '0')->get();

        $leave_record = LeaveRecord::where('year', date("Y"))->get();
        return view('leave.report-list')->with(['staffs'=>$staffs, 'defaultImage'=>$defaultImage, 'leave_record'=>$leave_record]);
    }

    public function generatePDF($id){
        $leave_record = LeaveRecord::where('staff_id',$id)->get();
        $staff = Staff::where('staff_id', $id)->first();
        
        //min max to loop year
        $max = LeaveRecord::where('staff_id',$id)->max('year');
        $min = LeaveRecord::where('staff_id',$id)->min('year');

        $currentyear = date("Y");
        
        $sumML = Leave::where('staff_id', $id)->where('status', '1')->where('leave_type', 'ML')->whereYear('end_date', date("Y"))->sum('days');
        $pdf = PDF::loadView('leave.report-pdf', compact(['leave_record', 'staff', 'max', 'min', 'currentyear']));
            // return $claim->id;
             
        $name = 'Report_U'.$id; 
        return $pdf->stream($name.'.pdf');
    }

    public static function countLeave($id, $year){
        $leave_record = LeaveRecord::where('staff_id',$id)->where('year', $year)->first();
        return $leave_record;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = Staff::where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->first();   
        return view('leave.leave-form')->with('staff',$staff);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $this->validate($request,[
            'type'=>'required',
            'startDate'=>'required',
            'endDate'=>'required',
            'reason'=>'required',   
            'mc'=> 'required_if:type,ML',
        ],
        );

        $staff = Staff::where('staff_id', str_pad(Auth::user()->id, 3, '0', STR_PAD_LEFT))->first();

        
        //Create New Leave
        $leave = new Leave;
        $leave->staff_id = $staff->staff_id;
        $leave->leave_type = $request->input('type');
        $leave->reason = $request->input('reason');
        $leave->start_date = $request->input('startDate');
        $leave->end_date = $request->input('endDate');


        $enddate = strtotime($request->input('endDate'));
        $startdate = strtotime($request->input('startDate'));
        $datediff = $enddate - $startdate;
        $leave->days = round($datediff / (60 * 60 * 24)+1);
        $leave->status = 0;
        if ($leave->leave_type === 'ML')
            if (($staff->bal_ml - $leave->days) < 0)
                return redirect()->back()->with('error', 'Balance Medical Leave is insufficient');
            else
                $staff->bal_ml = $staff->bal_ml - $leave->days;

        else if ($leave->leave_type === 'AL')
            if (($staff->bal_al - $leave->days) < 0)
                return redirect()->back()->with('error', 'Balance Annual Leave is insufficient');

            else 
                $staff->bal_al = $staff->bal_al - $leave->days;
        
        else{
            if (($staff->bal_al - $leave->days) < 0)
                return redirect()->back()->with('error', 'Balance Annual Leave is insufficient');
            
            else{
                $staff->ent_el = $staff->el_el + $leave->days;
                $staff->bal_al = $staff->bal_al - $leave->days;
            }
        }
        //mc_Cert
        if($request->hasFile('mc')){
            $imageName = 'MC_'.$staff->name.'_'.$request->input('startDate').'-'.$request->input('endDate').uniqid().'.'.$request->mc->extension();;
            $request->mc->storeAs('public/leave/mc', $imageName);
            $leave->mc_cert = $imageName;
        }

        
        $leave->save();

        $mailData = [
            'title' => 'Incoming Leave Application',
            'body' => 'There is a pending leave application of '.$leave->days.' days of '.$leave->leave_type.' from '.$staff->name.'. Kindly login to
                        Zpeed Auto HR to approve the application.',
        ];

        $admins = Staff::where('role', '1')->get();
        foreach ($admins as $admin)
        Mail::to($admin->email)->send(new NotifyMail($mailData));

        return back()->with('success', 'Your leave has been submitted !');
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
    public function edit($id, Request $request)
    {
        $leave_record = LeaveRecord::find($id);
        $leave_record->cashback = $request->input('cashback');
        $leave_record->save();

        return back()->with('success', 'Cashback amount has been updated.');
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
            'type'=>'required',
            // 'cashback'=>'required_if:type,2',
        ],
        [
            // 'cashback.required_if' => 'Please key in total cashback amount',
        ]
        );
        $carryforward = 0;
        $staff = Staff::where('staff_id', $id)->first();
        $leave_record = new LeaveRecord;
        $leave_record->staff_id = $id;
        $leave_record->year = date("Y");

        $leave_record->mode = $request->input('type');
        $leave_record->total_al = $staff->ent_al;
        $leave_record->bal_al = $staff->bal_al;
        $leave_record->used_al = $staff->ent_al - $staff->bal_al;

        $leave_record->total_ml = $staff->ent_ml;
        $leave_record->bal_ml = $staff->bal_ml;
        $leave_record->used_ml = $staff->ent_ml - $staff->bal_ml;

        $leave_record->total_el = $staff->ent_el;

        if ($request->input('type') === '1'){
            if($staff->bal_al >= 5)
                $carryforward  = 5;
                
        
            else
                $carryforward = $staff->bal_al;

            $leave_record->cashback = '0';

        } else {
            $carryforward = '0';
            $leave_record->cashback = '0';
        }

        $leave_record->carry_al = $carryforward;

        $d1 = new \DateTime(date('Y-m-d'));
        $d2 = new \DateTime($staff->startDate);

        $diff = $d2->diff($d1);

        if (($diff->y) > 5){
            $staff->ent_al = 18 + $carryforward;
            $staff->ent_ml = 22;
            
        }

        else if (($diff->y)>=3 && ($diff->y)<5) {
            $staff->ent_al = 16 + $carryforward;
            $staff->ent_ml = 18;
        }

        else {
            $staff->ent_al = 14 + $carryforward;
            $staff->ent_ml = 14;
        }
        $staff->bal_al =  $staff->ent_al;
        $staff->bal_ml =  $staff->ent_ml;


        $staff->save();
        $leave_record->save();

        return back()->with('success', 'Staff leave entitlement has been renewed !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = Leave::find($id);
        $leave->delete();

        return back()->with('success', 'Your leave application has been cancelled.');
    }

    public function approveLv($id){
        $leave = Leave::where('id',$id)->first();
        $leave->status = 1; //Approved
        
        $staff = Staff::find($leave->staff_id);
        if ($leave->leave_type === 'ML')
            if (($staff->bal_ml - $leave->days) < 0)
                return redirect()->back()->with('error', 'Balance Medical Leave is insufficient');
            else
                $staff->bal_ml = $staff->bal_ml - $leave->days;

        else if ($leave->leave_type === 'AL')
            if (($staff->bal_al - $leave->days) < 0)
                return redirect()->back()->with('error', 'Balance Annual Leave is insufficient');

            else 
                $staff->bal_al = $staff->bal_al - $leave->days;
        
        else{
            if (($staff->bal_al - $leave->days) < 0)
                return redirect()->back()->with('error', 'Balance Annual Leave is insufficient');
            
            else{
                $staff->ent_el = $staff->el_el + $leave->days;
                $staff->bal_al = $staff->bal_al - $leave->days;
            }
        }

        $staff->save();
        $leave->save();

        $mailData = [
            'title' => 'Leave Approved',
            'body' => 'Your '.$leave->leave_type.' leave application of '.$leave->days.' days has been approved.',
        ];

        Mail::to($staff->email)->send(new NotifyMail($mailData));
        return redirect()->back()->with('success', 'One leave has been approved');
    }

    public function rejectLv($id, Request $request){
        // return $id;
        $leave = Leave::where('id',$id)->first();
        $leave->status = 2; //Rejected
        $leave->reject_reason = $request->input('reject_reason'); //Rejected
        $leave->save();

        $mailData = [
            'title' => 'Leave Rejected',
            'body' => 'Your leave application of '.$leave->days.' days is rejected due to '.$leave->reject_reason.'.',
        ];
        $staff = Staff::find($leave->staff_id);
        Mail::to($staff->email)->send(new NotifyMail($mailData));
        return redirect()->back()->with('success', 'One leave has been rejected');
    }
}
