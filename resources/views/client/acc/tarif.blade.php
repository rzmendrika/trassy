@extends('client.layout')
@section('clientContent')

<section class="fdb-block" style="background-image: url(imgs/shapes/8.svg);">
	<div class="container">
		<div class="row text-center">
			<div class="col">
				<h2>Pricing Plans</h2>
			</div>
		</div>

		<div class="row mt-5 align-items-center no-gutters">
			<div class="col-12 col-sm-10 col-md-6 m-auto col-lg-3 text-center shadow">
				<div class="bg-white pb-5 pt-5 pl-4 pr-4 rounded-left">
					<h4 class="font-weight-light">Bronze</h4>

					<p class="h4 mt-5 mb-5"><strong>20 000 Ar</strong> <span class="h5">/mois</span></p>

					<ul class="text-left">
						<li><strong>12</strong> Photos</li>
						<li><strong>0</strong> annexe</li>
						<li>Item 3</li>
					</ul>

					<p class="text-center pt-4"><a href="{{ route('client.payment.create', [config('global.acc.id'), 1]) }}" class="btn btn-outline-dark">Choisir</a></p>
				</div>
			</div>

			<div class="col-12 col-sm-10 col-md-6 ml-auto mr-auto col-lg-3 text-center mt-4 mt-lg-0 sl-1 pt-0 pt-lg-3 pb-0 pb-lg-3 bg-white fdb-touch rounded shadow">
				<div class="pb-5 pt-5 pl-4 pr-4">
					<h4 class="font-weight-light">Silver</h4>

					<p class="h4 mt-5 mb-5"><strong>25 000 Ar</strong> <span class="h5">/mois</span></p>

					<ul class="text-left">
						<li><strong>20</strong> Photos</li>
						<li><strong>2</strong> annexes</li>
						<li>Item 3</li>
					</ul>

					<p class="text-center pt-4"><a href="{{ route('client.payment.create', [config('global.acc.id'), 2]) }}" class="btn btn-primary btn-shadow">Choisir</a></p>
				</div>
			</div>

			<div class="col-12 col-sm-10 col-md-6 ml-auto mr-auto col-lg-3 text-center mt-4 mt-lg-0 sl-1 pt-0 pt-lg-3 pb-0 pb-lg-3 bg-white fdb-touch rounded shadow">
				<div class="bg-white pb-5 pt-5 pl-4 pr-4 rounded-right">
					<h4 class="font-weight-light">Gold</h4>

					<p class="h4 mt-5 mb-5"><strong>30 000 Ar</strong> <span class="h5">/mois</span></p>

					<ul class="text-left">
						<li><strong>35</strong> Photos</li>
						<li><strong>5</strong> annexes</li>
						<li>Item 3</li>
					</ul>

					<p class="text-center pt-4"><a href="{{ route('client.payment.create', [config('global.acc.id'), 3]) }}" class="btn btn-outline-dark">Choisir</a></p>
				</div>
			</div>

			<div class="col-12 col-sm-10 col-md-6 ml-auto mr-auto col-lg-3 text-center mt-4 mt-lg-0 shadow">
				<div class="bg-white pb-5 pt-5 pl-4 pr-4 rounded-right">
					<h4 class="font-weight-light">Gold</h4>

					<p class="h4 mt-5 mb-5"><strong>40 000 Ar</strong> <span class="h5">/mois</span></p>

					<ul class="text-left">
						<li><strong>50</strong> Photos</li>
						<li><strong>10</strong> annexes</li>
						<li>Item 3</li>
					</ul>

					<p class="text-center pt-4"><a href="{{ route('client.payment.create', [config('global.acc.id'), 4]) }}" class="btn btn-outline-dark">Choisir</a></p>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection