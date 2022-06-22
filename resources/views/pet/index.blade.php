@extends('app')

@section('content')
    <h2>Index Pet</h2>
    <a href="{{ route('pet.create') }}">Criar Pet</a>
    {{ $pets }}

@endsection
