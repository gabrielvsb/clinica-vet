<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index()
    {
        return view('agendamento.index');
    }

    public function create()
    {
        return view('agendamento.create');
    }
}
