@extends('layouts.list')
@section('content')
 
<?php use App\Http\Controllers\ClaimController;?>
        <p class="text-center fs-6 mt-2 fs-1 fw-bold">Leaves List<br></p>
        <div class="container w-75">

            <ul class="nav nav-pills mb-3 justify-content-center mt-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link  fs-4 fw-bold rounded-pill" id="pills-one-tab" data-bs-toggle="pill" data-bs-target="#pills-one" type="button" role="tab" aria-controls="pills-one" aria-selected="true">Pending</button>
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
                        @if(count($pendings) > 0)
                            @foreach($pendings as $leave)
                                <ul class="list-group list-group mt-2">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 d-flex justify-content-start">
                                            <div class="d-grid my-auto me-3 px-1 gap-1">
                                                <i class="fa-regular fa-calendar-xmark text-dark fa-folder-open fa-3x mx-auto"></i>
                                                @if (($leave->leave_type) === 'ML')
                                                    <button type="button" class="badge bg-primary text-uppercae fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModa{{$leave->id}}">
                                                    ML
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModa{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medical Certificate</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="{{asset('storage/leave/mc/'.$leave->mc_cert)}}" style="width: 100%;"alt="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>

                                                @elseif (($leave->leave_type) === 'AL')
                                                    <button class="badge bg-warning text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @else
                                                    <button class="badge bg-danger text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @endif
                                            </div>
                                            <div class="d-grid my-auto">
                                                <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Reason: </b>{{$leave->reason}} </div>
                                                <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">{{$leave->name}} </div>
                                                <div class="text-muted" style="font-size: 0.8rem;">{{date('j-M', strtotime($leave->start_date));}} to  {{date('j-M', strtotime($leave->end_date))}} ({{$leave->days}} days)</div>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2 my-auto">
                                            <button data-bs-target="#approve{{$leave->id}}" data-bs-toggle="modal" class="badge bg-success rounded-pill width-status">Approve</button>
                                            <button data-bs-target="#reject{{$leave->id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill  width-status">Reject</button>
                                        </div>
                                    </li>
                                </ul>
                            
                                {{-- Approve Modal --}}
                                <div class="modal fade" id="approve{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="exampleModalLabel">Approve <b>{{$leave->name}}'s </b>Leave Application?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure to approve <b>{{$leave->days}} days</b> of leave for <b>{{$leave->name}}</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-success" href="{{route('leave.approve', $leave->id)}}"><b>Confirm</b></a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Reject Modal --}}
                                <div class="modal fade" id="reject{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Reject <b>{{$leave->name}}'s </b>Leave Application?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action = "{{route('leave.reject', $leave->id)}}" method="GET" enctype="multipart/form-data">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="reject_reason" class="form-label">Reject Reason:</label>
                                                    <input type="text" class="form-control" maxlength="50" name="reject_reason" placeholder="Specify why you reject this application..."required>
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
                            @foreach($approved as $leave)
                                <ul class="list-group list-group mt-2">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 d-flex justify-content-start">
                                            <div class="d-grid my-auto me-3 px-1 gap-1">
                                                <i class="fa-regular fa-calendar-xmark text-dark fa-folder-open fa-3x mx-auto"></i>
                                                @if (($leave->leave_type) === 'ML')
                                                    <button type="button" class="badge bg-primary text-uppercae fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal{{$leave->id}}">
                                                    ML
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medical Certificate</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="{{asset('storage/leave/mc/'.$leave->mc_cert)}}" style="width: 100%;"alt="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>

                                                @elseif (($leave->leave_type) === 'AL')
                                                    <button class="badge bg-warning text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @else
                                                    <button class="badge bg-danger text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @endif
                                            </div>
                                            <div class="d-grid my-auto">
                                                <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Reason: </b>{{$leave->reason}} </div>
                                                <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">{{$leave->name}} </div>
                                                <div class="text-muted" style="font-size: 0.8rem;">{{date('j-M', strtotime($leave->start_date));}} to  {{date('j-M', strtotime($leave->end_date))}} ({{$leave->days}} days)</div>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2 my-auto">
                                            <button class="badge bg-success rounded-pill width-status disabled opacity-75">Approved</button>
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
                            @foreach($rejected as $leave)
                                <ul class="list-group list-group mt-2">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 d-flex justify-content-start">
                                            <div class="d-grid my-auto me-3 px-1 gap-1">
                                                <i class="fa-regular fa-calendar-xmark text-dark fa-folder-open fa-3x mx-auto"></i>
                                                @if (($leave->leave_type) === 'ML')
                                                    <button type="button" class="badge bg-primary text-uppercae fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal2{{$leave->id}}">
                                                    ML
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal2{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medical Certificate</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="{{asset('storage/leave/mc/'.$leave->mc_cert)}}" style="width: 100%;"alt="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>

                                                @elseif (($leave->leave_type) === 'AL')
                                                    <button class="badge bg-warning text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @else
                                                    <button class="badge bg-danger text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @endif
                                            </div>
                                            <div class="d-grid my-auto">
                                                <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Reason: </b>{{$leave->reason}} </div>
                                                <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">{{$leave->name}} </div>
                                                <div class="text-muted" style="font-size: 0.8rem;">{{date('j-M', strtotime($leave->start_date));}} to  {{date('j-M', strtotime($leave->end_date))}} ({{$leave->days}} days)</div>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2 my-auto">
                                            <button class="badge bg-danger rounded-pill width-status disabled opacity-75">Rejected</button>
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
                            @foreach($all as $leave)
                                <ul class="list-group list-group mt-2">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 d-flex justify-content-start">
                                            <div class="d-grid my-auto me-3 px-1 gap-1">
                                                <i class="fa-regular fa-calendar-xmark text-dark fa-folder-open fa-3x mx-auto"></i>
                                                @if (($leave->leave_type) === 'ML')
                                                    <button type="button" class="badge bg-primary text-uppercae fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal3{{$leave->id}}">
                                                    ML
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal3{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Medical Certificate</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="{{asset('storage/leave/mc/'.$leave->mc_cert)}}" style="width: 100%;"alt="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>

                                                @elseif (($leave->leave_type) === 'AL')
                                                    <button class="badge bg-warning text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @else
                                                    <button class="badge bg-danger text-dark text-uppercase fw-bold" disabled>{{$leave->leave_type}}</button>
                                                @endif
                                            </div>
                                            <div class="d-grid my-auto">
                                                <div class="fst-italic text-uppercase" style="font-size: 1.2rem;"><b>Reason: </b>{{$leave->reason}} </div>
                                                <div class="fw-bolder text-capitalize" style="font-size: 1.0rem;">{{$leave->name}} </div>
                                                <div class="text-muted" style="font-size: 0.8rem;">{{date('j-M', strtotime($leave->start_date));}} to  {{date('j-M', strtotime($leave->end_date))}} ({{$leave->days}} days)</div>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2 my-auto">
                                            @if ($leave->status !== '0')
                                                @if ($leave->status === '2')
                                                <button class="badge bg-danger rounded-pill width-status opacity-75" disabled><a class="text-decoration-none text-white">Rejected</a></button>
                                                @else
                                                <button class="badge bg-success rounded-pill width-status opacity-75" disabled><a class="text-decoration-none text-white">Approved</a></button>
                                                @endif
                                            @else
                                                <button data-bs-target="#approve1{{$leave->id}}" data-bs-toggle="modal" class="badge bg-success rounded-pill  width-status">Approve</a></button>
                                                <button data-bs-target="#reject1{{$leave->id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill  width-status">Reject</a></button>
                                            @endif
                                        </div>
                                    </li>
                                </ul>

                            
                                {{-- Approve Modal --}}
                                <div class="modal fade" id="approve1{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Approve <b>{{$leave->name}}'s </b>Leave Application?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure to approve <b>{{$leave->days}} days</b> of leave for <b>{{$leave->name}}</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-success" href="{{route('leave.approve', $leave->id)}}"><b>Confirm</b></a>
y                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Reject Modal --}}
                                <div class="modal fade" id="reject1{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Reject <b>{{$leave->name}}'s </b>Leave Application?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action = "{{route('leave.reject', $leave->id)}}" method="GET" enctype="multipart/form-data">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="reject_reason" class="form-label">Reject Reason:</label>
                                                    <input type="text" class="form-control" maxlength="50" name="reject_reason" placeholder="Specify why you reject this application..."required>
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
