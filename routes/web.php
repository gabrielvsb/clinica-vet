<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::controller(AgendamentoController::class)->prefix('agendamento')->name('agendamento.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/create',  'create')->name('create');
//    Route::get('/{id}', 'show')->name('show');
//    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
//    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::controller(PetController::class)->prefix('pet')->name('pet.')->group(function (){
    Route::get('/',  'index')->name('index');
    Route::get('/create',  'create')->name('create');
//    Route::get('/{id}', 'show')->name('show');
//    Route::put('/{id}', 'update')->name('update');
    Route::post('/', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});




