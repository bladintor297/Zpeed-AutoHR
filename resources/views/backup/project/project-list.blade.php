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
                                    <i class="fa-solid fa-folder-open fa-4x mt-2 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$project->name}} ({{$project->code}})
                                            @if ($project->status === '1')
                                            <span class="badge bg-success">Completed</span>

                                            @elseif ($project->status === '0')
                                            <span class="badge text-dark bg-warning">Ongoing</span>

                                            @endif
                                        </span></div>
                                        <div class="fs-6">{{$project->description}}</div>
                                        <div class="text-muted fs-6"><b>Start Date: </b>{{date('j-M-Y', strtotime($project->start_date));}}</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button data-bs-target="#update{{$project->id}}" data-bs-toggle="modal" class="badge bg-warning text-dark rounded-pill fs-6">Update</button>
                                            <button data-bs-target="#delete{{$project->id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill fs-6">Remove</button>
                                    
                                    </div>
                                </div>
                            </li>
                    </ul>
                    {{-- Update Completion --}}
                    <div class="modal fade" id="update{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Update <b>{{$project->name}}</b>?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {!!Form::open(['action' => ['\App\Http\Controllers\ProjectController@update',$project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select id="status" name = "status" class="form-select" onchange="check(this)">
                                            <option value="0" selected >Ongoing</option>
                                            <option value="1">Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" id="end_date" name = "end_date" class="form-control">
                                    </div>          
                                </div>
                                
                                
                            </div>
                            <div class="modal-footer">
                                {{Form::hidden('_method','PUT')}}
                                {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                            </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                    {{-- Delete Project --}}
                    <div class="modal fade" id="delete{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Delete <b>{{$project->name}}</b>?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <b>{{$project->name}}</b> from project record? This action is reversible.
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('project.destroy', ['id' => $project->id]) }}" class="btn btn-danger" ><b>Delete</b></a>
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

        {{-- Completed List --}}
        <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab">
            <div class="completed-list">
                @if(count($completed) > 0)
                @foreach($completed as $project)
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-folder-open fa-4x mt-2 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$project->name}} ({{$project->code}})
                                            @if ($project->status === '1')
                                            <span class="badge bg-success">Completed</span>

                                            @elseif ($project->status === '0')
                                            <span class="badge text-dark bg-warning">Ongoing</span>

                                            @endif
                                        </span></div>
                                        <div class="fs-6">{{$project->description}}</div>
                                        <div class="text-muted fs-6"><b>Start Date:</b> {{date('j-M-Y', strtotime($project->start_date));}}
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
                                            <button disabled class="badge bg-warning text-dark rounded-pill fs-6 opacity-75">Update</button>
                                            <button disabled class="badge bg-danger rounded-pill fs-6 opacity-75">Remove</button>
                                    </div>
                                </div>
                            </li>
                    </ul>

                  
                    {{-- Delete Project --}}
                    <div class="modal fade" id="delete{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Delete <b>{{$project->name}}</b>?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <b>{{$project->name}}</b> from project record? This action is reversible.
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('project.destroy', ['id' => $project->id]) }}" class="btn btn-danger" data-bs-dismiss="modal"><b>Delete</b></a>
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

        {{-- All List --}}
        <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab">
            <div class="rejected-list">
                @if(count($all) > 0)
                @foreach($all as $project)
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-folder-open fa-4x mt-2 mx-2"></i>
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$project->name}} ({{$project->code}})
                                            @if ($project->status === '1')
                                            <span class="badge bg-success">Completed</span>

                                            @elseif ($project->status === '0')
                                            <span class="badge text-dark bg-warning">Ongoing</span>

                                            @endif
                                        </span></div>
                                        <div class="fs-6">{{$project->description}}</div>
                                        <div class="text-muted fs-6"><b>Start Date:</b> {{date('j-M-Y', strtotime($project->start_date));}}
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
                                            @if($project->status === '0')
                                                <button data-bs-target="#update1{{$project->id}}" data-bs-toggle="modal" class="badge bg-warning rounded-pill text-dark fs-6">Update</button>
                                                <button data-bs-target="#delete1{{$project->id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill fs-6">Remove</button>
                                            @else
                                                <button disabled class="badge bg-warning text-dark rounded-pill fs-6 opacity-75">Update</button>
                                                <button disabled class="badge bg-danger rounded-pill fs-6 opacity-75">Remove</button>
                                            @endif
                                    </div>
                                </div>
                            </li>
                    </ul>

                      {{-- Update Completion --}}
                      <div class="modal fade" id="update1{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Update <b>{{$project->name}}</b>?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {!!Form::open(['action' => ['\App\Http\Controllers\ProjectController@update',$project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select id="status" name = "status" class="form-select" onchange="check(this)">
                                            <option value="0" selected >Ongoing</option>
                                            <option value="1">Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" id="end_date" name = "end_date" class="form-control">
                                    </div>          
                                </div>
                                
                                
                            </div>
                            <div class="modal-footer">
                                {{Form::hidden('_method','PUT')}}
                                {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                            </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                    {{-- Delete Project --}}
                    <div class="modal fade" id="delete1{{$project->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center" id="exampleModalLabel">Delete <b>{{$project->name}}</b>?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <b>{{$project->name}}</b> from project record? This action is reversible.
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('project.destroy', ['id' => $project->id]) }}" class="btn btn-danger" data-bs-dismiss="modal"><b>Delete</b></a>
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

    </div>    

    @if(Session::get('role') === '1')
    <a class="btn btn-primary add-project rounded-pill px-4 shadow-lg" href ="/project/create">
        <i class="fa-solid fa-plus"></i>
        <span class="fw-bold">New Project</span>
    </a>
    @endif
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