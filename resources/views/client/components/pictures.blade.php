@extends('client.layout')
@section('clientContent')
@php $i = 0; $show = true; @endphp

<div class="alert alert-info">
    <h1 class="h4">Vos photos: <span class="pic-now">{{ $now }}</span> / {{ $max }}</h1>
</div>

<div class="card">
	<div class="card-header">
		<ul class="nav nav-tabs card-header-tabs" id="tab" role="tablist">

			@foreach ($rubriques as $rub)
				@if( isset($rub['data']) )
					<li class="nav-item @if( isset($rub['data']) ) dropdown @endif">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ $rub['title'] }}</a>
						<div class="dropdown-menu">
							@foreach ($rub['data'] as $data)
								<a class="dropdown-item tab-link" id="{{ $data['id'] }}-tab" data-toggle="tab" href="#{{ $data['id'] }}" role="tab" aria-controls="{{ $data['id'] }}" aria-selected="false">{{ $data['title'] }}</a>
							@endforeach
						</div>
					</li>
				@else
					<li class="nav-item">
				    	<a class="nav-link {{ $show ? 'active' : '' }} tab-link" id="{{ $rub['id'] }}-tab" data-toggle="tab" href="#{{ $rub['id'] }}" role="tab" aria-controls="{{ $rub['id'] }}" aria-selected="true">{{ $rub['title'] }}</a>
				  	</li>
				@endif
				@php $show = false; @endphp
			@endforeach

		</ul>
	</div>
	<div class="progress" style="height: 5px;display: none;">
		<div class="progress-bar bg-success" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
	</div>
	<div class="card-body">
		<div class="tab-content" id="tabContent">
			@php
				$show  = true;
				$datas = [];
				foreach ($rubriques as $rub)
				{
					if( isset($rub['data']) )
					{
						$datas = array_merge_recursive($datas, $rub['data'] );
					}
					else
					{
						$datas[] = $rub;
					}
				}
			@endphp
	
			@foreach ($datas as $rub)
				<div class="tab-pane fade {{ $show ? 'show active' : '' }}" id="{{ $rub['id'] }}" role="tabpanel" aria-labelledby="{{ $rub['id'] }}-tab">
					<div class="row">
						<div class="content-add m-2 {{ ($now == $max) ? 'error' : '' }}">
							<label type="button" class="btn btn-secondary mb-0" data="{{ $rub['type'] }}" data-child="{{ $rub['child_id'] }}" >
								<span class="fa fa-plus d-block display-3 m-3"></span>
								<span class="d-block" >Ajouter</span>
								{!! $show ? $cloudinary['tag'] : '' !!}
							</label>
						</div>
						@foreach ($rub['pictures'] as $pic)
							<div class="pic-thumb m-2 border border-secondary">
								<button class="btn btn-danger btn-delete btn-sm" type="button" data="{{ $pic->id }}"><i class="fa fa-trash"></i></button>
								<img src="{{ $pic->smallPath() }}" alt="" class="">
							</div>
						@endforeach
					</div>
				</div>
				@php $show = false; @endphp
			@endforeach
		</div>
	</div>
</div>

<div class="pic-thumb m-2 border border-secondary d-none">
	<button class="btn btn-danger btn-delete btn-sm" type="button" data=""><i class="fa fa-trash"></i></button>
	<img src="" alt="" class="">
</div>

<div class="toast border border-danger hide" id="toast-erreur" data-delay="1000000" style="position: absolute; right: 5px; max-width:500px; z-index: 2" aria-live="assertive" aria-atomic="true">
	<div class="toast-header bg-warning">
		<strong class="mr-auto text-danger"><i class="fa fa-exclamation-triangle mr-3"></i>Erreur</strong>
		<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="toast-body text-danger">
		Une erreur est survenue, verifier :
		<ul class="mb-0">
			<li>Si vous avez bien sélectionner des images.</li>
			<li>Si vous avez atteint le nombre max d'images.</li>
			<li>La taille des images. (<strong>Max: 2Mo</strong>)</li>
		</ul>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
</div>

<input type="hidden" value="{{ $route }}" id="url">
@endsection {{-- clientContent section --}}

@section('script')
{!! $cloudinary['script_config'] !!}
@endsection