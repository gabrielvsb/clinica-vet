@extends('app')

@section('content')
    <form method="POST" action="{{ route('agendamento.store') }}">
        {{ csrf_field() }}
        <label for="pet_id">Selecione o Pet</label>

        <select name="pet_id" id="pet_id">
            @foreach($pets as $pet)
                <option value="{{ $pet->id }}">{{ $pet->nome }}</option>
            @endforeach
        </select>



        <label for="data_agendamento">Data da Consulta</label>
        <input type="text" id="data_agendamento" name="data_agendamento">
        <label for="horario_id">Selecione o horário</label>
        <select name="horario_id" id="horario_id">
            <option value="default">Selecione uma data...</option>
        </select>
        <label for="motivo">Motivo da Consulta</label>
        <textarea name="motivo" id="motivo"></textarea>
        <button type="submit">Salvar</button>
    </form>
@endsection

<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
<script>

    $(document).ready(function (){

        $(function() {
            $( "#data_agendamento" ).datepicker({
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                autoSize: false,
                minDate: 0

            });
        });

        $('#data_agendamento').change(function() {
            let data_input = $('#data_agendamento').val();
            $.ajax({
                url : "{{ route('agendamento.horarios') }}",
                type : 'GET',
                data: {
                    data_escolhida: data_input
                }
            }).done(function(result){
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
