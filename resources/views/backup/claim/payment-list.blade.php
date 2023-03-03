@extends('layouts.app')
@section('content') 
<?php use App\Http\Controllers\PaymentController;?>
    <div class="container w-75">
        <p class="text-center fs-6 mt-2 fs-1 fw-bold">Payment List<br></p>

        <div class="pending-list">
            @if(count($staffs) > 0)
            @foreach($staffs as $staff)
                <ul class="list-group list-group mt-2">
                        <li class="list-group-item d-flex justify-content-between align-items-start ">
                            <div class="d-flex justify-content-start">
                                <img >
                                <i class="fa-solid fa-user-secret fa-5x mt-1 mx-2"></i>
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold fs-4 mt-2">{{$staff->name}}: {{$staff->staff_id}}</div>
                                    @if (PaymentController::calcPayment($staff->staff_id) === 0)
                                    <span class="text-muted fs-6"> Pending Payment: <span class="bg-primary text-white rounded-pill px-4 fw-bold">RM 0.00</span></span><br>
                                    @else
                                    <span class="text-muted fs-6"> Pending Payment: <span class="bg-danger text-white rounded-pill px-4 fw-bold">RM {{(PaymentController::calcPayment($staff->staff_id))}}</span></span><br>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <div class="ms-2 me-auto">
                                    <div class="d-grid gap-2 col-6 mb-2">
                                        @if ((PaymentController::calcPayment($staff->staff_id))> 0) 
                                        <button class="badge bg-danger rounded-pill fs-6" data-bs-target="#myModal{{$staff->staff_id}}" data-bs-toggle="modal"><i class="fa-solid fa-sack-dollar"></i> Make Payment</button>

                                        @else
                                        <button class="badge bg-primary rounded-pill fs-6 opacity-75"disabled><i class="fa-solid fa-sack-dollar"></i> Make Payment</button>
                                        @endif
                                        {{-- <button class="badge bg-secondary rounded-pill fs-6 "><a href="#" class="text-decoration-none text-white"><i class="fa-solid fa-file-pdf"></i> View Report</a></button> --}}
                                    </div>
                                </div>
                            </div>
                        </li>
                </ul>

                {{-- Payment Modal --}}
                <div class="modal fade" id="myModal{{$staff->staff_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="exampleModalLabel">Pay <b>RM {{(PaymentController::calcPayment($staff->staff_id))}}</b> to {{$staff->name}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {!!Form::open(['action' => ['\App\Http\Controllers\PaymentController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="payment_date" class="form-label">Payment Date:</label>
                                    <input type="date" class="form-control" name="payment_date" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="payment_ref" class="form-label">Receipt No. (Optional)</label>
                                    <input type="text" class="form-control" name="payment_ref" placeholder="Enter receipt number">
                                </div>       
                                <input type="hidden" class="form-control" value="{{$staff->staff_id}}" name="id">
                            </div>
                            
                            
                        </div>
                        <div class="modal-footer">
                            {{-- {{Form::hidden('_method','PUT')}} --}}
                            {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                        </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                
            @endforeach
            
            @else
            <div class="col w-100 mt-5">
                <p class="text-center">No record found</p>
            </div>
            @endif
        </div>
    </div>

@endsection