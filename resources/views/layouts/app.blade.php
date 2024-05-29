<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Global Guide') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css" integrity="sha512-UuQ/zJlbMVAw/UU8vVBhnI4op+/tFOpQZVT+FormmIEhRSCnJWyHiBbEVgM4Uztsht41f3FzVWgLuwzUqOObKw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="background: black! important;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{url('/images')}}/globalguide.png">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                           
                        @else
                        <!--<li class="nav-item">
                            <a class="nav-link" href="/create-company"> Company <i class="fa-solid fa-plus"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/create-brand"> Brands <i class="fa-solid fa-plus"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/create-distillery"> Distillery <i class="fa-solid fa-plus"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/create-merchant"> Merchant <i class="fa-solid fa-plus"></i></a>
                        </li>-->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4  row col-md-12 col-lg-12 col-sm-12 sidebar">
                    <div class="col-md-2 col-lg-2">
                    @if (Auth::check())
                        @include('sidebar')
                    @endif
                    </div>
            <div class="col-md-10 col-lg-10">
                @yield('content')
            </div>
        </main>
    </div>
    <style>
        ul.sidebar-menu li {
            list-style: none !important;
        }
        .pagination svg {
            width: 20px;
        }
        .pagination {
            display: block;
            margin: auto;
            text-align: right;
        }
        .pagination .flex.justify-between.flex-1.sm\:hidden {
            display: none;
        }
        .navbar-light .navbar-nav .nav-link {
            color: #fff ! important;
        }
    </style>

    <script>
$(document).ready(function () {
  $('#country').on('change', function () {
      var idCountry = this.value;
      //alert('sss');
      $("#state").html('');
      $.ajax({
          url: "{{url('/fetch-states')}}",
          type: "POST",
          data: {
              country_id: idCountry,
              _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (result) {
            $('#region').html('');
              $.each(result.states, function (key, value) {
                  $("#region").append('<option value="' + value
                      .id + '">' + value.name + '</option>');
              });
          }
      });
  });
  $('#other_option').on('change', function () {
      var option_value = this.value;
      //alert('sss');
      $("#both_D_M").html('');
      $.ajax({
          url: "{{url('/fetch-merchants-distillery')}}",
          type: "POST",
          data: {
            id: option_value,
              _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (result) {
            $('#both_D_M').html('');
              $.each(result.data, function (key, value) {
                  $("#both_D_M").append('<option value="' + value
                      .id + '">' + value.name + '</option>');
              });
          }
      });
  });

});
$(document).ready(function() {
      
      //$('#country').on('change', function () {
        var idCountry = 1;
        //alert('sss');
        $("#state").html('');
        $.ajax({
            url: "{{url('/fetch-states')}}",
            type: "POST",
            data: {
                country_id: idCountry,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $('#region').html('');
                $.each(result.states, function (key, value) {
                    $("#region").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    //});
  });
  
</script>
</body>
</html>
