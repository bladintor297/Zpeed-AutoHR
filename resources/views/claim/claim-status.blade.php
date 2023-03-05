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
                                <div class="ms-2 d-flex justify-content-start">
                                    <div class="d-grid my-auto me-3 gap-1">
                                        <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                        <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                    </div>
                                    <div class="d-grid my-auto">
                                        <div class="text-uppercase" style="font-size: 1.2rem;"><b>Claim ID: </b>{{$ref}} </div>
                                        <div class="fst-italic text-capitalize" style="font-size: 0.8rem;">
                                            <em>
                                                Submitted at: {{date("F j, Y, (g:i a)", strtotime($var->first()->created_at));}}
                                            </em>
                                        </div>
                                        <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Approved Claim: RM {{number_format((float)ClaimController::countApproved($ref), 2, '.', '')}}
                                            <span class="badge bg-warning text-dark px-4 rounded-pill fw-bold" style="font-size: 0.8rem">Pending</span> 
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 my-auto">
                                    <button class="badge bg-warning rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark">View File</a></button>
                                    <button data-bs-target="#cancel{{$ref}}" data-bs-toggle="modal"  class="badge bg-danger rounded-pill">Cancel</button>
                                </div>
                            </li>
                        </ul>
                        
                        {{-- Cancel Modal --}}
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
                            <div class="ms-2 d-flex justify-content-start">
                                <div class="d-grid my-auto me-3 gap-1">
                                    <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                    <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                </div>
                                <div class="d-grid my-auto">
                                    <div class="text-uppercase" style="font-size: 1.2rem;"><b>Claim ID: </b>{{$ref}} </div>
                                    <div class="fst-italic text-capitalize" style="font-size: 0.8rem;">
                                        <em>
                                            Approved at: {{date("F j, Y, (g:i a)", strtotime($var->first()->updated_at));}}
                                        </em>
                                    </div>
                                    <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Approved Claim: RM {{number_format((float)ClaimController::countApproved($ref), 2, '.', '')}}
                                        <span class="badge bg-success px-4 rounded-pill fw-bold" style="font-size: 0.8rem">Approved</span> 
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 my-auto">
                                <button class="badge bg-warning rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark">View File</a></button>
                                <button class="badge bg-danger rounded-pill opacity-75" disabled>Cancel</button>
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
                            <div class="ms-2 d-flex justify-content-start">
                                <div class="d-grid my-auto me-3 gap-1">
                                    <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                    <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                </div>
                                <div class="d-grid my-auto">
                                    <div class="text-uppercase" style="font-size: 1.2rem;"><b>Claim ID: </b>{{$ref}} </div>
                                    <div class="fst-italic text-capitalize" style="font-size: 0.8rem;">
                                        <em>
                                            Reject Reason: {{($var->first()->reject_reason);}}
                                        </em>
                                    </div>
                                    <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Approved Claim: RM {{number_format((float)ClaimController::countApproved($ref), 2, '.', '')}}
                                        <span class="badge bg-danger px-4 rounded-pill fw-bold" style="font-size: 0.8rem">Rejected</span> 
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 my-auto">
                                <button class="badge bg-warning rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark">View File</a></button>
                                <button class="badge bg-danger rounded-pill opacity-75" disabled>Cancel</button>
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
                            <div class="ms-2 d-flex justify-content-start">
                                <div class="d-grid my-auto me-3 gap-1">
                                    <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                    <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                </div>
                                <div class="d-grid my-auto">
                                    <div class="text-uppercase" style="font-size: 1.2rem;"><b>Claim ID: </b>{{$ref}} </div>
                                    @if($var->contains('status', 0))
                                        <div class="fst-italic text-capitalize" style="font-size: 0.8rem;">
                                            <em>
                                                Submitted at: {{date("F j, Y, (g:i a)", strtotime($var->first()->created_at));}}
                                            </em>
                                        </div>
                                        <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Approved Claim: RM {{number_format((float)ClaimController::countApproved($ref), 2, '.', '')}}
                                            <span class="badge bg-warning px-4 rounded-pill fw-bold text-dark" style="font-size: 0.8rem">Pending</span> 
                                        </div>
                                    @elseif($var->contains('status', 1))
                                        <div class="fst-italic text-capitalize" style="font-size: 0.8rem;">
                                            <em>
                                                Approved at: {{date("F j, Y, (g:i a)", strtotime($var->first()->updated_at));}}
                                            </em>
                                        </div>
                                        <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Approved Claim: RM {{number_format((float)ClaimController::countApproved($ref), 2, '.', '')}}
                                            <span class="badge bg-success px-4 rounded-pill fw-bold" style="font-size: 0.8rem">Approved</span> 
                                        </div>
                                    @else
                                        <div class="fst-italic text-capitalize" style="font-size: 0.8rem;">
                                            <em>
                                                Reject Reason: {{($var->first()->reject_reason);}}
                                            </em>
                                        </div>
                                        <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Approved Claim: RM {{number_format((float)ClaimController::countApproved($ref), 2, '.', '')}}
                                            <span class="badge bg-danger px-4 rounded-pill fw-bold" style="font-size: 0.8rem">Rejected</span> 
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if(!($var->contains('status', 0)))
                                <div class="d-grid gap-2 my-auto">
                                    <button class="badge bg-warning rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark">View File</a></button>
                                    <button class="badge bg-danger rounded-pill opacity-75" disabled>Cancel</button>
                                </div>
                            @else
                                <div class="d-grid gap-2 my-auto">
                                    <button class="badge bg-warning rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-dark">View File</a></button>
                                    <button data-bs-target="#cancel1{{$ref}}" data-bs-toggle="modal"  class="badge bg-danger rounded-pill">Cancel</button>
                                </div>
                            @endif
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
