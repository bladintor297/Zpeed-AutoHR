@extends('layouts.welcome')
@section('content')
@guest
    <div class="container col-xxl-8 px-3 py-3 my-5 text-bg-white rounded shadow-lg about">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-3">
          <div class="col-10 col-sm-8 col-lg-6 mx-auto">
            <img src="https://meek.media/wp-content/uploads/2022/06/professional-seo-service.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
          </div>
          <div class="col-lg-6 ps-5">
            <h1 class="display-5 fw-bold lh-1 my-3 text-warning">Zpeed Auto HR</h1>
            <p class="lead mx-2 text-center" align="justify">
              Zpeed Auto-HR System is an internal Human Resource Management System (HRMS) that 
              is designated for the staffs to perform HR-related tasks in Zpeed Solutions Sdn. Bhd.
            </p>
            <div class="d-grid gap-2 mt-4 col-6 mx-auto">
                <p class="lead">
                    <a href="{{ route('login') }}" class=" border-white py-2 px-5 btn-login rounded-pill">Login Now </a>
                </p>
            </div>
            
          </div>
        </div>
      </div>
    {{-- <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
        </header>

        <main class="px-3">
        <h1>Zpeed Auto-HR.</h1>
        <p class="lead">
          Zpeed Auto-HR System is an Human Resource Management System (HRMS) that is designated for the staffs to perform HR-related tasks in Zpeed Solutions Sdn. Bhd.
        </p>
        
        </main>

        <footer class="mt-auto text-white-50">
        
        </footer>
    </div> --}}

@else
    @include('home')
@endguest

@endsection
