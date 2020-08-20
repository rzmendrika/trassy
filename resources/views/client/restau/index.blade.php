@extends('client.layout')

@section('clientContent')

    <div class="alert alert-info text-center">
        Vous êtes sur le plan tarifaire <strong>{{ $tarif->name }}</strong> depuis le {{ (new \Carbon\Carbon($tarif->created_at))->format('d/m/Y') }} jusqu'au {{ (new \Carbon\Carbon($tarif->created_at))->addMonth('6')->format('d/m/Y') }}
    </div>

    <div class="row text-center">
        <div class="col-6 col-md-4 pt-0 pr-5 pl-5 pb-5">
            <h2 class="display-1"><i class="fas fa-info-circle text-info"></i></h2>
            <p class=""><small>The Big Oxmox advised her not to do so</small></p>
            <p class="mt-3"><a class="btn btn-primary btn-block" href="{{ route('client.restau.edit', $restau->id) }}">Modifier</a></p>
        </div>

        <div class="col-6 col-md-4 pt-0 pr-5 pl-5 pb-5">
            <h2 class="display-1"><i class="fas fa-map-marker-alt text-success"></i></h2>
            <p class=""><small>The all-powerful Pointing has no control</small></p>
            <p class="mt-3"><a class="btn btn-primary btn-block" href="https://www.froala.com">Localisations</a></p>
        </div>

        <div class="col-6 col-md-4 pt-0 pr-5 pl-5 pb-5">
            <h2 class="display-1"><i class="far fa-images text-secondary"></i></h2>
            <p class=""><small>The copy warned the Little Blind Text</small></p>
            <p class="mt-3"><a class="btn btn-primary btn-block" href="{{ route('client.restau.pic.index', $restau->id) }}">Photos</a></p>
        </div>

        <div class="col-6 col-md-4 pt-0 pr-5 pl-5 pb-5 offset-md-2">
            <h2 class="display-1"><i class="fas fa-book-open text-red"></i></h2>
            <p class=""><small>Far far away, behind the word mountains</small></p>
            <p class="mt-3"><a class="btn btn-primary btn-block" href="https://www.froala.com">Menus</a></p>
        </div>

        <div class="col-6 col-md-4 pt-0 pr-5 pl-5 pb-5">
            <h2 class="display-1"><i class="fas fa-pizza-slice text-warning"></i></h2>
            <p class=""><small>The copy warned the Little Blind Text</small></p>
            <p class="mt-3"><a class="btn btn-primary btn-block" href="https://www.froala.com">Promotions</a></p>
        </div>

    </div>

@endsection
