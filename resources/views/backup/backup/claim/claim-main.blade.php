@extends('layouts.app')

@section('content')
<p class="text-center fs-6 mt-2 fs-1 fw-bold">Claim<br></p>

@if((Session::get('role')) === '1')
  <div class="row mt-1 row-cols-1 row-cols-md-2 g-4 text-center">
    <div class="col">
      <a href='/claim-list' class="text-decoration-none opt">
        <div class="card mb-3 opt-card">
            <div class="card-body mt-2">
                <h5 class="card-title"><i class="fa-solid fa-list-check opt-icon"></i></h5>
                <p class="card-text">Claim List</p>
            </div>
          </div>
      </a>
    </div>
    <div class="col">
      <a href='/payment' class="text-decoration-none opt">
        <div class="card mb-3 opt-card">
            <div class="card-body mt-2">
                <h5 class="card-title"><i class="fa-solid fa-sack-dollar opt-icon"></i></h5>
                <p class="card-text">Payment List</p>
            </div>
          </div>
      </a>
    </div>
  </div>
@endif



    <div class="row mt-1 row-cols-1 row-cols-md-2 g-4 text-center">
        <div class="col">
          <a href='claim/create' class="text-decoration-none opt">
            <div class="card mb-3 opt-card">
                <div class="card-body mt-2">
                    <h5 class="card-title"><i class="fa-solid fa-hand-holding-dollar opt-icon"></i></h5>
                    <p class="card-text">Apply a New Claim</p>
                </div>
              </div>
          </a>
        </div>
        <div class="col">
          <a href='claim-status' class="text-decoration-none opt">
            <div class="card mb-3 opt-card">
                <div class="card-body mt-2">
                    <h5 class="card-title"><i class="fa-solid fa-circle-check opt-icon"></i></h5>
                    <p class="card-text">View Claim Status</p>
                </div>
              </div>
          </a>
        </div>
      </div>

    

@endsection


