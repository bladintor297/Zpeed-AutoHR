<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Zpeed Auto-HR</title>
    {{-- <title>{{ config('app.name', 'Zpeed Auto-HR') }}</title> --}}
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- Scripts -->
    
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
	@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600&display=swap');

	*{
	    font-family: 'Nunito Sans', sans-serif;
	}
        .add-project {
            /* display: none; */
            position: fixed;
            bottom: 40px;
            right: 50px;
            z-index: 99;
            font-size: 18px;
            cursor: pointer;
            padding: 10px;
        }
    </style>
    
</head>

<body>
    @include('inc.navbar')
    <div class="container">
        <div class="container-fluid"><br>
            @include('inc.messages')
            @yield('content')
        </div>
    </div>

    
</body>
</html>
