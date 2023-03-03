@extends('layouts.app')
@section('content')
@guest
    <div class="container shadow-lg p-3 mb-5 rounded mh-75 mt-5 bg-dark">
        <div class="row h-100 align-items-center ">
            {{-- <div class="position-relative">
                <img class="position-absolute top-0 start-0" src=' {{asset('storage/images/zpeed-logo-white.png')}}'  width="150rem" />
            </div> --}}
            <div class="col text-center ms-5 ">
                
                <p class="display-6 fw-bolder text-warning mb-0"> Welcome to</p>
                <p class="display-4 fw-bolder text-warning mb-0"> ZPEED AUTO-HR SYSTEM</p>
                <p class="text-start ms-3 fs-4 text-light mb-4"> This is your all-in-one bot to assist you to manage your
                    <span class="badge bg-warning text-dark rounded-pill fs-4 ">profile</span> , 
                    <span class="badge bg-primary text-dark rounded-pill fs-4 ">leave</span> ,
                    <span class="badge bg-success text-dark rounded-pill fs-4 ">claim</span> , &
                    <span class="badge bg-danger text-dark rounded-pill fs-4 ">projects</span> . Explore now !
                </p>
                <hr class="bg-danger border-3 border-top col-5 mx-auto border-warning ">
                
                <div class="d-flex gap-2 justify-content-center">
                    <a class="btn btn-warning px-5 fw-bolder" href="{{ route('login') }}">Login Now</a>
                </div>
                
            </div>
            <div class="col-sm-5">
                <img src="{{ URL::asset('storage/images/robot.png'); }}" alt ="x"style="width: 100%; " />
            </div>
            
            
        </div>
        {{--  --}}
    </div>
@else
    @include('home')
@endguest

@endsection
