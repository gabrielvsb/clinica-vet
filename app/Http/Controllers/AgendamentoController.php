<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Pet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class AgendamentoController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'cliente'){
            $agendamentos = Agendamento::where('agendamentos.user_id', '=', Auth::id())
                ->join('pets', 'pets.id', '=', 'agendamentos.pet_id')
                ->select('agendamentos.*', 'pets.nome as nome_pet')
                ->get();
        }else{
            $agendamentos = Agendamento::join('pets', 'pets.id', '=', 'agendamentos.pet_id')
                ->select('agendamentos.*', 'pets.nome as nome_pet')
                ->get();
        }

        return view('agendamento.index', ['agendamentos' => $agendamentos]);
    }

    public function create()
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('agendamento.create', ['pets' => $pets]);
    }

    public function store(Request $request)
    {

        try {
            $inputs = $request->all();

            if($inputs['horario_id'] == null){
                throw new \Exception('Horário inválido!');
            }

            $data = $this->formatarDataHora($inputs['horario_id'], $inputs['data_agendamento']);

            $request->validate([
                'pet_id' => ['required', 'exists:pets,id'],
                'motivo' => ['required', 'string']
            ]);

            Agendamento::create([
                'user_id'          => Auth::id(),
                'pet_id'           => $inputs['pet_id'],
                'data_agendamento' => $data,
                'motivo'           => $inputs['motivo']
            ]);

            $this->desativarHorario($inputs['horario_id']);

            return redirect()->route('agendamento.index');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function destroy(int $id)
    {
        try {
            $agendamento = Agendamento::find($id);

            if (!$agendamento){
                abort(404);
            }

            $this->ativarHorario($agendamento->data_agendamento);

            $agendamento->delete();

            return redirect()->route('agendamento.index');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function horariosDisponiveis(Request $request): \Illuminate\Support\Collection
    {
        $input = $request->all();
        $data = Carbon::createFromFormat('d/m/Y', $input['data_escolhida'])->format('Y-m-d');
        return DB::table('horarios_disponiveis')
            ->where('data', '=', $data)
            ->where('ativo', '=', 1)
            ->get();
    }

    public function formatarDataHora(int $horarioId, string $data): string
    {
        $data_formatada = Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
        $horario = DB::table('horarios_disponiveis')
            ->where('id', '=', $horarioId)
            ->pluck('horario')->toArray();
        return  $data_formatada . ' ' . $horario[0];
    }

    public function desativarHorario(int $horarioId)
    {
        try {
            return DB::table('horarios_disponiveis')
                ->where('id', '=', $horarioId)
                ->update(['ativo' => false]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function ativarHorario(string $dataHoraAgendamento)
    {
        try {
            $dataHora = explode(' ', $dataHoraAgendamento);
            $data = $dataHora[0];
            $hora = $dataHora[1];

            return DB::table('horarios_disponiveis')
                ->where('data', '=', $data)
                ->where('horario', '=', $hora)
                ->update(['ativo' => true]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
