@extends('app')

@section('content')
    <form method="POST" action="{{ route('agendamento.store') }}">
        {{ csrf_field() }}
        <label for="pet_id">Selecione o Pet</label>
        <input type="text" id="pet_id" name="pet_id">
        <label for="data_agendamento">Data da Consulta</label>
        <input type="date" id="data_agendamento" name="data_agendamento">
        <label for="motivo">Motivo da Consulta</label>
        <textarea name="motivo" id="motivo"></textarea>
        <button type="submit">Salvar</button>
    </form>
@endsection
