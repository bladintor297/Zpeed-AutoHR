<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Staff;
use App\Models\Milleage;
use App\Models\Project;
use App\Models\Leave;
use App\Models\Claim;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
	
	if (Auth::check()){
        //Assign Role to Session
        $staff = Staff::where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->first();
        // return $staff;
        Session::put('role', $staff->role);

        $currentyear = date("Y");

        // Pending Claims
        $pendingclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('status', '0')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $pendingmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('status', '0')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
        $pendingclaims = ($pendingclaim->merge($pendingmilleage))->unique();

        //Amount Paid
        $paidc = Claim::where('payment_status','1')->where('status', '1')->whereYear('date', $currentyear)->sum('amount');
        $paidm = Milleage::where('payment_status','1')->where('status', '1')->whereYear('date', $currentyear)->sum('total');
        $paid = $paidc + $paidm;

        //Pending Payment
        $payc = Claim::where('payment_status','0')->where('status', '1')->whereYear('date', $currentyear)->sum('amount');
        $paym = Milleage::where('payment_status','0')->where('status', '1')->whereYear('date', $currentyear)->sum('total');
        $pendingpay = $payc + $paym;

        //Total Claims
        $totalclaim = DB::table('claim')
                    ->where('status', '1')
                    ->where('payment_status', '1')
                    ->get();

        $totalmilleage = DB::table('milleage')
                    ->where('status', '1')
                    ->where('payment_status', '1')
                    ->get();

        $totalclaims = ($totalclaim->merge($totalmilleage))->unique();

        //Pending Leave
        $pendingleaves = Leave::where('status', '0')->whereYear('start_date', $currentyear)->get();

        //Absents
        $absents = DB::table('staff')->join('leave', 'staff.staff_id', '=', 'leave.staff_id')
                                    ->where('leave.status', '1')->whereYear('leave.start_date', $currentyear)->get();
        
        $absentslist = array();
        foreach ($absents as $absent){
            $check = Carbon::now()->between($absent->start_date, $absent->end_date);

            
            if ($absent->days === 1){
                if ($absent->start_date === date("Y-m-d"))
                array_push($absentslist, $absent->name);
            }
            if ($check === true)
                array_push($absentslist, $absent->name);

            else
            continue;
        }
        //Staffs
        $staffs = Staff::where('approve','0')->get();
        $abesence_rate = number_format((float)(((count($staffs)-count((array_unique($absentslist))))/count($staffs))*100), 2, '.', '');

        //Projects
        $projects = Project::all();
        $activeprojects = Project::where('status', '0')->get();
        $completeprojects = Project::where('status', '1')->get();

         // My Pending Claims
         $mypendingclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '0')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $mypendingmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '0')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
        $mypendingclaims = ($mypendingclaim->merge($mypendingmilleage))->unique();

        //My Amount Paid
        $mypaidc = Claim::where('payment_status','1')->where('status', '1')->whereYear('date', $currentyear)->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->sum('amount');
        $mypaidm = Milleage::where('payment_status','1')->where('status', '1')->whereYear('date', $currentyear)->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->sum('total');
        $mypaid = $mypaidc + $mypaidm;

        //Pending Payment
        $mypayc = Claim::where('payment_status','0')->where('status', '1')->whereYear('date', $currentyear)->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->sum('amount');
        $mypaym = Milleage::where('payment_status','0')->where('status', '1')->whereYear('date', $currentyear)->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->sum('total');
        $mypendingpay = $mypayc + $mypaym;

        return view('home')->with(['pendingclaims'=>$pendingclaims, 'paid'=>$paid, 'pendingpay'=>$pendingpay, 'totalclaims'=>$totalclaims,
                                    'pendingleaves'=>$pendingleaves, 'absentslist'=>(array_unique($absentslist)), 'abesence_rate'=>$abesence_rate,
                                    'completeprojects'=>$completeprojects, 'activeprojects'=>$activeprojects, 'projects'=>$projects,
                                    'mypendingclaims'=>$mypendingclaims, 'mypaid'=>$mypaid, 'mypendingpay'=>$mypendingpay,
    ]);
	    }else return view('welcome');
    }

    
}
