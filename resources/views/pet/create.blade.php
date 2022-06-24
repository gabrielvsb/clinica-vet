@extends('app')

@section('content')
    <form method="POST" action="{{ route('pet.store') }}">
        {{ csrf_field() }}
        <label for="nome">Nome do pet</label>
        <input name="nome" type="text" id="nome" placeholder="Digite o nome do pet">
        <label for="raca">Selecione a Raça</label>
        <select name="raca" id="raca">
            <option value="cachorro">Cachorro</option>
            <option value="gato">Gato</option>
            <option value="bovino">Bovino</option>
            <option value="equino">Equino</option>
        </select>
        <label for="data_nascimento">Data de Nascimento</label>
        <input name="data_nascimento" type="date" id="data_nascimento" placeholder="Digite o nome do pet">
        <button type="submit">Salvar</button>
    </form>
@endsection
