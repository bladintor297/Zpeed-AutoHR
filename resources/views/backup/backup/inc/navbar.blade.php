<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">
  
    <div class="container-fluid">
      @guest
        @if (Route::has('login'))
        <a class="navbar-brand" href="/#"><img src=' {{asset('storage/images/zpeed-logo-white.png')}}'  width="150rem" /></a>
        @endif
      @endguest
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @guest
          @if (Route::has('login'))
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
          </ul>
          @endif
  
          @else
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 mh-100">
            <a class="navbar-brand" href="{{ url('/home') }}"><img src=' {{asset('storage/images/zpeed-logo-white.png')}}'  width="150rem" /></a>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/home">Home</a>
            </li>
            @if((Session::get('role')) === '1')
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/project">Projects</a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/leave">Leaves</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/claim">Claim</a>
            </li>
            @if((Session::get('role')) === '1')
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/staff">Staff</a>
            </li>
            @endif
          </ul>
       
        
        @endguest
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ms-auto me-1">
          <!-- Authentication Links -->
          @guest
              @if (Route::has('login'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @endif
 <!--
              @if (Route::has('register'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
              @endif  -->
          @else

              <li class="nav-item">
                <a class="nav-link btn btn-primary text-white fw-bold" aria-current="page" href="/profile"><span class="px-2">My Profile</span></a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link fw-bold btn btn-warning text-dark" aria-current="page" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"><span class="px-2">Logout</span></a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                </a>
              </li>

          @endguest
      </ul>
        {{-- <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form> --}}
      </div>
    </div>
  </nav>
  
  
