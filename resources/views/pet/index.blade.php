@extends('app')

@section('content')
    <h2>Index Pet</h2>
    @if(auth()->user()->role == 'cliente')
        <a href="{{ route('pet.create') }}">Criar Pet</a>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Data de Nascimento</th>
            <th scope="col">Raça</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>

        @foreach($pets as $pet)
            <tr>
                <th scope="row">{{ $pet->id }}</th>
                <td>{{ $pet->nome }}</td>
                <td>{{ \Carbon\Carbon::parse($pet->data_nascimento)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($pet->raca) }}</td>
                <td>
                    <form action="{{ route('pet.destroy', $pet->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit">Excluir</button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>

    $(document).ready(function (){

        $('#data_agendamento').change(function() {
            let data_input = $('#data_agendamento').val();
            $.ajax({
                url : "{{ route('agendamento.horarios') }}",
                type : 'GET',
                data: {
                    data_escolhida: data_input
                }
            }).done(function(result){
                console.log(result);
                let html = '';
                if(result.length > 0){
                    $.each(result, function (index, element){
                        html += '<option value="' + element.id + '">' + element.horario + '</option>'
                    });
                }else{
                    html += '<option value="null">Não há horários disponíveis</option>'
                }
                $('#horario_id').html(html);
            }).fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
        });
    });
</script>
