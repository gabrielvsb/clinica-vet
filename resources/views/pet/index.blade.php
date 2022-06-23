@extends('app')

@section('content')
    <h2>Index Pet</h2>
    <a href="{{ route('pet.create') }}">Criar Pet</a>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Data de Nascimento</th>
        </tr>
        </thead>
        <tbody>

        @foreach($pets as $pet)
            <tr>
                <th scope="row">{{ $pet->id }}</th>
                <td>{{ $pet->nome }}</td>
                <td>{{ \Carbon\Carbon::parse($pet->data_nascimento)->format('d/m/Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
