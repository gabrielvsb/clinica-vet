@extends('app')

@section('content')
    <h2>Index Agendamento</h2>
    @if(auth()->user()->role == 'cliente')
        <a href="{{ route('agendamento.create') }}">Criar Agendamento</a>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Pet</th>
            <th scope="col">Data</th>
            <th scope="col">Motivo</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>

        @foreach($agendamentos as $agendamento)
            <tr>
                <th scope="row">{{ $agendamento->id }}</th>
                <td>{{ $agendamento->nome_pet }}</td>
                <td>{{ \Carbon\Carbon::parse($agendamento->data_agendamento)->format('d/m/Y H:i:s') }}</td>
                <td>{{ $agendamento->motivo }}</td>
                <td>
                    <form action="{{ route('agendamento.destroy', $agendamento->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>



@endsection
