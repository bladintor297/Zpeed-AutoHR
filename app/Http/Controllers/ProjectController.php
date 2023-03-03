<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Claim;
use App\Models\Milleage;
use App\Models\Staff;
use Illuminate\Http\Resources\MergeValue;
use PDF;
use PhpParser\Node\Expr\AssignOp\Concat;

class ProjectController extends Controller
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
        return view('project.project-main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.project-form');
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
            'name'=>'required',
            'description'=>'required',
            // 'code'=>'required',
            'start_date'=>'required',
            'end_date'=>'required_if:status,1',
            'status'=>'required',
        ],
        );

        //Create New Project
        $project = new Project;
        $project->name = $request->input('name');
        $project->code = 'P'.uniqid();
        $project->description = $request->input('description');
        $project->start_date = $request->input('start_date');
        $project->end_date = $request->input('end_date');
        $project->status = $request->input('status');

        $project->save();

        return back()->with('success', 'Project '.$project->name.' has been added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        //Claim Names for Claim
        $claimnames1= DB::table('claim')
                ->join('staff', 'staff.staff_id', '=', 'claim.staff_id')
                ->where('claim.project', $project->code)
                ->where('claim.ref_id', '!=', '0')
                ->get();
        
        // Claim Names for Milleage
        $claimnames2= DB::table('milleage')
                ->join('staff', 'staff.staff_id', '=', 'milleage.staff_id')
                ->where('milleage.project', $project->code)
                ->where('milleage.ref_id', '!=', '0')
                ->get();


        $claimnames = ($claimnames1->merge($claimnames2))->unique();

        $claimamountid = ($claimnames1->merge($claimnames2))->unique();
        $claimamount = array();

            foreach ($claimamountid as $claim)
            {
                $amount = $claimnames->where('staff_id', $claim->staff_id)->sum('amount');
                $total = $claimnames->where('staff_id', $claim->staff_id)->sum('total');
                $array2 = array(
                    "id" => $claim->staff_id,
                    "name" => $claim->name,
                    "total" => ($amount + $total),
                );
                
                if(!in_array($array2, $claimamount, true)){
                    array_push($claimamount, $array2);
                }

            }
        // array_push($absentslist, $absent->name);

        $totalclaim = Claim::where('project', $project->code)->where('status', '1')->where('payment_status', '1')->sum('amount');
        $totalmilleage = Milleage::where('project', $project->code)->where('status', '1')->where('payment_status', '1')->sum('total');
        $total = $totalclaim+$totalmilleage;

        $totalallclaim = Claim::where('project', $project->code)->where('ref_id', '!=', '0')->sum('amount');
        $totalallmilleage = Milleage::where('project', $project->code)->where('ref_id', '!=', '0')->sum('total');
        $totalall = $totalallclaim+$totalallmilleage;

        $pdf = PDF::loadView('project.project-pdf', compact(['project', 'total', 'totalall', 'claimamount']));
        
        $name = 'Report_Project'.$project->code; 
        return $pdf->stream($name.'.pdf');
    }

    public function list(){
        $all = Project::all()->sortby('start_date');
        $actives = Project::where('status', '0')->orderby('start_date')->get();
        $completed = Project::where('status', '1')->orderby('start_date')->get();
        return view('project.project-list')->with(['all'=>$all, 'actives'=>$actives, 'completed'=>$completed]);
    }

    public function report(){
        $all = Project::all()->sortby('start_date');
        $actives = Project::where('status', '0')->orderby('start_date')->get();
        $completed = Project::where('status', '1')->orderby('start_date')->get();
        return view('project.report-list')->with(['all'=>$all, 'actives'=>$actives, 'completed'=>$completed]);
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
        $this->validate($request,[
            'end_date'=>'required_if:status,1',
        ]);

        $project = Project::where('id', $id)->first();
        $project->end_date = $request->input('end_date');
        $project->status = '1';
        $project->save();

        return back()->with('success', 'Project '.$project->name.' status has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();

        return back()->with('success', 'One project has been deleted');
    }
}
