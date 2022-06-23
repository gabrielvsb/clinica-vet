@extends('app')

@section('content')
    <h2>Index Agendamento</h2>
    <a href="{{ route('agendamento.create') }}">Criar Agendamento</a>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Pet</th>
            <th scope="col">Data</th>
            <th scope="col">Motivo</th>
        </tr>
        </thead>
        <tbody>

        @foreach($agendamentos as $agendamento)
            <tr>
                <th scope="row">{{ $agendamento->id }}</th>
                <td>{{ $agendamento->nome_pet }}</td>
                <td>{{ \Carbon\Carbon::parse($agendamento->data_agendamento)->format('d/m/Y H:i:s') }}</td>
                <td>{{ $agendamento->motivo }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>



@endsection
