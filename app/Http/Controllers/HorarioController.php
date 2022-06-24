<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function index()
    {
        return view('horarios.index');
    }

    public function create()
    {
        return view('horarios.create');
    }

    public function store(Request $request)
    {
        try {
            $inputs = $request->all();
            $data = Carbon::createFromFormat('d/m/Y', $inputs['data_horarios'])->format('Y-m-d');
            $horarios = $this->criarArrayHorarios($request->all());
            DB::transaction(function () use($data, $horarios) {
                foreach ($horarios as $key => $value){
                    DB::table('horarios_disponiveis')->insert([
                        'data' => $data,
                        'horario' => $value
                    ]);
                }
            });
            return redirect()->route('horarios.index');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }


    }

    public function criarArrayHorarios(array $arrayRequest)
    {
        $opcoes = array();
        foreach ($arrayRequest as $key => $value)
            if ($value == 'on'){
                array_push($opcoes, $key);
            }
        return $opcoes;
    }

    public function gerarHorarios()
    {
        $time_start = '08:00';
        $time_end   = '18:00';

        # use date function with the time variables to create a timestamp to use in the while loop
        $timestamp_start = strtotime(date('d-m-Y').' '.$time_start);
        $timestamp_end   = strtotime(date('d-m-Y').' '.$time_end);

        # create array to fill with the options
        $options_array = array();

        # loop through until the end timestamp is reached
        while($timestamp_start <= $timestamp_end){
            $options_array[] = date('H:i', $timestamp_start);
            $timestamp_start = $timestamp_start + 1800; //Adds 15 minutes
        }

        return $options_array;
    }
}
