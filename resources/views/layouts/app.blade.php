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
	@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600&display=swap');
	*{
            font-family: 'Nunito Sans', sans-serif;
        }

        .opt, .opt-card{
            color: 	#202529;
            font-size: 25px;
            font-weight: 700;
        }

        .frame{
			position: absolute;
			top:0;
			bottom: 0;
			left: 0;
			right: 0;
			margin: auto;
			display: flex;
			justify-content: center;
			width:500px;
			border: dashed rgb(0, 0, 0) 3px;
		}

		.frame img{
			max-height: 100%;
            max-width: 100%;
		}

        .page {
				page-break-after: always;
        }

        .opt:hover, .opt-card:hover{
            background:#202529;
            color: 	white;
        }

        .opt-icon{
            font-size: 100px;
        }
        .center-cropped {
            width: 100px;
            height: 100px;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .page {
				page-break-after: always;
        }

        .floating-btn {
            /* display: none; */
            position: fixed;
            bottom: 40px;
            right: 50px;
            z-index: 99;
            font-size: 18px;
            cursor: pointer;
            padding: 10px;
        }

        @media (max-width:768px){
            .main {
                display: grid;

            }

            .main .att-board {
                width: 100%;
            }

            .main .summary{
                width: 100%;
            }
        }

        
    </style>
    
</head>

<body>
    @include('inc.navbar')
    @include('inc.messages')
    <div class="container mt-3">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCBS2nQrqFiKeQR0i3p9cxBu6rMqbeBGdI&libraries=places" ></script>
    <script>
        window.addEventListener('load', (event) => { initialize(); });

        function initialize() {
            var options = {
                componentRestrictions: {country: "my"}
            };

            var departure = document.getElementById('departure');
            var autocomplete = new google.maps.places.Autocomplete(departure, options);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                $('#latitudeDep').val(place.geometry['location'].lat());
                $('#longitudeDep').val(place.geometry['location'].lng());  
            });

            var destination = document.getElementById('destination');
            var autocomplete = new google.maps.places.Autocomplete(destination, options);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                $('#latitudeDes').val(place.geometry['location'].lat());
                $('#longitudeDes').val(place.geometry['location'].lng());  
            });
        }
    </script>
</body>
</html>
