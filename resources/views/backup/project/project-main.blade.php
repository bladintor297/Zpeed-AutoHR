@extends('layouts.app')

@section('content')
<p class="text-center fs-6 mt-2 fs-1 fw-bold">Projects<br></p>


  <div class="row mt-1 row-cols-1 row-cols-md-2 g-4 text-center">
    <div class="col">
      <a href='project-list' class="text-decoration-none opt">
        <div class="card mb-3 opt-card">
            <div class="card-body mt-2">
                <h5 class="card-title"><i class="fa-solid fa-folder-tree opt-icon"></i></h5>
                <p class="card-text">Manage Projects</p>
            </div>
          </div>
      </a>
    </div>
    <div class="col">
      <a href='pjreport-list' class="text-decoration-none opt">
        <div class="card mb-3 opt-card">
            <div class="card-body mt-2">
                <h5 class="card-title"><i class="fa-solid fa-file-contract opt-icon"></i></h5>
                <p class="card-text">View Report</p>
            </div>
          </div>
      </a>
    </div>
  </div>


    

@endsection


