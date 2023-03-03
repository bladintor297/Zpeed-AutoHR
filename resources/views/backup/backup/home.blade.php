@extends('layouts.app')

@section('content')
<?php use App\Http\Controllers\HomeController;?>
<p class="text-center fs-6 mt-2 fs-1 fw-bold">My Dashboard<br></p>
    {{-- @if(HomeController::getApproveStatus()) --}}

    @if((Session::get('role')) == '1')
    <div class="container-fluid">
        <div class="row">
          <div class="col-3 mt-5 pt-1">
              <div class="card overflow-auto" style="height: 15rem; " >
                <div class="card-body">
                  <p class="text-center fs-5 fw-bold">Who's On Leave<br></p>
                  <ul class="list-group list-group-numbered bg-body">
 		   @foreach ($absentslist as $absent)
                   <li class="list-group-item">{{$absent}}</li>  
                   @endforeach
                  </ul>
                </div>
              </div>
          </div>
          <div class="col-9">
            <section>
              <p class="text-start fs-5 mt-2 fw-bold">Claims Summary<br></p>
                <div class="row">
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="fas fa-pencil-alt text-info fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3 class="text-info">{{count($pendingclaims)}} claims</h3>
                            <p class="mb-0">Pending Approval</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="far fa-comment-alt text-warning fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3 class="text-warning">RM {{$pendingpay}}</h3>
                            <p class="mb-0">Pending Payment</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="fas fa-map-marker-alt text-danger fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3 class="text-danger">RM {{$paid}}</h3>
                            <p class="mb-0">Total Payment</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                <p class="text-start fs-5 mt-2 fw-bold">Leaves Summary<br></p>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-danger">{{count($pendingleaves)}} leaves</h3>
                            <p class="mb-0">Pending Approval</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-rocket text-danger fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-success">{{count($absentslist)}} staffs</h3>
                            <p class="mb-0">On Leave Today</p>
                          </div>
                          <div class="align-self-center">
                            <i class="far fa-user text-success fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-warning">{{$abesence_rate}} %</h3>
                            <p class="mb-0">Attendance Rate</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-chart-pie text-warning fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row row mt-2">
                <p class="text-start fs-5 mt-2 fw-bold">Projects Summary<br></p>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-info">{{count($activeprojects)}} Projects</h3>
                            <p class="mb-0">Currently ongoing</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-book-open text-info fa-3x"></i>
                          </div>
                        </div>
      
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-warning">{{count($completeprojects)}} projects</h3>
                            <p class="mb-0">Have been completed</p>
                          </div>
                          <div class="align-self-center">
                            <i class="far fa-comments text-warning fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-danger">{{count($projects)}} Projects</h3>
                            <p class="mb-0">Total Projects</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-map-signs text-danger fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
          </div>
        </div>
      </div>

      @else
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <section>
              <p class="text-start fs-5 mt-2 fw-bold">My Claims<br></p>
                <div class="row">
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="fas fa-pencil-alt text-info fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3 class="text-info">{{count($mypendingclaims)}} claims</h3>
                            <p class="mb-0">Pending Approval</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="far fa-comment-alt text-warning fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3 class="text-warning">RM {{$mypendingpay}}</h3>
                            <p class="mb-0">Pending Payment</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
            
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div class="align-self-center">
                            <i class="fas fa-map-marker-alt text-danger fa-3x"></i>
                          </div>
                          <div class="text-end">
                            <h3 class="text-danger">RM {{$mypaid}}</h3>
                            <p class="mb-0">Total Paid Claims</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                <p class="text-start fs-5 mt-2 fw-bold">My Leaves<br></p>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-danger">{{count($pendingleaves)}} leaves</h3>
                            <p class="mb-0">Pending Approval</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-rocket text-danger fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-success">{{count($absentslist)}} staffs</h3>
                            <p class="mb-0">On Leave Today</p>
                          </div>
                          <div class="align-self-center">
                            <i class="far fa-user text-success fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-warning">{{$abesence_rate}} %</h3>
                            <p class="mb-0">Attendance Rate</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-chart-pie text-warning fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row row mt-2">
                <p class="text-start fs-5 mt-2 fw-bold">Projects Summary<br></p>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-info">{{count($activeprojects)}} Projects</h3>
                            <p class="mb-0">Currently ongoing</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-book-open text-info fa-3x"></i>
                          </div>
                        </div>
      
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-warning">{{count($completeprojects)}} projects</h3>
                            <p class="mb-0">Have been completed</p>
                          </div>
                          <div class="align-self-center">
                            <i class="far fa-comments text-warning fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-4 col-sm-6 col-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                          <div>
                            <h3 class="text-danger">{{count($projects)}} Projects</h3>
                            <p class="mb-0">Total Projects</p>
                          </div>
                          <div class="align-self-center">
                            <i class="fas fa-map-signs text-danger fa-3x"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
          </div>
        </div>
      </div>
      @endif
    {{-- @else
         
            echo "<script>";
            echo "alert('Your registration has been received. Please wait for email approval confirmation');";
            echo "</script>";
        
        {{ HomeController::notValidate(); }}

    @endif --}}
@endsection
