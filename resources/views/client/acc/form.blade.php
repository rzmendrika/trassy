@extends('client.layout')

@section('clientContent')

    <div style="background-image: url('{{ url('pictures/client/plage.jpeg') }}');">
        <div class="card bg-card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 class="mb-0 mt-1">Modification</h4>
                    </div>
                    <div class="col">
                        <a href="{{ route('client.acc.index') }}" class="btn btn-sm btn-info float-right"><i class="fa fa-arrow-left"></i> Retour</a>
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

                <form id="form" action="{{ isset($acc) ? route('client.acc.update', $acc->id) : route('client.acc.store') }}" method="POST">
                    @method( isset($acc) ? 'PUT' : 'POST')
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom de l'hébergement :</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ isset($acc) ? $acc->name : "" }}" required>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-8">
                            <label for="types">Types de l'hébergement :</label>
                            <div class="input-group ">
                                <select class="form-control form-control-sm selectpicker" id="types" name="types[]" data-live-search="true" multiple="multiple" aria-describedby="types-addon" required>
                                    @foreach( $accTypes as $type )
                                        @if( isset($acc) && $acc->types->contains($type->id) )
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

                        <div class="form-group col-sm-4">
                            <label for="stars">Etoiles :</label>
                            <input type="number" class="form-control form-control-sm" id="stars" name="stars" value="{{ isset($acc) ? $acc->stars : 1 }}" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="types">Chambres :</label>

                        <div class="input-group">
                            <div class="btn-group btn-group-sm mr-2 mb-2 border border-white" role="group" aria-label="First group">
                                <button type="button" class="btn btn-info btn-child btn-add-child" data-toggle="modal" data-target="#childDetailsModal" data-backdrop="static" data-keyboard="false">
                                    <i class="fa fa-plus"></i> Ajouter
                                </button>
                            </div>
                            
                            <div id="rooms">
                                @if( isset($acc) )
                                    @foreach ($acc->rooms as $room)
                                        <div class="btn-group btn-group-sm mr-2 mb-2 border border-white">
                                            <button type="button" class="btn btn-primary btn-child" data="{{ $room->id }}" data-toggle="modal" data-target="#childDetailsModal" data-backdrop="static" data-keyboard="false">
                                                {{ $room->category->name . ' (' . $room->bed_numbers . ')'}}
                                            </button>
                                            <button type="button" class="btn btn-danger btn-room-delete">
                                                <span class="spinner-border spinner-border-sm d-none"></span>
                                                <span class="">X</span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="btn-group btn-group-sm mr-2 mb-2 border border-white model d-none">
                                    <button type="button" class="btn btn-primary btn-child" data="" data-toggle="modal" data-target="#childDetailsModal" data-backdrop="static" data-keyboard="false"></button>
                                    <button type="button" class="btn btn-danger btn-room-delete">
                                        <span class="spinner-border spinner-border-sm d-none"></span>
                                        <span class="">X</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="parking">Parking :</label>
                            <select id="parking" class="form-control form-control-sm selectpicker" name="parking" aria-describedby="parking-addon" required>
                                @if( isset($acc) && $acc->parking )
                                    <option value="1" selected>oui</option>
                                    <option value="0">non</option>
                                @else
                                    <option value="1">oui</option>
                                    <option value="0" selected>non</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="wifi">Wi-Fi :</label>
                            <select id="wifi" class="form-control form-control-sm selectpicker" name="wifi">
                                @if( isset($acc) && $acc->wifi )
                                    <option value="1" selected>oui</option>
                                    <option value="0">non</option>
                                @else
                                    <option value="1">oui</option>
                                    <option value="0" selected>non</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="roomservice">Service de chambre :</label>
                            <select id="roomservice" class="form-control form-control-sm selectpicker" name="roomservice">
                                @if( isset($acc) && $acc->roomservice )
                                    <option value="1" selected>oui</option>
                                    <option value="0">non</option>
                                @else
                                    <option value="1">oui</option>
                                    <option value="0" selected>non</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    @if( isset($acc) )
                        {{ view('client.components.contact', ['contact' => $acc->contact ]) }}
                    @else
                        {{ view('client.components.contact') }}
                    @endif

                    <div class="form-group">
                        <label for="description">Description :</label>

                        <div class="input-group">
                            <textarea name="description" class="form-control form-control-sm" id="description" rows="3" aria-describedby="description-pic-addon" required>{{ isset($acc) ? $acc->description : "" }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                       <button class="btn btn-sm btn-info btn-block btn-submit" type="submit">Terminer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -- room details -->
    <div class="modal fade" id="childDetailsModal" tabindex="-1" role="dialog" aria-labelledby="childDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="childDetailsModalModalLabel">Détails de la chambre</h5>
                </div>

                <div class="modal-body"  style="overflow-x: hidden !important;">
                    <div>
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>
                        </div>
                    </div>
                    <form id="child-form">
                    </form>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-info" id="submit-child">
                        <span class="spinner-border spinner-border-sm spinner d-none" role="status" aria-hidden="true"></span>
                        <span>Terminer</span>
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="child-url" value="{{ route('client.acc.room.index') }}">
    <input type="hidden" id="id"        value="{{ isset($acc) ? $acc->id : 0    }}">

@endsection
