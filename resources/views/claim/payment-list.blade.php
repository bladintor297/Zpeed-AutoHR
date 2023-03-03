@extends('layouts.app')
@section('content') 
<?php use App\Http\Controllers\PaymentController;?>
    <div class="container w-75">
        <p class="text-center fs-6 mt-2 fs-1 fw-bold">Payment List<br></p>

        <div class="pending-list">
            @if(count($staffs) > 0)
            @foreach($staffs as $staff)
                <ul class="list-group list-group mt-2">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 d-flex justify-content-start">
                            <div class="d-grid my-auto me-3 px-1">
                                <i class="fa-solid fa-folder-open fa-3x mx-auto"></i>
                            </div>
                            <div class="d-grid">
                                <div class="fw-bolder" style="font-size: 1.2rem;">{{$staff->name}} 
                                    
                                </div>
                                <div class="fst-italic" style="font-size: 0.8rem;">Pending Payment:
                                    @if (PaymentController::calcPayment($staff->staff_id) === 0)
                                    <span class="badge bg-primary">RM 0.00</span>

                                    @else
                                    <span class="badge bg-danger">RM {{(PaymentController::calcPayment($staff->staff_id))}}</span>

                                    @endif 
                                </div>
                            </div>
                        </div>

                        <div class="d-grid align-items-end my-auto gap-2">
                            @if ((PaymentController::calcPayment($staff->staff_id))> 0) 
                            <button class="badge bg-danger rounded-pill" data-bs-target="#myModal{{$staff->staff_id}}" data-bs-toggle="modal"><i class="fa-solid fa-sack-dollar"></i> Make Payment</button>

                            @else
                            <button class="badge bg-primary rounded-pill opacity-75"disabled><i class="fa-solid fa-sack-dollar"></i> Make Payment</button>
                            @endif
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