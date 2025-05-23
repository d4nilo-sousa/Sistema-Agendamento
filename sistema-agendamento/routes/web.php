<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SchedulingController;

//rota inicial
Route::get('/', function () {
    return view('home');
});


//rotas do Espaço(Places)
Route::get('/places', [PlaceController::class,'index']);
Route::get('/places/new', [PlaceController::class,'create']);
Route::post('/places/new', [PlaceController::class,'store']);
Route::delete('/places/{id}',[PlaceController::class,'destroy']);
Route::get('/places/{id}/edit',[PlaceController::class,'edit']);
Route::put('/places/{id}/edit', [PlaceController::class,'update']);

//Rotas do Agendamento(Scheduling)
Route::get('/scheduling', [SchedulingController::class,'index']);
