@extends('layouts.app')

@section('content')

    <div class="container" style="padding-top: 1rem">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-card">
                    <div class="card-header text-white">
                        <h3 class="mb-0">Créer un compte client</h3>
                    </div>

                    <div class="card-body"  style="overflow-y: auto;overflow-x: hidden; max-height: 70vh">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="text-white">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="col-form-label text-md-right">Nom</label>
                                        <input id="name" type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="email" class="col-form-label text-md-right">Adresse email</label>
                                        <input id="email" type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="password" class="col-form-label text-md-right">Mot de passe</label>
                                        <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password-confirm" class="col-form-label text-md-right">Confirmer votre mot de passe</label>
                                        <input id="password-confirm" type="password" class="form-control form-control-sm" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="tel">Téléphone 1</label>
                                        <input type="tel" class="form-control form-control-sm" id="tel" name="tel1" placeholder="Numéro de téléphone">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tel">Téléphone 2</label>
                                        <input type="tel2" class="form-control form-control-sm" id="tel2" name="tel2" placeholder="Numéro de téléphone 2">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Adresse</label>
                                    <input type="text" class="form-control form-control-sm" name="address" id="address" placeholder="Logement">
                                </div>
                                <div class="form-group">
                                    <label for="nifstat">NIF STAT</label>
                                    <input type="text" class="form-control form-control-sm" id="nifstat" name="nifstat" placeholder="NIF - STAT">
                                </div>

                                <div class="form-group text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn bg-darkblue btn-block" data-toggle="modal" data-target="#confidentiality">
                                        Créer mon compte
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="confidentiality" tabindex="-1" role="dialog" aria-labelledby="confidentialityTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confidentialityTitle">Conditions et confidentialités</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A blanditiis cumque delectus ex fugit iure laborum molestiae mollitia, nemo perspiciatis quaerat quisquam quos reiciendis repellendus sed sunt tempora tenetur voluptates!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">J'accepte</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal end -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
