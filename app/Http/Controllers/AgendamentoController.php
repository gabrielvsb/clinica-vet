<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class AgendamentoController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::where('agendamentos.user_id', '=', Auth::id())
            ->join('pets', 'pets.id', '=', 'agendamentos.pet_id')
            ->select('agendamentos.*', 'pets.nome as nome_pet')
            ->get();
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

            $horario = DB::table('horarios_disponiveis')->where('id', '=', $inputs['horario_id'])->pluck('horario')->toArray();

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

    public function horariosDisponiveis(Request $request): \Illuminate\Support\Collection
    {
        $input = $request->all();
        return DB::table('horarios_disponiveis')->where('data', '=', $input['data_escolhida'])->where('ativo', '=', true)->get();
    }

    public function formatarDataHora(int $horarioId, string $data): string
    {
        $horario = DB::table('horarios_disponiveis')->where('id', '=', $horarioId)->pluck('horario')->toArray();
        return  $data . ' ' . $horario[0];
    }

    public function desativarHorario(int $horarioId)
    {
        try {
            return DB::table('horarios_disponiveis')->where('id', '=', $horarioId)->update(['ativo' => false]);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }
}
