@extends('layouts.list')
@section('content') 
<div class="container w-75">
    <p class="text-center fs-6 mt-2 fs-1 fw-bold">Projects List<br></p>
    <ul class="nav nav-pills mb-3 justify-content-center mt-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-three-tab" data-bs-toggle="pill" data-bs-target="#pills-three" type="button" role="tab" aria-controls="pills-three" aria-selected="false">All</button>
          </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-one-tab" data-bs-toggle="pill" data-bs-target="#pills-one" type="button" role="tab" aria-controls="pills-one" aria-selected="true">Active</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-two-tab" data-bs-toggle="pill" data-bs-target="#pills-two" type="button" role="tab" aria-controls="pills-two" aria-selected="false">Completed</button>
        </li>
        

        
      </ul>
      <div class="tab-content" id="pills-tabContent">
        {{-- Active List --}}
        <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
            <div class="active-list">
                @if(count($actives) > 0)
                @foreach($actives as $project)
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-folder-open fa-3x mt-1 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$project->name}} ({{$project->code}}) 
                                            @if ($project->status === '1')
                                            <span class="badge bg-success">Completed</span>

                                            @elseif ($project->status === '0')
                                            <span class="badge bg-warning text-dark">Ongoing</span>

                                            @endif
                                        </span></div>
                                        <div class="text-muted fs-6"><b>Start Date: </b>{{date('j-M-Y', strtotime($project->start_date));}}
                                            @if ($project->status === '1')
                                            <span>| <b>End Date: </b>{{date('j-M-Y', strtotime($project->start_date));}}</span>
                                            @endif
                                        </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-secondary rounded-pill fs-6"><a href="project/{{$project->id}}"class="text-decoration-none text-white">View Report</a></button>
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

        {{-- Completed List --}}
        <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab">
            <div class="completed-list">
                @if(count($completed) > 0)
                @foreach($completed as $project)
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-folder-open fa-3x mt-1 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$project->name}} ({{$project->code}}) 
                                            @if ($project->status === '1')
                                            <span class="badge bg-success">Completed</span>

                                            @elseif ($project->status === '0')
                                            <span class="badge bg-warning text-dark">Ongoing</span>

                                            @endif
                                        </span></div>
                                        <div class="text-muted fs-6"><b>Start Date: </b>{{date('j-M-Y', strtotime($project->start_date));}}
                                            @if ($project->status === '1')
                                            <span>| <b>End Date: </b>{{date('j-M-Y', strtotime($project->start_date));}}</span>
                                            @endif
                                        </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-secondary rounded-pill fs-6"><a href="project/{{$project->id}}"class="text-decoration-none text-white">View Report</a></button>
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
        <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab">
            <div class="all-list">
                @if(count($all) > 0)
                @foreach($all as $project)
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-folder-open fa-3x mt-1 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$project->name}} ({{$project->code}}) 
                                            @if ($project->status === '1')
                                            <span class="badge bg-success">Completed</span>

                                            @elseif ($project->status === '0')
                                            <span class="badge bg-warning text-dark">Ongoing</span>

                                            @endif
                                        </span></div>
                                        <div class="text-muted fs-6"><b>Start Date: </b>{{date('j-M-Y', strtotime($project->start_date));}}
                                            @if ($project->status === '1')
                                            <span>| <b>End Date: </b>{{date('j-M-Y', strtotime($project->start_date));}}</span>
                                            @endif
                                        </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-secondary rounded-pill fs-6"><a href="project/{{$project->id}}"class="text-decoration-none text-white">View Report</a></button>
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