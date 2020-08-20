@extends('client.layout')
@section('clientContent')

<div class="row">
	<div class="col-12 col-md-6 offset-md-3">
		<div class="card text-white bg-info">
			<div class="card-header"><h1 class="h4">Paiement</h1></div>
			<div class="card-body">
				<form action="{{ route('client.payment.store') }}" class="m-auto" method="POST">
					@csrf()
					<div class="form-group">
						<label for="subscription">Type d'abonnement :</label>
						<select id="subscription" class="form-control " name="subscription" required>
							<option value="1">Mensuel</option>
							<option value="2">Semestriel</option>
							<option value="3">Annuel</option>
						</select>
					</div>
					<div class="form-group">
						<label for="price">Coût :</label>
						<select id="price" class="form-control " disabled="true" required>
							<option value="1">Mensuel</option>
							<option value="2">Semestriel</option>
							<option value="3">Annuel</option>
						</select>
					</div>
					<div class="form-group">
						<label for="mode">Mode de paiement :</label>
						<select id="mode" class="form-control " name="mode" required>
							<option value="1">MVola</option>
							<option value="2">Airtel Money</option>
							<option value="3">Orange Money</option>
						</select>
					</div>
					<input type="hidden" value="{{ $rub_type }}"  name="rub_type">
					<input type="hidden" value="{{ $tarif->id }}" name="tarif">
					<button class="btn btn-success btn-block" type="submit">Terminer</button>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection {{-- clientContent section --}}
