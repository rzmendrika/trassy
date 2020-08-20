<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ url('bootstrap/css/bootstrap.flaty.min.css')  }}">
	<link rel="stylesheet" href="{{ url('fontawesome/css/all.css')  }}">
	<link rel="stylesheet" href="{{ url('css/style.css')  }}">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,200;0,400;1,500&display=swap" rel="stylesheet">
	
    @if( isset($css) )
		@foreach( $css as $c)
			<link rel="stylesheet" href="{{ url($c) }}">
		@endforeach
	@endif

	<title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body  class="d-flex flex-column">
    
	<header>
		<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
            @if( isset($sideBar) )
                <button type="button" class="btn btn-info ml-0 mr-2 pb-1 bg-pink" id="toogleSidenav" onclick="$('#sidebar').toggleClass('active');">
                    <i class="fa fa-align-left" aria-hidden="true"></i>
                </button>
            @endif

			<a class="navbar-brand" href="{{ url('/') }}"><b>TRIP</b></a>
			
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon" style="height: 1em"></span>
			</button>
			
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item @if(request()->routeIs('admin.cities')) active @endif">
						<a class="nav-link" href="#">Hébergements</a>
					</li>
					<li class="nav-item @if(request()->routeIs('admin.cities')) active @endif">
						<a class="nav-link" href="#">Restaurants</a>
					</li>
				</ul>

                <ul class="navbar-nav mt-2 mt-lg-0">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item @if(request()->routeIs('login')) active @endif">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item @if(request()->routeIs('register')) active @endif">
                                <a class="nav-link" href="{{ route('register') }}">S'inscrire</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item @if(request()->routeIs('client')) active @endif dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{ route('client') }}" class="dropdown-item">Home</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
			</div>
		</nav>
	</header>
    
    @if( isset($sideBar) )
        <aside id="sidebar" class="bg-card">
            @yield('sidebar')
        </aside>
    @endif

    <main id="{{ isset($sideBar) ? 'content' : ''}}" class="wrapper">
        @yield('content')
    </main>
    
    <footer class="align-items-end footer">
        <div class="bg-primary text-center">
            text
        </div>
    </footer>

	<script src="{{ url('bootstrap/js/jquery-slim.min.js') }}"></script>
	<script src="{{ url('bootstrap/js/bootstrap.bundle.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

	@if( isset($js) )
		@foreach( $js as $j)
			<script src="{{ url($j) }}"></script>
		@endforeach
	@endif

    @yield('script')


</body>
</html>
