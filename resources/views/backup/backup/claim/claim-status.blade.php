@extends('layouts.list')
@section('content') 
<?php use App\Http\Controllers\ClaimController;?>
<div class="container w-75">
    <p class="text-center fs-6 mt-2 fs-1 fw-bold">Claim Status<br></p>
    <ul class="nav nav-pills mb-3 justify-content-center mt-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-one-tab" data-bs-toggle="pill" data-bs-target="#pills-one" type="button" role="tab" aria-controls="pills-one" aria-selected="true">Pending</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-two-tab" data-bs-toggle="pill" data-bs-target="#pills-two" type="button" role="tab" aria-controls="pills-two" aria-selected="false">Approved</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-three-tab" data-bs-toggle="pill" data-bs-target="#pills-three" type="button" role="tab" aria-controls="pills-three" aria-selected="false">Rejected</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-four-tab" data-bs-toggle="pill" data-bs-target="#pills-four" type="button" role="tab" aria-controls="pills-four" aria-selected="false">All</button>
        </li>
        
      </ul>
      <div class="tab-content" id="pills-tabContent">

        {{-- Pending List --}}
        <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
            <div class="pending-list">
                @if(count($pending) > 0)
                @foreach($pending as $ref)
                <?php $var = ClaimController::checkClaim($ref) ?>
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-file-invoice-dollar fa-3x mt-1 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Claim Date:</span> {{date("F j, Y, (g:i a)", strtotime($var->created_at));}} </div>
                                        <span class="text-muted fs-5"><b>Total Claim: RM </b> {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                        <span class="text-muted fs-5"> | <b>Status: </b></span>
                                        <span class="text-muted fs-6">
                                            <span class="bade bg-warning text-dark px-2 rounded-pill fw-bold">Pending</span> 
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-warning rounded-pill fs-6 "><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark ">View</a></button>
                                            <button data-bs-target="#cancel{{$ref}}" data-bs-toggle="modal"  class="badge bg-danger rounded-pill fs-6">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                    </ul>
                    {{-- Reject Modal --}}
                    <div class="modal fade" id="cancel{{$ref}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Cancel Claim Application?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action = "{{route('claim.delete', $ref)}}" method="GET" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        Are you sure you want to cancel your <b>RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</b> claim?
                                        This action is reversible and you need to redo your claim.
                                    </div>
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
                @endforeach
                
                @else
                <div class="col w-100 mt-5">
                    <p class="text-center">No record found</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Approved List --}}
        <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab">
            <div class="approved-list">
                @if(count($approved) > 0)
                @foreach($approved as $ref)
                <?php $var = ClaimController::checkClaim($ref) ?>
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-file-invoice-dollar fa-3x mt-1 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Claim Date:</span> {{date("F j, Y, (g:i a)", strtotime($var->created_at));}} 
                                            @if ($var->payment_status === 1)
                                            <span class="text-white fw-bolder badge bg-dark">#PAID</span>
                                            @endif
                                        </div>
                                        <span class="text-muted fs-5"><b>Total Claim: RM </b> {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                        <span class="text-muted fs-5"> | <b>Status: </b></span>
                                        <span class="text-muted fs-6">
                                            <span class="bade bg-success text-white px-2 rounded-pill fw-bold">Approved</span> 
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-warning rounded-pill fs-6 "><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark ">View</a></button>
                                            {{-- {!!Form::open(['action' => ['\App\Http\Controllers\BrandController@destroy', $brand->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!} --}}
                                                {{-- {{Form::hidden('_method', 'DELETE')}}    --}}
                                                <button type="submit" class="badge bg-danger rounded-pill fs-6 opacity-75" disabled>Cancel</button>
                                            {{-- {!!Form::close()!!} --}}
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

        {{-- Rejected List --}}
        <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab">
            <div class="rejected-list">
                @if(count($rejected) > 0)
                @foreach($rejected as $ref)
                <?php $var = ClaimController::checkClaim($ref) ?>
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-file-invoice-dollar fa-3x mt-1 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Claim Date:</span> {{date("F j, Y, (g:i a)", strtotime($var->created_at));}} </div>
                                        <span class="text-muted fs-5"><b>Total Claim: RM </b> {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                        <span class="text-muted fs-5"> | <b>Status: </b></span>
                                        <span class="text-muted fs-6">
                                            <span class="bade bg-danger text-white px-2 rounded-pill fw-bold">Rejected</span> 
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <span>{{$var->reject_reason}}</span>
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-warning rounded-pill fs-6 "><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark ">View</a></button>
                                            <button type="submit" class="badge bg-danger rounded-pill fs-6 opacity-75" disabled>Cancel</button>
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

        {{-- All List --}}
        <div class="tab-pane fade" id="pills-four" role="tabpanel" aria-labelledby="pills-four-tab">
            <div class="all-list">
                @if(count($all) > 0)
                @foreach($all as $ref)
                <?php $var = ClaimController::checkClaim($ref) ?>
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-file-invoice-dollar fa-3x mt-1 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Claim Date:</span> {{date("F j, Y, (g:i a)", strtotime($var->created_at));}} 
                                            @if ($var->payment_status === 1)
                                                <span class="text-white fw-bolder badge bg-dark">#PAID</span>
                                            @endif
                                            </div>
                                        <span class="text-muted fs-5"><b>Total Claim: RM </b> {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                        <span class="text-muted fs-5"> | <b>Status: </b></span>
                                        <span class="text-muted fs-6">
                                            @if($var->status === 1)
                                            <span class="bade bg-success text-white px-2 rounded-pill fw-bold">Approved</span> 
    
                                            @elseif($var->status === 2)
                                            <span class="bade bg-danger text-white px-2 rounded-pill fw-bold">Rejected</span> 
                                            
                                            @else
                                            <span class="bade bg-warning text-dark px-2 rounded-pill fw-bold">Pending</span> 
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    @if ($var->status === 2)
                                    <span>{{$var->reject_reason}}</span>
                                    @endif
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-warning rounded-pill fs-6 "><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark ">View</a></button>
                                            {{-- {!!Form::open(['action' => ['\App\Http\Controllers\BrandController@destroy', $brand->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!} --}}
                                                {{-- {{Form::hidden('_method', 'DELETE')}}    --}}
                                                @if($var->status === 0)
                                                <button data-bs-target="#cancel1{{$ref}}" data-bs-toggle="modal"  class="badge bg-danger rounded-pill fs-6">Cancel</button>

                                                @else
                                                <button type="submit" class="badge bg-danger rounded-pill fs-6 opacity-75" disabled>Cancel</button>
                                                @endif
                                            {{-- {!!Form::close()!!} --}}
                                        </div>
                                    </div>
                                </div>
                            </li>
                    </ul>

                    {{-- Reject Modal --}}
                    <div class="modal fade" id="cancel1{{$ref}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Cancel Claim Application?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action = "{{route('claim.delete', $ref)}}" method="GET" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        Are you sure you want to cancel your <b>RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</b> claim?
                                        This action is reversible and you need to redo your claim.
                                    </div>
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
                @endforeach
                
                @else
                <div class="col w-100 mt-5">
                    <p class="text-center">No record found</p>
                </div>
                @endif
            </div>
        </div>
      </div>
</div>
    <script>
        const pillsTab = document.querySelector('#pills-tab');
        const pills = pillsTab.querySelectorAll('button[data-bs-toggle="pill"]');

        pills.forEach(pill => {
        pill.addEventListener('shown.bs.tab', (event) => {
            const { target } = event;
            const { id: targetId } = target;
            
            savePillId(targetId);
        });
        });

        const savePillId = (selector) => {
        localStorage.setItem('activePillId', selector);
        };

        const getPillId = () => {
        const activePillId = localStorage.getItem('activePillId');
        
        // if local storage item is null, show default tab
        if (!activePillId) return;
        
        // call 'show' function
        const someTabTriggerEl = document.querySelector(`#${activePillId}`)
        const tab = new bootstrap.Tab(someTabTriggerEl);

        tab.show();
        };

        // get pill id on load
        getPillId();
    </script>
@endsection
