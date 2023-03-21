<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Staff;
use App\Models\Milleage;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Collection;
use File;
use PDF;
use Mail;
use App\Mail\NotifyMail;

class ClaimController extends Controller
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
        return view('claim.claim-main');
    }

    public function status(){
        //All Claims
        $allclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $allmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
        $all = ($allclaim->merge($allmilleage))->unique();


        // Pending Claims
        $pendingclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '0')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $pendingmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '0')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
        $pending = ($pendingclaim->merge($pendingmilleage))->unique();

        // Approved Claims
        $approvedclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '1')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $approvedmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '1')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
                    
        $approved = ($approvedclaim->merge($approvedmilleage))->unique();

        // Rejected Claims
        $rejectedclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '2')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $rejectedmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where('status', '2')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
        $rejected = ($rejectedclaim->merge($rejectedmilleage))->unique();

        return view('claim.claim-status')->with(['pending'=>$pending, 'approved'=>$approved, 'rejected'=>$rejected, 'all'=>$all]);
    }

    public static function checkClaim($id){
        $claim_ref= DB::table('staff')
                        ->join('milleage', 'staff.staff_id', '=', 'milleage.staff_id')
                        ->where('milleage.ref_id', '=', $id)
                        ->get();

        $claim_ref2= DB::table('staff')
                        ->join('claim', 'staff.staff_id', '=', 'claim.staff_id')
                        ->where('claim.ref_id', '=', $id)
                        ->get();

        $claim = ($claim_ref->merge($claim_ref2));
        return ($claim);
    }

    public static function countAmount($id){
        $amountclaim= Claim::where('ref_id', $id)->where('status', '!=', 2)->sum('amount');
        $amountmilleage=Milleage::where('ref_id',$id)->where('status', '!=', 2)->sum('total');
        return ($amountclaim + $amountmilleage);
    }

    public function generatePDF($id){

        //To print receipts
        $claims = Claim::where('ref_id', $id)->orderby('type')->get();

        //To print data
        $claim = Claim::where('ref_id', $id)->orderby('type')->get();
        $milleage = Milleage::where('ref_id', $id)->get();
        $claimx = (($claim->merge($milleage))->unique())->first();

	    $staff = Staff::where('staff_id', $claimx->staff_id)->first();
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

    public function list(){
   
        //All Claims
        $allclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $allmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
        $all = ($allclaim->merge($allmilleage))->unique();


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
        $pending = ($pendingclaim->merge($pendingmilleage))->unique();

        // Approved Claims
        $approvedclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('status', '1')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $approvedmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('status', '1')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
                    
        $approved = ($approvedclaim->merge($approvedmilleage))->unique();

        // Rejected Claims

        // $rejected = Claim::where('ref_id', '!=', '0')->get();
        // $rejected2 = Milleage::where('ref_id', '!=', '0')->get();

        // foreach ($rejected as $rj => $i){
        //     if ($rejected->contains('status', 1))
        //     $rejected = $rejected::whereIn('ref_id', $rejected->ref_id)->delete();
        // }
        // foreach ($rejected2 as $rj2 => $i){
        //     if ($rejected2->contains('status', 1))
        //     echo $i->ref_id;
        // }

        // return 123;
        $rejectedclaim = DB::table('claim')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('status', '2')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');

        $rejectedmilleage = DB::table('milleage')
                    ->select('ref_id', DB::raw('count(*) as total'))
                    ->where('status', '2')
                    ->groupBy('ref_id')
                    ->where('ref_id', '!=', '0')
                    ->pluck('ref_id');
        $rejected = ($rejectedclaim->merge($rejectedmilleage))->unique();

        foreach ($rejected as $item =>$rj) {
            $claim = Claim::where('ref_id', $rj)->get();
            $milleage = Milleage::where('ref_id', $rj)->get();
            $claim = $claim->merge($milleage);

            if (($claim->contains('status',1)) || (($claim->contains('status',0)))){
                unset($rejected[$item]);
            }
        }
        
        return view('claim.claim-list')->with(['pending'=>$pending,'all'=>$all,'approved'=>$approved, 'rejected'=>$rejected]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff_id = str_pad(Auth::id(), 3, '0', STR_PAD_LEFT);

        $milleages = Milleage::where('staff_id', $staff_id)->where('ref_id', '0')->get();
        $projects = Project::where('status', '0')->orderBy('name')->get();
	$projectx = Project::all();
        $claims = Claim::where('staff_id', $staff_id)->where('ref_id', '0')->get();
        return view('claim.claim-app')->with(['milleages'=>$milleages, 'id'=>$staff_id, 'claims'=>$claims, 'projectx'=>$projectx, 'projects'=>$projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'detail' => 'required',
            'amount' => 'required',
            'receipt' => 'required',
            'type' => 'required',
        ]);

            $imageName = 'S'.str_pad(Auth::id(), 4, "0", STR_PAD_LEFT).'_'.$request->input('type').'_'.$request->input('date').'_'.uniqid().'.png';

            if ($request->input('type') === 'parking')
            $request->receipt->storeAs('public/receipts/parking', $imageName);
            
            if ($request->input('type') === 'accomodation')
            $request->receipt->storeAs('public/receipts/accomodation', $imageName);
            
            if ($request->input('type') === 'equipment')
            $request->receipt->storeAs('public/receipts/equipment', $imageName);
            
            if ($request->input('type') === 'meal')
            $request->receipt->storeAs('public/receipts/meal', $imageName);
            
            if ($request->input('type') === 'office')
            $request->receipt->storeAs('public/receipts/office', $imageName);
            
            if ($request->input('type') === 'others')
            $request->receipt->storeAs('public/receipts/others', $imageName);

            echo $imageName.'<br>';

            $claim = new Claim;
            $claim->staff_id = str_pad(Auth::id(), 3, "0", STR_PAD_LEFT);
            $claim->date = $request->input('date');
            $claim->ref_id = '0';
            $claim->project = $request->input('project');
            $claim->detail = $request->input('detail');
            $claim->amount = $request->input('amount');
            $claim->receipt = $imageName;
            $claim->type = $request->input('type');
            $claim->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ref = $id;
        $staff1 = Claim::where('ref_id', $id)->get();
        $staff2 = Milleage::where('ref_id', $id)->get();
        $staff_id = $staff1->merge($staff2)->unique('staff_id')->first()->staff_id;
        $projectx = Project::all();

        $staff = Staff::where('staff_id',$staff_id)->first();
        $claimsc = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->orderby('type')->get();
        $claimsm = Milleage::where('staff_id', $staff_id)->where('ref_id', $id)->get();
        $claims = $claimsc->merge($claimsm);
        $sum = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->sum('amount') + Milleage::where('staff_id', $staff_id)->where('ref_id', $id)->sum('total');
        $sumapproved = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->where('status', '!=', 2)->sum('amount') + Milleage::where('staff_id', $staff_id)->where('ref_id', $id)->where('status', '!=', 2)->sum('total');
        $status = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->orderby('type')->first();
        $milleages = Milleage::where('staff_id', $staff_id)->where('ref_id', $id)->get();
        $parkings = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->where('type', 'parking')->get();
        $accomodations = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->where('type', 'accomodation')->get();
        $projects = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->where('type', 'equipment')->get();
        $meals = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->where('type', 'meal')->get();
        $offices = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->where('type', 'office')->get();
        $others = Claim::where('staff_id', $staff_id)->where('ref_id', $id)->where('type', 'others')->get();
        return view('claim.claim-details')->with(['id'=>$id,'staff'=>$staff, 'ref'=>$ref,'claims'=>$claims,'parkings'=>$parkings, 'accomodations'=>$accomodations, 'projectx' => $projectx,
                                                'projects'=>$projects,'meals'=>$meals,'offices'=>$offices,'others'=>$others, 'status'=>$status, 'milleages'=>$milleages, 'sum'=>$sum, 'sumapproved'=>$sumapproved]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ref = 'REF'.str_pad(Auth::id(), 4, "0", STR_PAD_LEFT).'-'.uniqid();
        $staff = Staff::where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->first();
        $milleages = Milleage::where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where ('ref_id', '0')
                    ->where ('status', '0')
                    ->get();

        foreach ($milleages as $milleage){
            $milleage->ref_id = $ref;
            $milleage->save();
        }

        $claims = Claim::where('staff_id', str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))
                    ->where ('ref_id', '0')
                    ->where ('status', '0')
                    ->get();

        foreach ($claims as $claim){
            $claim->ref_id = $ref;
            $claim->save();
        }
        $amountclaim= Claim::where('ref_id', $ref)->sum('amount');
        $amountmilleage=Milleage::where('ref_id',$ref)->sum('total');

        $mailData = [
            'title' => 'Incoming Claim Application',
            'body' => 'There is a pending claim application of RM'.($amountclaim+$amountmilleage).' from '.$staff->name.'. Kindly login to
                        Zpeed Auto HR to approve the application.',
        ];

        $admins = Staff::where('role', '1')->get();

  	foreach ($admins as $admin)
        Mail::to($admin->email)->send(new NotifyMail($mailData));

        return back()->with ('success', 'Your claim has been submitted.');
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
        $id = str_pad(Auth::id(), 3, '0', STR_PAD_LEFT);
        $milleage = new Milleage();
        $milleage->staff_id = $id;
        $milleage->date = $request->input('date');
        $milleage->vehicle = $request->input('vehicle');
        $milleage->total = $request->input('milleage');
        $milleage->distance = $request->input('distance');
        $milleage->origin = $request->input('origin');
        $milleage->destination = $request->input('destination');
        $milleage->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $claim = Claim::find($id);
        $claim->delete();

        return back();
    }

    public function approveCl($id){
        $staff1 = Claim::where('ref_id', $id)->get();
        $staff2 = Milleage::where('ref_id', $id)->get();
        
        $staff = $staff1->merge($staff2)->unique('staff_id')->first();

        $claims = Claim::where('ref_id',$id)->where('status', 0)->get();
        foreach ($claims as $claim){
            $claim->status = 1; //Approved  
            $claim->save();
        }

        $milleages = Milleage::where('ref_id', $id)->where('status', 0)->get();
        foreach ($milleages as $claim){ 
            $claim->status = 1; //Approved  
            $claim->save();
        }
        
        $mailData = [
            'title' => 'Claim Approved',
            'body' => 'Your claim id with reference number '.$id.' has been approved.',
        ];

        
        $staff = Staff::where('staff_id', $staff->staff_id)->first();
        return $staff;
        Mail::to($staff->email)->send(new NotifyMail($mailData));

        return redirect()->back()->with('success', 'One claim has been approved');
    }

    public function rejectCl($id, Request $request){
        $claims = Claim::where('ref_id',$id)->get();
        $milleages = Milleage::where('ref_id',$id)->get();
        $reason = $request->input('reject_reason');

        foreach ($claims as $claim){
            $claim->status = 2; //Rejected
            $claim->reject_reason = $reason;
            $claim->save();
        }
        foreach ($milleages as $claim){
            $claim->status = 2; //Rejected 
            $claim->reject_reason = $reason;
            $claim->save();
        }

        $staff1 = Claim::where('ref_id', $id)->get();
        $staff2 = Milleage::where('ref_id', $id)->get();
        $staff = $staff1->merge($staff2)->unique('staff_id')->first();
        $staff = Staff::where('staff_id', $staff->staff_id)->first();

        $mailData = [
            'title' => 'Claim Rejected',
            'body' => 'Your claim id with reference number '.$id.' is rejected due to '.$reason.'.',
        ];
        Mail::to($staff->email)->send(new NotifyMail($mailData));

        return redirect()->back()->with('success', 'One claim has been rejected');
    }

    public function deleteCl($id){
        $claims = Claim::where('ref_id', $id)->get();
        $milleages = Milleage::where('ref_id', $id)->get();
        foreach ($claims as $claim)
            $claim->delete();
        foreach ($milleages as $claim)
            $claim->delete(); 

        return back()->with('success', 'Claim ID '.$id. ' has been cancelled.');
    }

}
