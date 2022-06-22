@extends('app')

@section('content')
    <form method="POST" action="{{ route('pet.store') }}">
        {{ csrf_field() }}
        <label for="nome">Nome do pet</label>
        <input name="nome" type="text" id="nome" placeholder="Digite o nome do pet">
        <label for="data_nascimento">Data de Nascimento</label>
        <input name="data_nascimento" type="date" id="data_nascimento" placeholder="Digite o nome do pet">
        <button type="submit">Salvar</button>
    </form>
@endsection
