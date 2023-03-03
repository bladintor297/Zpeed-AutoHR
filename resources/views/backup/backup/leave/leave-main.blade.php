@extends('layouts.app')

@section('content')
<p class="text-center fs-6 mt-2 fs-1 fw-bold">Leave<br></p>

@if((Session::get('role') === '1') || (Session::get('role') === '2'))
  <div class="row mt-1 row-cols-1 row-cols-md-2 g-4 text-center">
    <div class="col">
      <a href='leave-list' class="text-decoration-none opt">
        <div class="card mb-3 opt-card">
            <div class="card-body mt-2">
                <h5 class="card-title"><i class="fa-solid fa-list-check opt-icon"></i></h5>
                <p class="card-text">View Leave List</p>
            </div>
          </div>
      </a>
    </div>
    <div class="col">
      <a href='/lvreport-list' class="text-decoration-none opt">
        <div class="card mb-3 opt-card">
            <div class="card-body mt-2">
                <h5 class="card-title"><i class="fa-solid fa-file-contract opt-icon"></i></h5>
                <p class="card-text">Leave Report</p>
            </div>
          </div>
      </a>
    </div>
  </div>
@endif


    <div class="row mt-1 row-cols-1 row-cols-md-2 g-4 text-center">
        <div class="col">
          <a href='leave/create' class="text-decoration-none opt">
            <div class="card mb-3 opt-card">
                <div class="card-body mt-2">
                    <h5 class="card-title"><i class="fa-solid fa-calendar-day opt-icon"></i></i></h5>
                    <p class="card-text">Apply a New Leave</p>
                </div>
              </div>
          </a>
        </div>
        <div class="col">
          <a href='/leave-status' class="text-decoration-none opt">
            <div class="card mb-3 opt-card">
                <div class="card-body mt-2">
                    <h5 class="card-title"><i class="fa-solid fa-circle-check opt-icon"></i></h5>
                    <p class="card-text">View Leave Application Status</p>
                </div>
              </div>
          </a>
        </div>
      </div>

      @if (count($leave_record)===0)
      <button class="btn btn-primary floating-btn rounded-pill px-4 me-4 shadow-lg " data-bs-target="#approveModal{{$staff->id}}" data-bs-toggle="modal" id="updBtn" role="button" style="display: none;">
          <span class="fw-bold"><i class="fa-solid fa-bars"></i> &nbsp;Renew Leave</span>
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">New alerts</span>
          </span>
      </button>

      @else
      <button disabled class="btn btn-primary floating-btn rounded-pill px-4 me-4 shadow-lg opacity-75" id="updBtn" role="button" style="display: none;">
        <span class="fw-bold"><i class="fa-solid fa-bars"></i> &nbsp;Renew Leave</span>
      </button>
      @endif
    
      
      <!-- Update Leave Modal -->
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
                          {!! Form::open(['action' => ['\App\Http\Controllers\LeaveController@update', $staff->staff_id], 'method'=>'POST']) !!}
                          <div class="d-flex justify-content-evenly mb-3">
                              <div class="badge bg-success">Balance AL: <i>{{$staff->bal_al}} days</i></div>
                              <div class="badge bg-warning text-dark">Balance ML: <i>{{$staff->bal_ml}} days</i></div>
                              <div class="badge bg-danger">Total EL: <i>{{$staff->ent_el}} days</i></div>
                          </div>

                          <div class="row g-3 mt-0">
                              <div class="form-group col-md-12 mt-3" >
                                  <label for="type">{{ __('Mode of Leave Renewal') }}</label>
                                  <select id="type" name = "type" class="form-select">
                                      <option selected disabled>Choose...</option>
                                      <option value="1">Carry forward</option>
                                      <option value="2">Cash back</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  
              </div>
      
              <div class="modal-footer">
                  {{Form::hidden('_method','PUT')}}

                  {{Form::submit('Update', ['class'=>'btn btn-primary fw-bold'])}}
                  {!! Form::close() !!}
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
              </div>
          </div>
      
      </div>

    <script>
      $(function() {
      function TimePeriod() {
        var now = new Date();
        if ((now.getMonth() + 1) == 12) {
          $("#updBtn").show();
        } else {
          $("#updBtn").hide();
        }
      }

      TimePeriod();
    });
    </script>
@endsection


