@extends('client.layout')

@section('clientContent')

<div class="alert alert-info text-center">
    Vous êtes sur le plan tarifaire <strong>{{ $tarif->name }}</strong> depuis le {{ (new \Carbon\Carbon($tarif->created_at))->format('d/m/Y') }} jusqu'au {{ (new \Carbon\Carbon($tarif->created_at))->addMonth('6')->format('d/m/Y') }}
</div>

<div class="border border-secondary rounded mb-5" style="overflow-x: auto;">
    <table class="table table-hover mb-0" style="margin-top: -2px">
        <thead class="table-light">
            <tr>
                <th class="">Nom</th>
                <th class="">Ville</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accs as $acc)
            <tr>
                <td>{{ $acc->name }}</td>
                <td>{{ $acc->contact->city }}</td>
                <td class="text-center">
                    <a href="{{ route('client.acc.edit', $acc->id) }}" class="btn btn-sm btn-secondary" title="">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="{{ route('client.acc.edit', $acc->id) }}" class="btn btn-sm btn-primary" title="Modifier les propriétés">
                        <i class="fa fa-pencil-alt"></i>
                    </a>
                    <a href="{{ route('client.acc.pic.index', $acc->id) }}" class="btn btn-sm btn-success" title="Ajouter ou modifier les photos">
                        <i class="fa fa-camera"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
