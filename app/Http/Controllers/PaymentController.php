<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Staff;
use App\Models\Milleage;
use App\Models\Claim;

class PaymentController extends Controller
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
        $staffs = Staff::where('approve', '0')->get();
        return view('claim.payment-list')->with(['staffs'=>$staffs]);
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
        $id = $request->input('id');
        $claims = Claim::where('staff_id',$id)->where('status', '1')->where('payment_status', '0')->get();
        $milleages = Milleage::where('staff_id',$id)->where('status', '1')->where('payment_status', '0')->get();
        $payment_date = $request->input('payment_date');
        $payment_ref = $request->input('payment_ref');

        foreach ($claims as $claim){
            $claim->payment_status = 1; //Approved  
            $claim->payment_date = $payment_date;
            $claim->payment_ref = $payment_ref;
            $claim->save();
        }

        foreach ($milleages as $claim){
            $claim->payment_status = 1; //Approved  
            $claim->payment_date = $payment_date;
            $claim->payment_ref = $payment_ref;
            $claim->save();
        }


        return redirect()->back()->with('success', 'Claim '.$id.' has been approved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //To print data
        $staff = Staff::where('staff_id', $claim->staff_id)->first();
        $total_milleage = Milleage::where('ref_id', $id)->sum('total');
        $total_parking = Claim::where('ref_id', $id)->where('type', 'parking')->sum('amount');
        $total_accomodation = Claim::where('ref_id', $id)->where('type', 'accomodation')->sum('amount');
        $total_equipment = Claim::where('ref_id', $id)->where('type', 'equipment')->sum('amount');
        $total_office = Claim::where('ref_id', $id)->where('type', 'office')->sum('amount');
        $total_meal = Claim::where('ref_id', $id)->where('type', 'meal')->sum('amount');
        $total_others = Claim::where('ref_id', $id)->where('type', 'others')->sum('amount');
        $total_amount = Claim::where('ref_id', $id)->sum('amount') + Milleage::where('ref_id',$id)->sum('total');
  
  
        $pdf = PDF::loadView('claim.claim-pdf', compact(['claims', 'id', 'staff', 'total_parking', 'total_accomodation',
        'total_equipment', 'total_office', 'total_meal', 'total_others', 'total_amount', 'total_milleage']));
          
        $name = 'Report_'.$id; 
        return $pdf->stream($name.'.pdf');
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
        //
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

    public function approvePy(Request $request){
        
    }

    public function rejectPy($id){
        $claims = Claim::where('ref_id',$id)->get();
        foreach ($claims as $claim){
            $claim->status = 2; //Approved  
            $claim->save();
        }
        return redirect()->back()->with('success', 'Claim '.$id.' has been rejected');
    }

    public static function calcPayment($id){
        $pendingclaim = Claim::where('staff_id', $id)->where('status', '1')->where('payment_status', '0')->sum('amount');
        $pendingmilleage = Milleage::where('staff_id', $id)->where('status', '1')->where('payment_status', '0')->sum('total');

        return ($pendingclaim + $pendingmilleage);
    }
}
