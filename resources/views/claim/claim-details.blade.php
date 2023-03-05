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
                    <span class="fs-5 fw-bold">Total Claim: RM <span class="text-muted"> {{number_format((float)$sum, 2, '.', '')}}</span><br>
                    <span class="fs-5 fw-bold">Approved Claim: RM <span class="text-muted"> {{number_format((float)$sumapproved, 2, '.', '')}}</span>
                </span>
                </div>
                <div class="mt-5 pt-4 gap-2">
                    <span class="my-4"></span>
                    <a href="{{route('claim.generatePDF', ['id'=>$id])}}"class="btn btn-outline-danger fw-bold me-3" type="button"><i class="fa-solid fa-print"></i> Print</a>
                </div>
            </div>
            <tr class="bg-secondary">
                <th class="text-center" style="width: 2%;">No</th>
                <th class="text-center col-1" style="width: 4%;" >Date</th>
                <th class="text-center col-3 ">Detail of Expenses</th>
                <th class="text-center col-1 ">Project</th>
                <th class="text-center  col-1">Sub Total</th>
                <th class="text-center" style="width:1%">Action</th>
            </tr>

            {{-- //loop sini --}}
            @if(count($claims)>0)
                @php $count = 0;@endphp

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td colspan="4" class="text-start  text-uppercase text-dark"><b>A. Petrol and Milleage</b></td>
                </tr>
                @if(count($milleages)>0)
                    @foreach($milleages as $claim)

                    @if ($claim->status === 2)
                        <tr class="text-dark text-start bg-danger " style="--bs-bg-opacity: .2;">
                        
                    @else
                        <tr class="text-dark text-start">
                    @endif
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j/M', strtotime($claim->date));}}</td>
                        <td>
                            <span>{{$claim->detail}}</span> 
                            <div class="d-grid text-center mt-3" style="font-size: 0.7rem">
                                <span>{{$claim->origin}}</span> 
                                <span class="text-primary"><i class="fa-solid fa-circle-arrow-down mx-2"></i></span> 
                                <span>{{$claim->destination}} </span>
                            </div>
                        </td>
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
                        <td >
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-link px-0" data-bs-target="#updateMilleage{{$claim->id}}" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square text-primary fw-bold"></i></button>
                                {{-- Update Modal --}}
                                <div class="modal fade" id="updateMilleage{{$claim->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Update Claim</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action = "{{route('claim.update', $claim->id)}}" method="GET" enctype="multipart/form-data">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="ref" class="form-label">Staff:</label>
                                                    <input type="text" class="form-control" name="staff" value="{{$staff->name}}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="ref" class="form-label">Claim Ref:</label>
                                                    <input type="text" class="form-control" name="ref" value="{{$claim->ref_id}}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="date" class="form-label">Date:</label>
                                                    <input type="date" class="form-control" name="date" value="{{$claim->date}}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="project" class="form-label">Project:</label>
                                                    <select type="text" class="form-select" name="project" value="{{$claim->project}}" required>
                                                        @if (is_null($claim->project))
                                                            <option value="" selected>No Project</option>
                                                        @else
                                                            <option value="">NO PROJECT</option>
                                                        @endif

                                                        @foreach ($projectx as $project)
                                                            @if ($project->code === $claim->project)
                                                              <option value="{{$project->code}}" selected>{{$project->name}}</option>

                                                            @else
                                                                <option value="{{$project->code}}">{{$project->name}}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="date" class="form-label">Detail:</label>
                                                    <input type="text" class="form-control" name="detail" value="{{$claim->detail}}">
                                                </div>
                                                <input type="hidden" class="form-control" value="m" name="type">
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="modal-footer">
                                            {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if (Session::get('role') === '1')
                                <button class="btn btn-link px-0" data-bs-target="#rejectMilleage{{$claim->id}}" data-bs-toggle="modal"><i class="fa-regular fa-circle-xmark text-danger fw-bold"></i></button>
                                {{-- Reject Modal --}}
                                <div class="modal fade" id="rejectMilleage{{$claim->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Reject Claim</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action = "{{route('claim.rejectOne', $claim->id)}}" method="GET" enctype="multipart/form-data">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="ref" class="form-label">Staff:</label>
                                                    <input type="text" class="form-control" name="staff" value="{{$staff->name}}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="ref" class="form-label">Claim Ref:</label>
                                                    <input type="text" class="form-control" name="ref" value="{{$claim->ref_id}}" disabled>
                                                </div>
                                                <div class="col-md-12">
                                                    <table class="table table-bordered">
                                                          <tr>
                                                            <th scope="col">Date</th>
                                                            <td scope="col">{{$claim->date}}</td>
                                                          </tr>
                                                          <tr>
                                                            <th scope="col">Detail</th>
                                                            <td scope="col">{{$claim->detail}}</td>
                                                          </tr>
                                                          <tr>
                                                            <th>Trip</th>
                                                            <td scope="col">
                                                                <div class="d-grid text-center" style="font-size: 0.7rem">
                                                                    <span>{{$claim->origin}}</span> 
                                                                    <span class="text-primary"><i class="fa-solid fa-circle-arrow-down mx-2"></i></span> 
                                                                    <span>{{$claim->destination}} </span>
                                                                </div>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <th>Project</th>
                                                            <td scope="col">
                                                                @foreach ($projectx as $project)
                                                                    @if ($project->code === $claim->project)
                                                                        {{$project->name}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                          </tr>
                                                      </table>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <label for="ref" class="form-label">Reject this claim?</label>
                                                    <input type="text" class="form-control" name="reject_reason" placeholder="Specify your reject reason" value="{{$claim->reject_reason}}" required>
                                                </div>
                                                <input type="hidden" class="form-control" value="m" name="type">
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="modal-footer">
                                            {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td colspan="6" class="text-center">&nbsp;</td>
                </tr>


                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td  colspan="4" class="text-start  text-uppercase text-dark"><b>B. Parking, Toll and Taxi</b></td>
                </tr>
                @if(count($parkings)>0)
                    @foreach($parkings as $claim)
                    @if ($claim->status === 2)
                        <tr class="text-dark text-start bg-danger " style="--bs-bg-opacity: .2;">
                        
                    @else
                        <tr class="text-dark text-start">
                    @endif

                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j/M', strtotime($claim->date));}}</td>
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
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-link px-0" data-bs-target="#updateClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square text-primary fw-bold"></i></button>
                                @if (Session::get('role') === '1')
                                    <button class="btn btn-link px-0" data-bs-target="#rejectClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-regular fa-circle-xmark text-danger fw-bold"></i></button>
                                    @include('claim.modal-edit')
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td colspan="6" class="text-center">&nbsp;</td>
                </tr>


                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td colspan="4" class="text-start  text-uppercase text-dark"><b>C. Accomodations</b></td>
                </tr>
                @if(count($accomodations)>0)
                    @foreach($accomodations as $claim)
                    @if ($claim->status === 2)
                        <tr class="text-dark text-start bg-danger " style="--bs-bg-opacity: .2;">
                    @else
                        <tr class="text-dark text-start">
                    @endif

                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j/M', strtotime($claim->date));}}</td>
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
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-link px-0" data-bs-target="#updateClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square text-primary fw-bold"></i></button>
                                @if (Session::get('role') === '1')
                                    <button class="btn btn-link px-0" data-bs-target="#rejectClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-regular fa-circle-xmark text-danger fw-bold"></i></button>
                                    @include('claim.modal-edit')
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td colspan="6" class="text-center">&nbsp;</td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td colspan="4" class="text-start  text-uppercase text-dark"><b>D. Project Equipments</b></td>
                </tr>
                @if(count($projects)>0)
                    @foreach($projects as $claim)
                    @if ($claim->status === 2)
                        <tr class="text-dark text-start bg-danger " style="--bs-bg-opacity: .2;">
                    @else
                        <tr class="text-dark text-start">
                    @endif
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j/M', strtotime($claim->date));}}</td>
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
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-link px-0" data-bs-target="#updateClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square text-primary fw-bold"></i></button>
                                @if (Session::get('role') === '1')
                                    <button class="btn btn-link px-0" data-bs-target="#rejectClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-regular fa-circle-xmark text-danger fw-bold"></i></button>
                                    @include('claim.modal-edit')
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td colspan="6" class="text-center">&nbsp;</td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td colspan="4" class="text-start  text-uppercase text-dark"><b>E. Meals/Entertainment</b></td>
                </tr>
                @if(count($meals)>0)
                    @foreach($meals as $claim)
                    @if ($claim->status === 2)
                        <tr class="text-dark text-start bg-danger" style="--bs-bg-opacity: .2;">
                    @else
                        <tr class="text-dark text-start">
                    @endif
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j/M', strtotime($claim->date));}}</td>
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
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-link px-0" data-bs-target="#updateClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square text-primary fw-bold"></i></button>
                                @if (Session::get('role') === '1')
                                    <button class="btn btn-link px-0" data-bs-target="#rejectClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-regular fa-circle-xmark text-danger fw-bold"></i></button>
                                    @include('claim.modal-edit')
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td colspan="6" class="text-center">&nbsp;</td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td colspan="6" class="text-start  text-uppercase text-dark"><b>F. OFfice Expenses</b></td>
                </tr>
                @if(count($offices)>0)
                    @foreach($offices as $claim)
                    @if ($claim->status === 2)
                        <tr class="text-dark text-start bg-danger " style="--bs-bg-opacity: .2;">
                    @else
                        <tr class="text-dark text-start">
                    @endif
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j/M', strtotime($claim->date));}}</td>
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
                        <td>
                            <div class="d-flex justify-content-center" >
                                <button class="btn btn-link px-0" data-bs-target="#updateClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square text-primary fw-bold"></i></button>
                                @if (Session::get('role') === '1')
                                    <button class="btn btn-link px-0" data-bs-target="#rejectClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-regular fa-circle-xmark text-danger fw-bold"></i></button>
                                    @include('claim.modal-edit')
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td colspan="6" class="text-center">&nbsp;</td>
                </tr>

                <tr class="text-dark text-start">
                    <td  class="text-center"></td>
                    <td  class="text-center"></td>
                    <td colspan="4" class="text-start  text-uppercase text-dark"><b>G. Others</b></td>
                </tr>
                @if(count($others)>0)
                    @foreach($others as $claim)
                    @if ($claim->status === 2)
                        <tr class="text-dark text-start bg-danger " style="--bs-bg-opacity: .2;">
                    @else
                        <tr class="text-dark text-start">
                    @endif
                        <td  class="text-center">{{++$count}}.</td>
                        <td  class="text-center">{{date('j/M', strtotime($claim->date));}}</td>
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
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-link px-0" data-bs-target="#updateClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square text-primary fw-bold"></i></button>
                                @if (Session::get('role') === '1')
                                    <button class="btn btn-link px-0" data-bs-target="#rejectClaim{{$claim->id}}" data-bs-toggle="modal"><i class="fa-regular fa-circle-xmark text-danger fw-bold"></i></button>
                                    @include('claim.modal-edit')
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                <tr class="text-dark text-start">
                    <td colspan="6" class="text-center">&nbsp;</td>
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