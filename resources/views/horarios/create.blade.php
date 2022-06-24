@extends('app')

@section('content')
    <form method="POST" action="{{ route('horarios.store') }}">
        {{ csrf_field() }}

        <label for="data_horarios">Data</label>
        <input type="text" id="data_horarios" name="data_horarios">
        <fieldset>
            <legend>Escolha os horarios:</legend>

            <div id="div-horarios" class="row">

            </div>

        </fieldset>

        <button type="submit">Salvar</button>
    </form>
@endsection

<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" ></script>
<script>

    $(document).ready(function (){

        $(function() {
            $( "#data_horarios" ).datepicker({
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                autoSize: false,
                minDate: 0

            });
        });

        $('#data_horarios').change(function() {
            let data_input = $('#data_agendamento').val();
            console.log(data_input);
            $.ajax({
                url : "{{ route('horarios.gerarhorarios') }}",
                type : 'GET',
                data: {
                    data_escolhida: data_input
                }
            }).done(function(result){
                console.log(result);
                let html = '';
                let html2 = '';
                if(result.length > 0){
                    html += '<div class="col">';
                    html2 += '<div class="col">';
                    $.each(result, function (index, element){

                        if(index < Math.round(result.length / 2)){
                            html += '<div class="form-check">';
                            html += '<input type="checkbox" class="form-check-input" id="' + index +'" name="' + element + '" checked>';
                            html += '<label class="form-check-label" for="' + element + '">' + element + '</label>';
                            html += '</div>';
                        }else{
                            html2 += '<div class="form-check">';
                            html2 += '<input type="checkbox" class="form-check-input" id="' + index +'" name="' + element + '" checked>';
                            html2 += '<label class="form-check-label" for="' + element + '">' + element + '</label>';
                            html2 += '</div>';
                        }
                    });
                }else{
                    html += '<option value="null">Não há horários disponíveis</option>'
                }
                html += '</div>';
                html2 += '</div>';
                console.log(html);
                let resultado = html + html2;
                $('#div-horarios').html(resultado);
            }).fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
        });
    });
</script>
