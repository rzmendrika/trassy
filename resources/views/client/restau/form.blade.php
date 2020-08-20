@extends('client.layout')

@section('clientContent')

    <div style="background-image: url('{{ url('pictures/client/plage.jpeg') }}');">
        <div class="card bg-card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        @if( isset($restau) )
                            <h4 class="mb-0 mt-1"><i class="fa fa-pencil-alt"></i> <span class="hide-sm">Modification</span></h4>
                        @else
                            <h4 class="mb-0 mt-1"><i class="fa fa-plus"></i> Ajout</h4>
                        @endif
                    </div>
                    <div class="col">
                        <a href="{{ route('client.restau.index') }}" class="btn btn-sm btn-info float-right"><i class="fa fa-arrow-left"></i> Retour</a>
                    </div>
                </div>
            </div>

            <div class="card-body form-card-body">
                
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle text-warning"> </i><span>{{ $error }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach

                <form action="{{ isset($restau) ? route('client.restau.update', $restau->id) : route('client.restau.store') }}" method="POST">
                    @method( isset($restau) ? 'PUT' : 'POST')
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom du restaurant :</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ isset($restau) ? $restau->name : "" }}" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-lg-6 col-12">
                            <label for="types">Types du restaurant :</label>
                            <div class="input-group mb-3">
                                <select class="form-control form-control-sm selectpicker" id="types" name="types[]" data-live-search="true" multiple="multiple" aria-describedby="types-addon" required>
                                    @foreach( $restauTypes as $type )
                                        @if( isset($restau) && $restau->types->contains($type->id) )
                                            <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                        @else
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-info border-white" type="button" id="types-addon">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-lg-6 col-12">
                            <label for="specialities">Spécialités culinaires :</label>
                            <div class="input-group mb-3">
                                <select class="form-control form-control-sm selectpicker" id="specialities" name="specialities[]" data-live-search="true" multiple="multiple" aria-describedby="specialities-addon" required>
                                    @foreach( $restauSpecialities as $speciality )
                                        @if( isset($restau) && $restau->specialities->contains($speciality->id) )
                                            <option value="{{ $speciality->id }}" selected>{{ $speciality->name }}</option>
                                        @else
                                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-info border-white" type="button" id="specialities-addon">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="days">Jours ouvrables :</label>
                        <select class="form-control form-control-sm selectpicker" id="days" name="days[]" multiple="multiple" required>
                            <option value="1" @if( isset($restau) && in_array(1, $restau->days)) selected @endif>Lundi</option>
                            <option value="2" @if( isset($restau) && in_array(2, $restau->days)) selected @endif>Mardi</option>
                            <option value="3" @if( isset($restau) && in_array(3, $restau->days)) selected @endif>Mercredi</option>
                            <option value="4" @if( isset($restau) && in_array(4, $restau->days)) selected @endif>Jeudi</option>
                            <option value="5" @if( isset($restau) && in_array(5, $restau->days)) selected @endif>Vendredi</option>
                            <option value="6" @if( isset($restau) && in_array(6, $restau->days)) selected @endif>Samedi</option>
                            <option value="7" @if( isset($restau) && in_array(7, $restau->days)) selected @endif>Dimanche</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="opening">Ouverture :</label>
                            <input id="opening" class="form-control form-control-sm" type="time" name="opening" value="{{ isset($restau) ? $restau->opening : '08:00' }}" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="closing">Fermeture :</label>
                            <input id="closing" class="form-control form-control-sm" type="time" name="closing" value="{{ isset($restau) ? $restau->closing : '17:00' }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="min_price">Fourchette de prix minimum :</label>
                            <div class="input-group input-group-sm">
                                <input type="number" min="0" class="form-control form-control-sm" id="min_price" aria-describedby="emailHelp" name="min_price" value="{{ isset($restau) ? $restau->min_price : 200 }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text btn-info">Ariary</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="max_price">Fourchette de prix maximum :</label>
                            <div class="input-group input-group-sm">
                                <input type="number" min="0" class="form-control form-control-sm" id="max_price" aria-describedby="emailHelp" name="max_price" value="{{ isset($restau) ? $restau->max_price : 10000 }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text btn-info">Ariary</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="wifi">Wi-Fi :</label>
                            <select id="wifi" class="form-control form-control-sm selectpicker" name="wifi">
                                @if( isset($restau) && $restau->wifi )
                                    <option value="1" selected>oui</option>
                                    <option value="0">non</option>
                                @else
                                    <option value="1">oui</option>
                                    <option value="0" selected>non</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="delivery">Service de livraison :</label>
                            <select id="delivery" class="form-control form-control-sm selectpicker" name="delivery">
                                @if( isset($restau) && $restau->delivery )
                                    <option value="1" selected>oui</option>
                                    <option value="0">non</option>
                                @else
                                    <option value="1">oui</option>
                                    <option value="0" selected>non</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="parking">Parking :</label>
                            <select id="parking" class="form-control form-control-sm selectpicker" name="parking" aria-describedby="parking-addon" required>
                                @if( isset($restau) && $restau->parking )
                                    <option value="1" selected>oui</option>
                                    <option value="0">non</option>
                                @else
                                    <option value="1">oui</option>
                                    <option value="0" selected>non</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea name="description" class="form-control form-control-sm" id="description" rows="3" aria-describedby="description-pic-addon" required>{{ isset($restau) ? $restau->description : "" }}</textarea>
                    </div>

                   <button class="btn btn-sm btn-info btn-block btn-submit" type="submit">Terminer</button>
                </form>
            </div>
        </div>
    </div>
    
@endsection
