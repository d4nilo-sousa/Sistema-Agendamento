<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SchedulingController;
use App\Http\Controllers\UserController;

// ... (Rotas de Auth mantidas iguais) ...
Route::get('/register', [UserController::class, 'signUp']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'signIn'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth')->group(function() {

    // Rota inicial
    Route::get('/', function () {
        return view('home');
    });

    // Logout
    Route::get('logout', [UserController::class, 'logout']);

    // Rotas de Espaço (Places)
    Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
    Route::get('/places/new', [PlaceController::class, 'create'])->name('places.create');
    Route::post('/places', [PlaceController::class, 'store'])->name('places.store');
    
    // Rotas para edição de Espaços (Places)
    Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])->name('places.edit');
    Route::put('/places/{place}', [PlaceController::class, 'update'])->name('places.update');
    
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('places.destroy');

    // Rotas de Agendamento (Scheduling)
    // Exibe a grade
    Route::get('/scheduling', [SchedulingController::class, 'index'])->name('scheduling.index');
    // Salva o agendamento
    Route::post('/scheduling', [SchedulingController::class, 'store'])->name('scheduling.store'); 
    // Remove o agendamento
    Route::delete('/scheduling/{scheduling}', [SchedulingController::class, 'destroy'])->name('scheduling.destroy');
});