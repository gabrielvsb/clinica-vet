<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::controller(AgendamentoController::class)->prefix('agendamento')->name('agendamento.')->middleware(['auth'])->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/create',  'create')->name('create');
    Route::get('/horarios',  'horariosDisponiveis')->name('horarios');
//    Route::get('/{id}', 'show')->name('show');
//    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::controller(PetController::class)->prefix('pet')->name('pet.')->middleware(['auth'])->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/create',  'create')->name('create');
//    Route::get('/{id}', 'show')->name('show');
//    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::controller(HorarioController::class)->prefix('horarios')->name('horarios.')->middleware(['auth', 'admin'])->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/create',  'create')->name('create');
    Route::get('/gerarhorarios',  'gerarhorarios')->name('gerarhorarios');
//    Route::get('/{id}', 'show')->name('show');
//    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
//    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();

    return Redirect::to('/');
})->name('logout.custom');




