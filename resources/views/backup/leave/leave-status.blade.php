@extends('layouts.list')
@section('content') 
    <div class="container w-75">
        <p class="text-center fs-6 mt-2 fs-1 fw-bold">Leave Status<br></p>
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
                    @if(count($pendings) > 0)
                    @foreach($pendings as $leave)
                        <ul class="list-group list-group mt-2">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex justify-content-start">
                                        @if ($leave->leave_type === 'AL')
                                        <span class="badge bg-success rounded-pill"><i class="fa-solid fa-a fa-2x mt-2 p-1 mx-2 text-white"></i>
                                        </span>
        
                                        @elseif ($leave->leave_type === 'ML')
                                        <span class="badge bg-warning rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-dark"></i></span>
        
                                        @else 
                                        <span class="badge bg-danger rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-white"></i></span>
                                        
                                        @endif
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold fs-5">{{$leave->reason}} 
                
                                            </div>
                                                <span>{{date('j-M', strtotime($leave->start_date));}} to {{date('j-M', strtotime($leave->end_date));}} </span> <b> ({{$leave->days}} days)</b>
                                            
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <div class="ms-2 me-auto">
                                            <div>
                                                @if($leave->status === '1')
                                                <span class="badge bg-success text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Approved</span> 
        
                                                @elseif($leave->status === '2')
                                                <span class="badge bg-danger text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Rejected</span> 
        
                                                @else
                                                <button data-bs-target="#cancel{{$leave->id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill fs-6 "><i class="fa-solid fa-xmark"></i></button>
                                                <span class="badge bg-warning text-dark px-2 rounded-pill fw-bold fs-6 px-5 py-2">Pending</span> 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                        </ul>

                        <div class="modal fade" id="cancel{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center" id="exampleModalLabel">Cancel Leave Application?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action = "{{route('leave.delete', $leave->id)}}" method="GET" enctype="multipart/form-data">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            Are you sure you want to cancel your <b>{{$leave->days}} day(s) </b> of <b>
                                            @if ($leave->leave_type === 'EL')
                                                Emergency Leave
                                            @elseif ($leave->leave_type === 'ML')
                                                Medical Leave
                                            
                                            @else
                                                Annual Leave
                                            @endif
                                            </b> application?
                                            This action is reversible.
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
                                    <div class="d-flex justify-content-start">
                                        @if ($leave->leave_type === 'AL')
                                        <span class="badge bg-success rounded-pill"><i class="fa-solid fa-a fa-2x mt-2 p-1 mx-2 text-white"></i>
                                        </span>
        
                                        @elseif ($leave->leave_type === 'ML')
                                        <span class="badge bg-warning rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-dark"></i></span>
        
                                        @else 
                                        <span class="badge bg-danger rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-white"></i></span>
                                        
                                        @endif
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold fs-5">{{$leave->reason}}  </div>
                                                <span>{{date('j-M', strtotime($leave->start_date));}} to {{date('j-M', strtotime($leave->end_date));}} </span> <b> ({{$leave->days}} days)</b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <div class="ms-2 me-auto">
                                            <div>
                                                <div>
                                                    @if($leave->status === '1')
                                                    <span class="badge bg-success text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Approved</span> 
            
                                                    @elseif($leave->status === '2')
                                                    <span class="badge bg-danger text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Rejected</span> 
            
                                                    @else
                                                    <span class="badge bg-warning text-dark px-2 rounded-pill fw-bold fs-6 px-5 py-2">Pending</span> 
                                                    @endif
                                                </div>
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
                    @foreach($rejected as $leave)
                        <ul class="list-group list-group mt-2">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex justify-content-start">
                                        @if ($leave->leave_type === 'AL')
                                        <span class="badge bg-success rounded-pill"><i class="fa-solid fa-a fa-2x mt-2 p-1 mx-2 text-white"></i>
                                        </span>
        
                                        @elseif ($leave->leave_type === 'ML')
                                        <span class="badge bg-warning rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-dark"></i></span>
        
                                        @else 
                                        <span class="badge bg-danger rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-white"></i></span>
                                        
                                        @endif
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold fs-5">{{$leave->reason}}  </div>
                                                <span>{{date('j-M', strtotime($leave->start_date));}} to {{date('j-M', strtotime($leave->end_date));}} </span> <b> ({{$leave->days}} days)</b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <div class="ms-2 me-auto">
                                            <div>
                                                <div>
                                                    @if($leave->status === '1')
                                                    <span class="badge bg-success text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Approved</span> 
            
                                                    @elseif($leave->status === '2')
                                                    <span class="me-2">{{$leave->reject_reason}}</span> 
                                                    <span class="badge bg-danger text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Rejected</span> 
            
                                                    @else
                                                    <span class="badge bg-warning text-dark px-2 rounded-pill fw-bold fs-6 px-5 py-2">Pending</span> 
                                                    @endif
                                                </div>
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
                    @foreach($all as $leave)
                        <ul class="list-group list-group mt-2">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="d-flex justify-content-start">
                                        @if ($leave->leave_type === 'AL')
                                        <span class="badge bg-success rounded-pill"><i class="fa-solid fa-a fa-2x mt-2 p-1 mx-2 text-white"></i>
                                        </span>
        
                                        @elseif ($leave->leave_type === 'ML')
                                        <span class="badge bg-warning rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-dark"></i></span>
        
                                        @else 
                                        <span class="badge bg-danger rounded-pill"><i class="fa-solid fa-m fa-2x mt-2 p-1 mx-2 text-white"></i></span>
                                        
                                        @endif
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold fs-5">{{$leave->reason}}  </div>
                                                <span>{{date('j-M', strtotime($leave->start_date));}} to {{date('j-M', strtotime($leave->end_date));}} </span> <b> ({{$leave->days}} days)</b>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-2">
                                        <div class="ms-2 me-auto">
                                            <div>
                                                <div>
                                                    @if($leave->status === '1')
                                                    <span class="badge bg-success text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Approved</span> 
            
                                                    @elseif($leave->status === '2')
                                                    <span class="me-2">{{$leave->reject_reason}}</span> 
                                                    <span class="badge bg-danger text-white px-2 rounded-pill fw-bold fs-6 px-5 py-2">Rejected</span> 
            
                                                    @else
                                                    <button data-bs-target="#cancel1{{$leave->id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill fs-6 "><i class="fa-solid fa-xmark"></i></button>
                                                    <span class="badge bg-warning text-dark px-2 rounded-pill fw-bold fs-6 px-5 py-2">Pending</span> 
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                        </ul>
                        {{-- Reject Modal --}}
                        <div class="modal fade" id="cancel1{{$leave->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center" id="exampleModalLabel">Cancel Leave Application?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action = "{{route('leave.delete', $leave->id)}}" method="GET" enctype="multipart/form-data">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            Are you sure you want to cancel your <b>{{$leave->days}} day(s) </b> of <b>
                                            @if ($leave->leave_type === 'EL')
                                                Emergency Leave
                                            @elseif ($leave->leave_type === 'ML')
                                                Medical Leave
                                            
                                            @else
                                                Annual Leave
                                            @endif
                                            </b> application?
                                            This action is reversible.
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