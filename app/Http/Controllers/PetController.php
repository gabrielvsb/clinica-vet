<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'cliente'){
            $pets = Pet::where('user_id', Auth::id())->get();
        }else{
            $pets = Pet::all();
        }

        return view('pet.index', ['pets' => $pets]);
    }

    public function create()
    {
        return view('pet.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome' => ['required', 'string', 'max:255'],
                'data_nascimento' => ['required', 'date'],
                'raca' => ['required', 'string', 'max:255']
            ]);

            Pet::create([
                'nome' => $request->nome,
                'data_nascimento' => $request->data_nascimento,
                'user_id' => Auth::id(),
                'raca' => $request->raca
            ]);

            return redirect()->route('pet.index');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function destroy(int $id)
    {
        try {
            $pet = Pet::find($id);

            if (!$pet){
                abort(404);
            }

            $pet->delete();

            return redirect()->route('pet.index');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
