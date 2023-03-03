@extends('layouts.app')
@section('content') 
<div class="container w-75  bg-white shadow-sm p-3 mb-5 rounded">
    <div class="page-main">
        <p class="text-center fs-2 mt-2 fw-bold">CLAIM ID: {{$ref}}<br></p>
        <table class="table table-bordered text-white fw-bold mx-auto" style="width:90%" id="dynamicAddRemove">
            <div class="d-grid gap-1 d-md-flex justify-content-md-between mx-5">
                <div class="d-grid mb-2">
                    <span class="fs-5 mt-2 ms-2 fw-bold">Name: <span class="text-muted ms-2 text-uppercase"> {{$staff->name}}</span><br>
                    <span class="fs-5 fw-bold">ID: <span class="text-muted ms-2"> {{$staff->staff_id}}</span><br>
                    <span class="fs-5 fw-bold">Total Claim: RM <span class="text-muted"> {{number_format((float)$sum, 2, '.', '')}}</span>
                </span>
                </div>
                <div class="d-grid gap-2 mb-2">
                    <span class="my-4"></span>
                    <a href="{{route('claim.generatePDF', ['id'=>$id])}}"class="btn btn-outline-danger fw-bold me-3" type="button"><i class="fa-solid fa-print"></i> Print</a>
                </div>
            </div>
            <tr class="bg-secondary">
                <th class="text-center" style="width: 2%;">No</th>
                <th class="text-center col-1" style="width: 4%;" >Date</th>
                <th class="text-center col-3 ">Detail of Expenses</th>
                <th class="text-center col-1 ">Receipt</th>
                <th class="text-center  col-1">Sub Total</th>
            </tr>

            {{-- //loop sini --}}
            @if(count($claims)>0)
                @php $count = 0;@endphp

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-start  text-uppercase text-dark"><b>A. Petrol and Milleage</b></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>
                @if(count($milleages)>0)
                    @foreach($milleages as $claim)
                    <tr class="text-dark text-start">
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j-M', strtotime($claim->date));}}</td>
                        <td>{{$claim->origin}} <span class="text-primary"><i class="fa-solid fa-circle-arrow-right mx-2"></i></span> {{$claim->destination}} </td>
                        {{-- <td>{{strstr($claim->origin, ',', true);}} <span class="text-primary"><i class="fa-solid fa-circle-arrow-right mx-2"></i></span> {{strstr($claim->destination, ',', true);}} </td> --}}
                        
                        @if (!(is_null($claim->project)))
                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                    <td class="text-center">{{$project->name}}</td>

                                @endif
                            @endforeach
                        @else
                        <td class="text-center"></td>

                        @endif
                        
                        <td  class="text-end" >
                            <span>RM {{number_format((float)$claim->total, 2, '.', '')}}</span>
                            <span class="text-primary">({{$claim->distance}}km)</span>
                        </td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td  class="text-center">&nbsp;</td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>


                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-start  text-uppercase text-dark"><b>B. Parking, Toll and Taxi</b></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>
                @if(count($parkings)>0)
                    @foreach($parkings as $claim)
                    <tr class="text-dark text-start">
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j-M', strtotime($claim->date));}}</td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$claim->detail}}</td>
                        @if (!(is_null($claim->project)))
                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                    <td class="text-center">{{$project->name}}</td>

                                @endif
                            @endforeach
                        @else
                        <td class="text-center"></td>

                        @endif
                        <td  class="text-end" >RM {{number_format((float)$claim->amount, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td  class="text-center">&nbsp;</td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>


                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-start  text-uppercase text-dark"><b>C. Accomodations</b></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>
                @if(count($accomodations)>0)
                    @foreach($accomodations as $claim)
                    <tr class="text-dark text-start">
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j-M', strtotime($claim->date));}}</td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$claim->detail}}</td>
                        @if (!(is_null($claim->project)))
                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                    <td class="text-center">{{$project->name}}</td>

                                @endif
                            @endforeach
                        @else
                        <td class="text-center"></td>

                        @endif
                        <td  class="text-end" >RM {{number_format((float)$claim->amount, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td  class="text-center">&nbsp;</td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-start  text-uppercase text-dark"><b>D. Project Equipments</b></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>
                @if(count($projects)>0)
                    @foreach($projects as $claim)
                    <tr class="text-dark text-start">
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j-M', strtotime($claim->date));}}</td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$claim->detail}}</td>
                        @if (!(is_null($claim->project)))
                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                    <td class="text-center">{{$project->name}}</td>

                                @endif
                            @endforeach
                        @else
                        <td class="text-center"></td>

                        @endif
                        <td  class="text-end" >RM {{number_format((float)$claim->amount, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td  class="text-center">&nbsp;</td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-start  text-uppercase text-dark"><b>E. Meals/Entertainment</b></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>
                @if(count($meals)>0)
                    @foreach($meals as $claim)
                    <tr class="text-dark text-start">
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j-M', strtotime($claim->date));}}</td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$claim->detail}}</td>
                        @if (!(is_null($claim->project)))
                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                    <td class="text-center">{{$project->name}}</td>

                                @endif
                            @endforeach
                        @else
                        <td class="text-center"></td>

                        @endif
                        <td  class="text-end" >RM {{number_format((float)$claim->amount, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td  class="text-center">&nbsp;</td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-start  text-uppercase text-dark"><b>F. OFfice Expenses</b></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>
                @if(count($offices)>0)
                    @foreach($offices as $claim)
                    <tr class="text-dark text-start">
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j-M', strtotime($claim->date));}}</td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$claim->detail}}</td>
                        @if (!(is_null($claim->project)))
                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                    <td class="text-center">{{$project->name}}</td>

                                @endif
                            @endforeach
                        @else
                        <td class="text-center"></td>

                        @endif
                        <td  class="text-end" >RM {{number_format((float)$claim->amount, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td  class="text-center">&nbsp;</td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-start  text-uppercase text-dark"><b>G. Others</b></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>
                @if(count($others)>0)
                    @foreach($others as $claim)
                    <tr class="text-dark text-start">
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j-M', strtotime($claim->date));}}</td>
                        <td> &nbsp;&nbsp;&nbsp;&nbsp;{{$claim->detail}}</td>
                        @if (!(is_null($claim->project)))
                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                    <td class="text-center">{{$project->name}}</td>

                                @endif
                            @endforeach
                        @else
                        <td class="text-center"></td>

                        @endif
                        <td  class="text-end" >RM {{number_format((float)$claim->amount, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td  class="text-center">&nbsp;</td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                </tr>



            @endif
        </table>
        <span>&nbsp;</span>
    </div>
</div>
    @foreach ($claims as $claim)
        @if ($claim->type === 'parking')
            <div class="container w-75  bg-white shadow-sm p-3 mb-5 rounded">
                    <h2 class="text-center fw-bold mt-3">PARKING RECEIPTS</h2>
                    <p class="text-center">
                        <img src='{{url('/storage/receipts/parking/'.$claim->receipt)}}' style="width:80%"alt = "No receipt" />
                    </p>
                            

                {{-- @else
                    <div class="page">
                        <h2 class="text-center">MEAL RECEIPTS</h2>
                        <p class="text-center">No claims made</p>
                    </div> --}}
            </div>
        @endif
        @if ($claim->type === 'accomodation')
            <div class="container w-75  bg-white shadow-sm p-3 mb-5 rounded">
                    <h2 class="text-center fw-bold mt-3">ACCOMODATION RECEIPTS</h2>
                    <p class="text-center">
                        <img src='{{url('/storage/receipts/accomodation/'.$claim->receipt)}}' style="width:80%"alt = "No receipt" />
                    </p>
                            

                {{-- @else
                    <div class="page">
                        <h2 class="text-center">MEAL RECEIPTS</h2>
                        <p class="text-center">No claims made</p>
                    </div> --}}
            </div>
        @endif

        @if ($claim->type === 'equipment')
            <div class="container w-75  bg-white shadow-sm p-3 mb-5 rounded">
                    <h2 class="text-center fw-bold mt-3">EQUIPMENT RECEIPTS</h2>
                    <p class="text-center">
                        <img src='{{url('/storage/receipts/equipment/'.$claim->receipt)}}' style="width:80%"alt = "No receipt" />
                    </p>
                            

                {{-- @else
                    <div class="page">
                        <h2 class="text-center">MEAL RECEIPTS</h2>
                        <p class="text-center">No claims made</p>
                    </div> --}}
            </div>
        @endif

        @if ($claim->type === 'meal')
            <div class="container w-75  bg-white shadow-sm p-3 mb-5 rounded">
                    <h2 class="text-center fw-bold mt-3">MEAL RECEIPTS</h2>
                    <p class="text-center">
                        <img src='{{url('/storage/receipts/meal/'.$claim->receipt)}}' style="width:80%"alt = "No receipt" />
                    </p>
                            

                {{-- @else
                    <div class="page">
                        <h2 class="text-center">MEAL RECEIPTS</h2>
                        <p class="text-center">No claims made</p>
                    </div> --}}
            </div>
        @endif

        @if ($claim->type === 'office')
            <div class="container w-75  bg-white shadow-sm p-3 mb-5 rounded">
                    <h2 class="text-center fw-bold mt-3">OFFICE RECEIPTS</h2>
                    <p class="text-center">
                        <img src='{{url('/storage/receipts/office/'.$claim->receipt)}}' style="width:80%"alt = "No receipt" />
                    </p>
                            

                {{-- @else
                    <div class="page">
                        <h2 class="text-center">MEAL RECEIPTS</h2>
                        <p class="text-center">No claims made</p>
                    </div> --}}
            </div>
        @endif

        @if ($claim->type === 'others')
            <div class="container w-75  bg-white shadow-sm p-3 mb-5 rounded">
                    <h2 class="text-center fw-bold mt-3">OTHERS RECEIPTS</h2>
                    <p class="text-center">
                        <img src='{{url('/storage/receipts/others/'.$claim->receipt)}}' style="width:80%"alt = "No receipt" />
                    </p>
                            

                {{-- @else
                    <div class="page">
                        <h2 class="text-center">MEAL RECEIPTS</h2>
                        <p class="text-center">No claims made</p>
                    </div> --}}
            </div>
        @endif
    @endforeach
@endsection