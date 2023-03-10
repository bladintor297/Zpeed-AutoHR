<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;
use App\Models\Milleage;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

class MilleageController extends Controller
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
        $milleages = Milleage::where('staff_id', Auth::id())->where('ref_id', '0')->get();
        $id = Auth::id();
        return view('claim.claim-app')->with(['milleages'=>$milleages, 'id'=>$id]);
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
        $milleage = new Milleage();
        $milleage->staff_id = str_pad(Auth::id(), 3, '0', STR_PAD_LEFT);
        $milleage->date = $request->input('date');
        $milleage->project = $request->input('project');
        $milleage->vehicle = $request->input('vehicle');
        $milleage->total = $request->input('milleage');
        $milleage->distance = $request->input('distance');
        $milleage->detail = $request->input('detail');
        $milleage->origin = $request->input('origin');
        $milleage->destination = $request->input('destination');
        $milleage->save();

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
        $ref = 'REF'.str_pad(Auth::id(), 4, "0", STR_PAD_LEFT).'-'.uniqid();

        $milleages = Milleage::where('staff_id', Auth::id())
                    ->where ('ref_id', 0)
                    ->where ('status', 0)
                    ->get();

        foreach ($milleages as $milleage){
            $milleage->ref_id = $ref;
            $milleage->save();
        }

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
        if ($request->input('type') === 'm'){

            $milleage = Milleage::find($id);
            $milleage->date = $request->input('date');
            $milleage->project = $request->input('project');
            if(is_null($request->input('detail')))
            $milleage->detail = 'null';
            else
            $milleage->detail = $request->input('detail');
            $milleage->save();
        }
        else{
            $claim = Claim::find($id);
            $claim->date = $request->input('date');
            $claim->project = $request->input('project');
            $claim->detail = $request->input('detail');
            $claim->save();
        }

        return redirect()->back()->with('success', 'Claim data has been updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $milleage = Milleage::find($id);
        $milleage->delete();
        return back();
    }

    public function rejectOneClaim(Request $request, $id)
    {

        if ($request->input('type') === 'm'){
            $milleage = Milleage::find($id);
            $milleage->status = 2;
            $milleage->reject_reason = $request->input('reject_reason');
            $milleage->save();
        }

        else{
            $claim = Claim::find($id);
            $claim->status = 2;
            $claim->reject_reason = $request->input('reject_reason');
            $claim->save();
        }

        return back();
    }
}
