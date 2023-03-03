@extends('layouts.list')
@section('content') 
<div class="container w-75">
    <p class="text-center fs-6 mt-3 fs-1 fw-bold">Staff List<br></p>
    <div class="d-flex flex-row justify-content-center">
      <ul class="nav nav-pills mb-3 justify-content-center mt-3" id="pills-tab" role="tablist">
	<li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-one-tab" data-bs-toggle="pill" data-bs-target="#pills-one" type="button" role="tab" aria-controls="pills-one" aria-selected="true">Active</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-two-tab" data-bs-toggle="pill" data-bs-target="#pills-two" type="button" role="tab" aria-controls="pills-two" aria-selected="false">Resigned</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link fs-4 fw-bold rounded-pill" id="pills-three-tab" data-bs-toggle="pill" data-bs-target="#pills-three" type="button" role="tab" aria-controls="pills-three" aria-selected="false">All</button>
        </li>
      </ul>
   </div>
      <div class="tab-content" id="pills-tabContent">

        {{-- Active List --}}
        <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
            <div class="active-list">
                @if(count($active) > 0)
                @foreach($active as $staff)
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <img src="
                                    @if ($staff->picture === $defaultImage)
                                        {{$staff->picture}}
                                    @else
                                        {{url('storage/upload/profile/'.$staff->picture)}}
                                    @endif
                                    "
                                    class="card-img-top" style="max-width:50px;"alt="...">
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$staff->name}} ({{$staff->staff_id}})</span></div>
                                        <div class="text-muted fs-6">{{$staff->email}} | {{$staff->phone}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-warning rounded-pill fs-6 px-4"><a href="staff/{{$staff->staff_id}}/edit" class="text-decoration-none text-dark ">Edit</a></button>
                                            <button  data-bs-target="#myModal{{$staff->staff_id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill fs-6">Terminate</button>
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
                                <h5 class="modal-title text-center" id="exampleModalLabel">Terminate <b>{{$staff->name}}</b>?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {!!Form::open(['action' => ['\App\Http\Controllers\StaffController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="resign_date" class="form-label">Resign Date:</label>
                                        <input type="date" class="form-control" name="resign_date" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="resign_remark" class="form-label">Remark</label>
                                        <input type="text" class="form-control" name="payment_ref" placeholder="Enter remarks" required>
                                    </div>       
                                    <input type="hidden" class="form-control" value="{{$staff->staff_id}}" name="staff_id">
                                </div>
                                
                                
                            </div>
                            <div class="modal-footer">
                                {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                            </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @endforeach
                <br>
                {{ $active->links() }}
                
                @else
                <div class="col w-100 mt-5">
                    <p class="text-center">No record found</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Resigned List --}}
        <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab">
            <div class="resigned-list">
                @if(count($resign) > 0)
                @foreach($resign as $staff)
                    <ul class="list-group list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="d-flex justify-content-start">
                                    <img src="
                                    @if ($staff->picture === $defaultImage)
                                        {{$staff->picture}}
                                    @else
                                        {{url('storage/upload/profile/'.$staff->picture)}}
                                    @endif
                                    "
                                    class="card-img-top" style="max-width:50px;"alt="...">
                                    <div class="ms-2 me-auto">
                                        <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$staff->name}} ({{$staff->staff_id}})</span></div>
                                        <div class="text-muted fs-6">{{$staff->email}} | {{$staff->phone}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <div class="ms-2 me-auto">
                                        <div>
                                            <button class="badge bg-warning rounded-pill fs-6 px-4 opacity-75" disabled><a class="text-decoration-none text-dark ">Edit</a></button>
                                            <button class="badge bg-danger rounded-pill fs-6 opacity-75" disabled>Terminate</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                    </ul>

                @endforeach
		{{ $active->links() }}

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
                <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                    <div class="active-list">
                        @if(count($all) > 0)
                        @foreach($all as $staff)
                            <ul class="list-group list-group mt-2">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="d-flex justify-content-start">
                                            <img src="
                                            @if ($staff->picture === $defaultImage)
                                                {{$staff->picture}}
                                            @else
                                                {{url('storage/upload/profile/'.$staff->picture)}}
                                            @endif
                                            "
                                            class="card-img-top" style="max-width:50px;"alt="...">
                                            <div class="ms-2 me-auto">
                                                <div class="fs-5"><span class="fw-bold">Name: </span><span>{{$staff->name}} ({{$staff->staff_id}})</span></div>
                                                <div class="text-muted fs-6">{{$staff->email}} | {{$staff->phone}}</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <div class="ms-2 me-auto">
                                                <div>
                                                    @if ($staff->approve === '2')
                                                        <button class="badge bg-warning rounded-pill fs-6 px-4 opacity-75" disabled><a class="text-decoration-none text-dark ">Edit</a></button>
                                                        <button class="badge bg-danger rounded-pill fs-6 opacity-75" disabled>Terminate</button>

                                                    @else
                                                        <button class="badge bg-warning rounded-pill fs-6 px-4"><a href="staff/{{$staff->staff_id}}/edit" class="text-decoration-none text-dark ">Edit</a></button>
                                                        <button  data-bs-target="#terminate{{$staff->staff_id}}" data-bs-toggle="modal" class="badge bg-danger rounded-pill fs-6">Terminate</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                            </ul>
        
                            {{-- Resgin Modal --}}
                            <div class="modal fade" id="terminate{{$staff->staff_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center" id="exampleModalLabel">Terminate <b>{{$staff->name}}</b>?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {!!Form::open(['action' => ['\App\Http\Controllers\StaffController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="resign_date" class="form-label">Resign Date:</label>
                                                <input type="date" class="form-control" name="resign_date" required>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="resign_remark" class="form-label">Remark</label>
                                                <input type="text" class="form-control" name="payment_ref" placeholder="Enter remarks" required>
                                            </div>       
                                            <input type="hidden" class="form-control" value="{{$staff->staff_id}}" name="staff_id">
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="modal-footer">
                                        {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                                    </div>
                                    {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach <br>
			{{ $active->links() }}
 
                        @else
                        <div class="col w-100 mt-5">
                            <p class="text-center">No record found</p>
                        </div>
                        @endif
                    </div>
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
