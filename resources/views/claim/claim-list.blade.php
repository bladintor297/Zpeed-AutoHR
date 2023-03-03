@extends('layouts.list')
@section('content') 
<?php use App\Http\Controllers\ClaimController;?>
<div class="container w-75">
    <p class="text-center fs-6 mt-2 fs-1 fw-bold">Claim List<br></p>
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
        <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
            <div class="pending-list">
                @if((count($pending) > 0))
                    @foreach($pending as $ref)
                        <?php $var = ClaimController::checkClaim($ref); $count = 0; ?>
                            <ul class="list-group list-group mt-2">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 d-flex justify-content-start">
                                        <div class="d-grid my-auto me-3 gap-1">
                                            <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                            <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                        </div>
                                        <div class="d-grid my-auto">
                                            <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Name: </b>{{$var->name}} </div>
                                            <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Claim ID: {{$ref}} 
                                                <button class="badge bg-primary rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-white">View File</a></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 my-auto">
                                        <button data-bs-target="#approve{{$ref}}" data-bs-toggle="modal" class="badge bg-success rounded-pill width-status ">Approve</button>
                                        <button data-bs-target="#reject{{$ref}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill width-status ">Reject</button>
                                    </div>
                                </li>
                            </ul>

                            {{-- Approve Modal --}}
                            <div class="modal fade" id="approve{{$ref}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Approve <b>{{$var->name}}'s </b>Claim?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure to approve RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}} claim?
                                        </div>
                                        <div class="modal-footer">
                                            <a type="submit" class="btn btn-success" href="{{route('claim.approve', $ref)}}"><b>Confirm</b></a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Reject Modal --}}
                            <div class="modal fade" id="reject{{$ref}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center" id="exampleModalLabel">Reject <b>{{$var->name}}'s </b>Claim?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action = "{{route('claim.reject', $ref)}}" method="GET" enctype="multipart/form-data">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="reject_reason" class="form-label">Reject Reason:</label>
                                                <input type="text"  maxlength="50" class="form-control" name="reject_reason" placeholder="Specify why you reject this application..."required>
                                            </div>
                                            <input type="hidden" class="form-control" value="{{$var->staff_id}}" name="staff_id">
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
        <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab">
            <div class="approved-list">
                @if((count($approved) > 0))
                @foreach($approved as $ref)
                    <?php $var = ClaimController::checkClaim($ref); $count = 0; ?>
                    <ul class="list-group list-group mt-2">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 d-flex justify-content-start">
                                <div class="d-grid my-auto me-3 gap-1">
                                    <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                    <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                </div>
                                <div class="d-grid my-auto">
                                    <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Name: </b>{{$var->name}} 
                                        <span class="text-white fw-bolder badge bg-success ms-2">#PAID</span>
                                    </div>
                                    <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Claim ID: {{$ref}} 
                                        <button class="badge bg-primary rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-white">View File</a></button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 my-auto">
                                <button class="badge bg-success rounded-pill width-status opacity-75">Approved</button>
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
        <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab">
            <div class="rejected-list">
                @if((count($rejected) > 0))
                    @foreach($rejected as $ref)
                        <?php $var = ClaimController::checkClaim($ref); $count = 0; ?>
                        <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 d-flex justify-content-start">
                                    <div class="d-grid my-auto me-3 gap-1">
                                        <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                        <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                    </div>
                                    <div class="d-grid my-auto">
                                        <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Name: </b>{{$var->name}} 
                                            <span class="text-white fw-bolder badge bg-danger ms-2">#REJECTED</span>
                                        </div>
                                        <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Claim ID: {{$ref}} 
                                            <button class="badge bg-primary rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-white">View File</a></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 my-auto">
                                    <button class="badge bg-danger rounded-pill width-status opacity-75">Rejected</button>
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
        <div class="tab-pane fade" id="pills-four" role="tabpanel" aria-labelledby="pills-four-tab">
            <div class="all-list">
                @if((count($all) > 0))
                    @foreach($all as $ref)
                        <?php $var = ClaimController::checkClaim($ref); $count = 0; ?>
                        <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 d-flex justify-content-start">
                                    <div class="d-grid my-auto me-3 gap-1">
                                        <i class="fa-solid fa-file-invoice-dollar text-dark fa-2x mx-auto"></i>
                                        <span class="text-white fw-bolder badge bg-primary width-status">RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}}</span>
                                    </div>
                                    <div class="d-grid my-auto">
                                        <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Name: </b>{{$var->name}} 
                                            @if ($var->status === 1)
                                            <span class="text-white fw-bolder badge bg-success ms-2">#PAID</span>
                                            @endif

                                            @if ($var->status === 2)
                                            <span class="text-white fw-bolder badge bg-danger ms-2">#REJECTED</span>
                                            @endif
                                        </div>
                                        <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">Claim ID: {{$ref}} 
                                            <button class="badge bg-primary rounded-pill"><a href="/claim/{{$ref}}" target="_blank" class="text-decoration-none text-white">View File</a></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 my-auto">
                                    @if ($var->status === 0)
                                        <button data-bs-target="#approve1{{$ref}}" data-bs-toggle="modal" class="badge bg-success rounded-pill width-status ">Approve</button>
                                        <button data-bs-target="#reject1{{$ref}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill width-status ">Reject</button>

                                    @elseif ($var->status === 2)
                                        <button class="badge bg-success rounded-pill width-status opacity-75" disabled><a class="text-decoration-none text-white">Approved</a></button>
                                        <button class="badge bg-danger rounded-pill width-status opacity-75" disabled><a class="text-decoration-none text-white">Rejected</a></button>
                                        
                                    @else
                                        <button class="badge bg-success rounded-pill width-status opacity-75" disabled><a class="text-decoration-none text-white">Approved</a></button>
                                        <button class="badge bg-danger rounded-pill width-status opacity-75" disabled><a class="text-decoration-none text-white">Rejected</a></button>
                                    @endif
                                    <!-- <button class="badge bg-success rounded-pill width-status opacity-75">Approved</button> -->
                                </div>
                            </li>
                        </ul>
                            
                            {{-- Approve Modal --}}
                            <div class="modal fade" id="approve1{{$ref}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Approve <b>{{$var->name}}'s </b>Claim?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure to approve RM {{number_format((float)ClaimController::countAmount($ref), 2, '.', '')}} claim?
                                        </div>
                                        <div class="modal-footer">
                                            <a type="submit" class="btn btn-success" href="{{route('claim.approve', $ref)}}"><b>Confirm</b></a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Reject Modal --}}
                            <div class="modal fade" id="reject1{{$ref}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center" id="exampleModalLabel">Reject <b>{{$var->name}}'s </b>Claim?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action = "{{route('claim.reject', $ref)}}" method="GET" enctype="multipart/form-data">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="reject_reason" class="form-label">Reject Reason:</label>
                                                <input type="text" class="form-control" maxlength="50" name="reject_reason" placeholder="Specify why you reject this application..."required>
                                            </div>
                                            <input type="hidden" class="form-control" value="{{$var->staff_id}}" name="staff_id">
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