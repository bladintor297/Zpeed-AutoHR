@extends('layouts.app')

@section('content')
<p class="text-center fs-6 mt-2 fs-1 fw-bold">Add New Project<br></p>
<div class="container overflow-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body scroll">
                        <div class ="text-center mb-4">
                            <strong>Please key in all the project details. </strong><br>
                        </div>
                        {!! Form::open(['class' => "row g-3",'action' => '\App\Http\Controllers\ProjectController@store', 'method'=>'POST','enctype' => 'multipart/form-data']) !!}
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Project Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Enter project name"required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Project Description') }}</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control" maxlength="70" rows="2" name="description" placeholder="Enter project description"required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end" >{{ __('Status') }}</label>
                            <div id="type" class="col-md-6">
                                <select id="status" name = "status" class="form-select" onchange="check(this)">
                                    <option value="0" selected >Ongoing</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>
                            <div class="col-md-6">
                                <input id="start_date" type="date" class="form-control" name="start_date" required>
                            </div>
                        </div>
                        <div class="row mb-3" id="show" style="display: none;">
                            <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>
                            
                            <div class="col-md-6">
                                <input id="end_date" type="date" class="form-control" name="end_date">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary fw-bold">Add Project</button>
                            </div>
                        </div>
                        {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
</div>



<script>
function check(that) {
    if (that.value == "1") {
        document.getElementById("show").style.display = "flex";
    } 
    else 
        document.getElementById("show").style.display = "none";
}
</script>
@endsection
