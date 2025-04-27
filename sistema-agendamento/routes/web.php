<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlaceController;

//rota inicial
Route::get('/', function () {
    return view('home');
});


Route::get('/places', function () {
    return view('Places/form');
});

//rotas do Espaço(Places)
Route::get('/places', [PlaceController::class,'index']);
Route::get('/places/new', [PlaceController::class,'create']);
Route::post('/places/new', [PlaceController::class,'store']);
