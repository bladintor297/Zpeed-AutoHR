<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Zpeed Auto-HR</title>
    {{-- <title>{{ config('app.name', 'Zpeed Auto-HR') }}</title> --}}
    
    {{-- Fav Icon --}}
    <link rel="shortcut icon" href="{{ asset('storage/images/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/images/apple-touch-icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600&display=swap" rel="stylesheet">

    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    
    <!-- Scripts -->
    
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
	@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@500;600;900&display=swap');
	*{
            font-family: 'Nunito Sans', sans-serif;
        }

      /*
       * Base structure
       */

      body {
        box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .cover-container {
        max-width: 42em;
        text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
      }

      .about {
        text-shadow: 0 .05rem .1rem rgba(0, 0, 0, 0.395);
      }


      .about h1{
        font-weight:900;
        text-transform: uppercase;
      }

      .btn-login {
        border-radius: 4px;
        background-color: #ffc107;
        text-decoration: none;
        border: none;
        color: #1e1e1e;
        text-align: center;
        font-weight: 600;
        font-size: 1.2rem;
        padding: 1.2rem 1.5rem 1.2rem 1.5rem ;
        transition: all 0.5s;
        cursor: pointer;
        box-shadow: 0 10px 20px -8px rgba(0, 0, 0,.7);
      }

      .btn-login{
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
      }

      .btn-login:after {
        content: '»';
        position: absolute;
        font-size: 2rem;
        opacity: 0;  
        bottom: 0rem;
        right: 2.5rem;
        transition: 0.5s;
      }

      .btn-login:hover{
        padding-right: 8px;
        padding-left:8px;
        background-color: #313131;
        border: #f5f5f5 1px;
        color: #ffc107
      }

      .btn-login:hover:after {
        opacity: 1;
        right: 30px;
      }

    .form-signin {
      max-width: 330px;
      padding: 15px;
    }

    .form-signin .form-floating:focus-within {
      z-index: 2;
    }

    .form-signin input[type="email"] {
      margin-bottom: -1px;
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
      margin-bottom: 10px;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

        
    </style>
    
</head>

<body class="text-center" style="height: 100vh">
  <div class="d-grid mx-auto container-fluid ">
    @include('inc.navbar-outside')
    @include('inc.messages')
    @yield('content')
  </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCBS2nQrqFiKeQR0i3p9cxBu6rMqbeBGdI&libraries=places" ></script>
</body>
</html>
