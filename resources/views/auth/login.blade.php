@extends('layouts.welcome')

@section('content')

    <main class="form-signin w-100 m-auto text-bg-dark p-5 rounded ">
        
        <form  method="POST" action="{{ route('login') }}">
        @csrf
          <img class="mb-4" src="{{asset('storage/images/zpeed-logo-white.png')}}" alt="zpeed-logo" width="200">
          <h3 class="h4 mb-3 fw-normal text-warning">Please sign in</h3>
      
          <div class="form-floating text-dark">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
            <label for="floatingInput ">Email address</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-floating text-dark">
            <input type="password" class="form-control" id="floatingPassword" name="password"  placeholder="Password">
            <label for="floatingPassword">Password</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
      
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
            </label>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
          </div>
          <button class="w-100 btn btn-lg btn-warning" type="submit">Sign in</button>
        </form>
      </main>

  
@endsection
