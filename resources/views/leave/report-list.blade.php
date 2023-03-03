@extends('layouts.app')
@section('content') 
    <div class="container w-75">
        <p class="text-center fs-6 mt-2 fs-1 fw-bold">Staff List<br></p>

        <div class="pending-list">
            @if(count($staffs) > 0)
            @foreach($staffs as $staff)
                <ul class="list-group list-group mt-2">
                        <li class="list-group-item d-flex justify-content-between align-items-start ">
                            <div class="d-flex justify-content-start">
                                <img src="
                                    @if ($staff->picture === $defaultImage)
                                        {{$staff->picture}}
                                    @else
                                        {{url('storage/upload/profile/'.$staff->picture)}}
                                    @endif
                                    "
                                    class="card-img-top mt-2" style="max-width:60px; "alt="...">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold fs-4 mt-2">{{$staff->name}}: {{$staff->staff_id}}</div>
                                    <span class="text-muted fs-6"> Balance AL: <span class="bg-success text-white rounded-pill px-2 fw-bold">{{$staff->bal_al}} days</span></span>
                                    <span class="text-muted fs-6 ms-3"> Balance ML: <span class="bg-warning text-dark rounded-pill px-2 fw-bold">{{$staff->bal_ml}} days</span></span><br>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <div class="ms-2 me-auto">
                                    <div class="d-grid gap-2 col-6 mb-2">
                                        @if (count($leave_record)>0)
                                            @foreach ($leave_record as $lr)
                                            {{-- <button disaabled class="badge bg-warning text-dark rounded-pill fs-6 opacity-75">&nbsp;Not Updated</button> --}}

                                                @if ($lr->staff_id === $staff->staff_id)
                                                    @if ($lr->mode === '1')
                                                        <button disabled class="badge bg-primary rounded-pill fs-6 opacity-75">Carry Forward</button>
                                                    @elseif ($lr->mode === '2')
                                                        @if ($lr->cashback === '0')
                                                            <button class="badge bg-danger rounded-pill fs-6" data-bs-target="#cashbackModal{{$lr->id}}" data-bs-toggle="modal">&nbsp;Pay Cashback</button>
                                                        
                                                        @else
                                                            <button disabled class="badge bg-danger rounded-pill fs-6 opacity-75">&nbsp;Pay Cashback</button>
                                                        @endif
                                                    @endif

                                                @else
                                                    @continue
                                                @endif

                                                <!-- Cashback Modal -->
                                                <div class="modal fade" id="cashbackModal{{$lr->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Confirm Approval?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <div class="card-header text-center fw-bold">{{ $staff->name}}</div>
                                                
                                                                <div class="card-body">
                                                                    {!! Form::open(['action' => ['\App\Http\Controllers\LeaveController@edit', $lr->id], 'method'=>'GET']) !!}
                                                                    <div class="d-flex justify-content-evenly mb-3">
                                                                        <div class="badge bg-success">Balance AL: <i>{{$staff->bal_al}} days</i></div>
                                                                        <div class="badge bg-warning text-dark">Balance ML: <i>{{$staff->bal_ml}} days</i></div>
                                                                        <div class="badge bg-danger">Total EL: <i>{{$staff->ent_el}} days</i></div>
                                                                    </div>

                                                                    <div class="row g-3 mt-0" id='show'>
                                                                        <div class="form-group col-md-12 mt-3" >
                                                                            <label for="cashback">{{ __('Total Cash back Amount') }} 
                                                                                <a href="#" data-toggle="tooltip" title="For cashback, do not proceed update if you have not yet make the payment."><i class="fa-solid fa-circle-info"></i></a>
                                                                            </label>
                                                                        <input id="cashback" type="number" min="1" class="form-control" placeholder="Enter cash back amount" placeholder="Enter total cashback amount..." name="cashback">
                                                                        </div>
                                                                    </div>
                                                        
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                
                                                        <div class="modal-footer">

                                                            {{Form::submit('Update', ['class'=>'btn btn-primary fw-bold'])}}
                                                            {!! Form::close() !!}
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                
                                                </div>


                                            @endforeach
                                        @endif
                                        <button class="badge bg-secondary rounded-pill fs-6"><a href="{{route('leave.generatePDF', ['id'=>$staff->staff_id])}}" class="text-decoration-none text-white"><i class="fa-solid fa-file-pdf"></i> &nbsp;View Report</a></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                </ul>
                
                
            @endforeach
            
            @else
            <div class="col w-100 mt-5">
                <p class="text-center">No record found</p>
            </div>
            @endif
        </div>
    </div>

@endsection