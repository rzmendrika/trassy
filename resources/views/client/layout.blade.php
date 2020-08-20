@extends('layouts.app')

@section('sidebar')

	<?php $sideBar = isset($sideBar) ? $sideBar : '' ?> 

	<nav style="background-image: url({{ url('/pictures/baobab.jpg') }}); height: 100%;">
    	<h4 class="text-white text-center p-5" style="height: 100px;vertical-align: center;">Trip Dashboard</h4>

		<div style="height: 100%;" class="bg-card">

	    	<div class="list-group">
				<a class="list-group-item list-group-item-action @if($sideBar == 'acc') active @endif" href="{{ route('client.acc.index') }}">
                    <i class="fa fa-bed mr-3"></i>Hébergements
                </a>
				<a class="list-group-item list-group-item-action  @if($sideBar == 'restau') active @endif" href="{{ route('client.restau.index') }}">
                    <i class="fa fa-chair mr-3"></i>Restaurants
                </a>
				<a class="list-group-item list-group-item-action @if(request()->routeIs('admin.cities')) active @endif" href="#">
                    <i class="fa fa-bus mr-3"></i>Transports
                </a>
				<a class="list-group-item list-group-item-action @if(request()->routeIs('admin.cities')) active @endif" href="#">
                    <i class="fa fa-home mr-3"></i>Boutiques
                </a>
			</div>

		</div>
	</nav>
    
@endsection


@section('content')
	
	<div class="container-fluid pt-4">

		@yield('clientContent')

	</div>

@endsection


@section('script')

	@if ( isset($cloudinary) )
    	{!! $cloudinary['script_config'] !!}
	@endif

@endsection
