@extends('layouts.app')

@section('content')
<p class="text-center fs-6 mt-2 fs-1 fw-bold">Apply New Leave<br></p>
<div class="container overflow-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Register') }}</div> --}}

                <div class="card-body scroll">
                  {!! Form::open(['class' => "row g-3",'action' => '\App\Http\Controllers\LeaveController@store', 'method'=>'POST','enctype' => 'multipart/form-data']) !!}
                        @csrf

                        <div class ="text-center mb-1">
                            <strong>Instruction: Please read carefully. </strong><br>
                            <p class ="text-muted">Below is your leave entitlement for each type of leave. To apply for annual leave, total days of your leave determines 
                               the days prior for you to apply Further details can be <button type="button" class="bg-white border-0 text-primary" data-bs-toggle="modal" 
                               data-bs-target="#exampleModal">read here.</button> For medical leave, you must fill up the form latest by 
                               <strong>one day</strong> after your medical leave date. For emergency leave, you  need to apply latest by  the day of the leave.<br>
                              
                            </p>
                        </div>
                        <div class="container text-center mb-3">
                            <div class="row align-items-start ">
                              <div class="col">
                                <div class="card">
                                    <div class ="card-header bg-success"><span class = "text-white fs-6"><strong>Annual Leave</strong></span></div>
                                    <div class="card-body">
                                      <div class="d-flex justify-content-between px-md-1">
                                        <div>
                                          <h3 class="text-dark text-start fs-5"><sup></sup> <sup>Balance </sup><span class = "badge bg-success text-white fs-4 fwb-bold">{{$staff->bal_al}}<sub> days </sub></span></h3>
                                          <p class="mb-0  text-start"><span class = "badge bg-secondary">Entitlement: {{$staff->ent_al}} days</span></p>
                                        </div>
                                        <div class="align-self-center">
                                          <i class="fa-solid fa-calendar-day text-dark fa-3x"></i>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col">
                                <div class="card">
                                    <div class ="card-header bg-warning"><span class = "text-dark fs-6"><strong>Medical Leave</strong></span></div>
                                    <div class="card-body">
                                      <div class="d-flex justify-content-between px-md-1">
                                        <div>
                                          <h3 class="text-dark text-start fs-5"><sup>Balance </sup><span class = "badge bg-warning text-dark fs-4 fwb-bold">{{$staff->bal_ml}}<sub> days </sub></span></h3>
                                          <p class="mb-0  text-start"><span class = "badge bg-secondary">Entitlement: {{$staff->ent_ml}} days</span></p>
                                        </div>
                                        <div class="align-self-center">
                                          <i class="fa-solid fa-file-medical text-dark fa-3x"></i>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col">
                                <div class="card">
                                    <div class ="card-header bg-danger"><span class = "text-white fs-6"><strong>Emergency Leave</strong></span></div>
                                    <div class="card-body">
                                      <div class="d-flex justify-content-between px-md-2">
                                        <div class="align-self-center">
                                            <i class="fa-solid fa-person-walking-luggage text-dark fa-3x"></i>
                                          </div>
                                        <div>
                                          <h3 class="text-dark text-start"><sup>Total </sup><span class = "badge bg-danger"> {{$staff->ent_el}} <sub> days</sub></span></h3>
                                          <p class="mb-0  text-start"><span class = "badge bg-secondary">Entitlement: {{$staff->ent_al}} days</span></p>
                                        </div>
                                        
                                      </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                           
                          </div>

                        <div class="row mb-3">
                            
                            <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Leave Type') }}</label>

                            <div class="col-md-6">
                                <select id="type" name = "type" class="form-select" onchange="check(this)" required>
                                    <option value="" selected >Choose...</option>
                                    <option value="AL" >Annual Leave</option>
                                    <option value="ML">Medical Leave</option>
                                    <option value="EL">Emergency Leave</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="startDate" id="startDate" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>
                            
                            <div class="col-md-6">
                                <input id="startDateId" max="{{date("Y")}}-12-31" type="date" class="form-control"  name="startDate" onchange = "checkDate(this)" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="endDate" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>
                            
                            <div class="col-md-6">
                                <input id="endDate" min="" type="date" class="form-control" name="endDate" max="{{date("Y")}}-12-31" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="reason" class="col-md-4 col-form-label text-md-end">{{ __('Reason') }}</label>
                            
                            <div class="col-md-6">
                                <input id="reason" type="text" class="form-control" name="reason" placeholder="Specify your leave reason" required>
                            </div>
                        </div>
                        <div class="row mb-3" id="show"  style="display:none;">
                          <label for="mc" class="col-md-4 col-form-label text-md-end">{{ __('Medical Certificate') }}</label>
                          
                          <div class="col-md-6">
                              <input id="mc" type="file" class="form-control" name="mc" accept=".pdf, .jpeg, .jpg, .png">
                          </div>
                      </div>

                      

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                  {{Form::submit('SUBMIT', ['class'=>'btn btn-primary fw-bold'])}}
                            </div>
                        </div>
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Annual Leave</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- <h4><br></h4> --}}
          - 1 day leave: 3 days prior to leave <br>
          - 2 to 3 days leave: 1 week prior <br>
          - 4 to 5 days leave: 1 month prior <br>
          - More than 5 days leave: 2 months prior <br>
          {{-- (1) Annual Leave <br>
          - Less than 3 years of service: 14 days <br>
          - 3 to 5 years of service: 16 days <br>
          - More than 5 years of service: 16 days<br>
          - Leave are carry forward, up to <strong>5 days</strong> only. Each carry forward day is <br>
            &nbsp;&nbsp; convertible to RM XX.XX, depends on your daily basic salary prorate.<br>
          -  --}}

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script>
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth() + 1; //January is 0!
      var yyyy = today.getFullYear();

      if (dd < 10) {
        dd = '0' + dd;
      }

      if (mm < 10) {
        mm = '0' + mm;
      } 
          
      today = yyyy + '-' + mm + '-' + dd;
      document.getElementById("startDateId").setAttribute("min", today);
  </script>
  <script>
      function checkDate(that) {
        endDate.min = document.getElementById("startDateId").value;
    }
    function check(that) {
      var time = new Date();
      var localTimeStr = time.toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' });
      today = new Date(localTimeStr);
      if (that.value == "ML") {
        document.getElementById("show").style.display = "flex";
        startDateId.min = '';
      } 
      else {
        // To Set Min date
        if (that.value == "AL") {
          startDateId.min = new Date(today.setDate(today.getDate() + 2)).toISOString().split('T')[0];
        }
      
        else if (that.value == "EL") {
          startDateId.min = today.toISOString().split('T')[0];
        }
        document.getElementById("show").style.display = "none";
      }
    }

  </script>
@endsection
