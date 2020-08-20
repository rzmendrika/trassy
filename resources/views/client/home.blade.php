@extends('client.layout')

@section('clientContent')


    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <h2>Listes des services proposés.</h2>

            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12 col-md-6 custom-col">
                            <div class="mb-1" style="background: red; height: 150px;"></div>
                            <div style="background: blue; height: 250px;">
                                <div class="card text-white">
                                    <a href="{{ route('client.acc.index') }}" class="text-white">
                                        <img src="{{ url('pictures/client/hebergement.png') }}" class="card-img">
                                        <div class="card-img-overlay">
                                            <h3 class="card-title">Hébergements</h3>
                                            <h6 class="card-subtitle mb-2 text-muted">Contenus</h6>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 custom-col">
                            <div class="mb-1" style="height: 250px;">
                                <div class="card text-white">
                                    <a href="{{ route('client.restau.index') }}" class="text-white">
                                        <img src="{{ url('pictures/client/restaurant.jpg') }}" class="card-img">
                                        <div class="card-img-overlay">
                                            <h3 class="card-title">Restaurant</h3>
                                            <h6 class="card-subtitle mb-2 text-muted">Contenus</h6>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div style="background: green; height: 150px;"></div>
                        </div>
                        
                        <div class="col-12 mb-1 custom-col d-none">
                            <div style="background: orange; height: 150px"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 custom-col">
                    <div class="mb-1" style="background: pink; height: 200px"></div>
                    <div style="background: pink; height: 200px"></div>
                </div>
            </div>

        </div>
    </div>

@endsection
