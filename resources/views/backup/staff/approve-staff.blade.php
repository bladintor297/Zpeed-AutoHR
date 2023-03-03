@extends('layouts.app')
@section('content') 


    <h2 style="text-align: center">Staff List</h2>
    <div class="card scroll bg-transparent border-white">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search a staff..." aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-primary" type="button" id="button-addon2"><i class="fa-solid fa-search"></i> Search</button>
            <button class="btn btn-secondary" type="button" id="button-addon2"><i class="fa-solid fa-filter"></i></button>
          </div>
  
        
         <?php $index = 1;?> 
         
         @if(count($staffs) > 0)
            @foreach($staffs as $staff)
                <ol class="list-group list-group mb-3 ">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold" style="text-transform:uppercase">
                            <a class='staffName' href='#'><h5 class=" mt-2"><strong>{{$index}}. {{$staff->name}}</strong></h5></a></div> 
                            <span class="text-muted"><h6>{{$staff->email}}</h6></span>   
                    </div>
                    <span>
                        <button type="button" data-bs-target="#approveModal{{$staff->id}}" data-bs-toggle="modal"  class="btn btn-success rounded-pill"><b>Approve</b></button>
                        {{-- <a class="btn btn-primary rounded-pill" href='{{route('staff.approve', $staff->id)}}'><b>  Approve </b></a> --}}
                        <button type="button" data-bs-target="#rejectModal{{$staff->id}}" data-bs-toggle="modal"  class="btn btn-danger rounded-pill"><b>Reject</b></button>
                    </span>
                    </li>
                </ol>
                <?php ++$index ?>

                 <!-- Approve Modal -->
                 <div class="modal fade" id="approveModal{{$staff->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Approval?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header text-center fw-bold">{{ $staff->name}}</div>
                
                                <div class="card-body">
                                    {!! Form::open(['action' => ['\App\Http\Controllers\StaffController@show', $staff->id], 'method'=>'GET']) !!}
                                        
                
                                    <div class="row g-3">
                                        <div class="form-group col-md-5" >
                                            <label for="startdate">{{ __('Start Date') }}</label>
                                            <input id="startdate" type="date" class="form-control" value="{{$staff->startDate}}"name="startdate" required>
                                        </div>
                                        <div class="form-group col-md-7" >
                                            <label for="role">{{ __('Role') }}</label>
                                            <select id="role" class="form-select" name="role" required>
                                                <option selected disabled>Choose a role...</option>
                                                <option value ='3' >Regular Staff</option>
                                                <option value ='2'>Supervisor</option>
                                                <option value ='1'>Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-0">
                                        <div class="form-group col-md-5 mt-3" >
                                            <label for="status">{{ __('Employment Status') }}</label>
                                            <select id="status" class="form-select" name="status" required>
                                                <option selected disabled>Choose a status...</option>
                                                <option value ='0'>On Probation</option>
                                                <option value ='1'>Permanent Staff</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-7 mt-3" >
                                            <label for="designation">{{ __('Designation') }}</label>
                                            <input id="designation" type="text" class="form-control" placeholder="Enter staff's designation" name="designation" required>
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-0 mb-3">
                                        <div class="form-group col-md-6 mt-3" >
                                            @if ($staff->role === '3')
                                            <label for="supervisor">{{ __('Supervisor') }}</label>
                                            <select id="supervisor" class="form-select" name="supervisor"  required>
                                                <option selected disabled>Choose a supervisor...</option>
                                                {{-- Loop staff where role === 2 --}}
                                                @foreach ($sv as $svs)
                                                <option value ='{{$svs->name}}'>{{$svs->name}}</option>
                                                @endforeach
                                            </select>

                                            @else
                                            <label for="supervisor">{{ __('Supervisor') }}</label>
                                            <select id="supervisor" class="form-select" name="supervisor"  disabled>
                                                <option selected disabled>Not Applicable...</option>
                                            </select>

                                            @endif
                                        </div>
                                        <div class="form-group col-md-6 mt-3" >
                                            <label for="epf">{{ __('EPF Number') }}</label>
                                            <input id="epf" type="text" class="form-control" placeholder="Enter staff's EPF number" name="epf" required>
                                        </div>
                                    </div>
                                       
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            {{-- {{Form::hidden('_method','PUT')}} --}}
                            {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                            {!! Form::close() !!}
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal{{$staff->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Rejection?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            You are about to delete <b> {{$staff->name}}</b> from the staff record. This action is irreversible.
                            
                        </div>
                        <div class="modal-footer">
                        
                            <a href='#' class="btn btn-danger">Delete</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>
            @endforeach

            
        

        @else
            <ol class="list-group list-group mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <p>No Staff Found</p>
                </li>
            </ol>
            @endif
      </div>

@endsection