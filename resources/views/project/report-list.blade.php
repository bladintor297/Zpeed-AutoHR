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
                            <div class="ms-2 d-flex justify-content-start">
                                <div class="d-grid my-auto me-3 px-1">
                                    <i class="fa-solid fa-folder-open fa-3x mx-auto"></i>
                                    @if ($project->status === '1')
                                    <span class="badge bg-success width-status">Completed</span>

                                    @elseif ($project->status === '0')
                                    <span class="badge text-dark bg-warning width-status">Ongoing</span>

                                    @endif
                                </div>
                                <div class="d-grid">
                                    <div class="fw-bolder" style="font-size: 1.2rem;">{{$project->name}} 
                                        
                                    </div>
                                    <div class="fst-italic" style="font-size: 0.8rem;">{{$project->description}}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">Start Date: {{date('j-M-Y', strtotime($project->start_date));}}</div>
                                </div>
                            </div>

                           <div class="d-grid align-items-end my-auto gap-2">
                                <button class="badge bg-primary rounded-pill px-3 py-1"><a href="project/{{$project->id}}"class="text-decoration-none text-white">View Report</a></button>
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
                            <div class="ms-2 d-flex justify-content-start">
                                <div class="d-grid my-auto me-3 px-1">
                                    <i class="fa-solid fa-folder-open fa-3x mx-auto"></i>
                                    @if ($project->status === '1')
                                    <span class="badge bg-success width-status">Completed</span>

                                    @elseif ($project->status === '0')
                                    <span class="badge text-dark bg-warning width-status">Ongoing</span>

                                    @endif
                                </div>
                                <div class="d-grid">
                                    <div class="fw-bolder" style="font-size: 1.2rem;">{{$project->name}} 
                                        
                                    </div>
                                    <div class="fst-italic" style="font-size: 0.8rem;">{{$project->description}}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">Start Date: {{date('j-M-Y', strtotime($project->start_date));}}</div>
                                </div>
                            </div>

                           <div class="d-grid align-items-end my-auto gap-2">
                                <button class="badge bg-primary rounded-pill px-3 py-1"><a href="project/{{$project->id}}"class="text-decoration-none text-white">View Report</a></button>
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
                            <div class="ms-2 d-flex justify-content-start">
                                <div class="d-grid my-auto me-3 px-1">
                                    <i class="fa-solid fa-folder-open fa-3x mx-auto"></i>
                                    @if ($project->status === '1')
                                    <span class="badge bg-success width-status">Completed</span>

                                    @elseif ($project->status === '0')
                                    <span class="badge text-dark bg-warning width-status">Ongoing</span>

                                    @endif
                                </div>
                                <div class="d-grid">
                                    <div class="fw-bolder" style="font-size: 1.2rem;">{{$project->name}} 
                                        
                                    </div>
                                    <div class="fst-italic" style="font-size: 0.8rem;">{{$project->description}}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">Start Date: {{date('j-M-Y', strtotime($project->start_date));}}</div>
                                </div>
                            </div>

                           <div class="d-grid align-items-end my-auto gap-2">
                                <button class="badge bg-primary rounded-pill px-3 py-1"><a href="project/{{$project->id}}"class="text-decoration-none text-white">View Report</a></button>
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