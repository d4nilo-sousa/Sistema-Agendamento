@extends('layout')

@section('content')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Início</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/places">Meus Espaços</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/places/new">Novo Espaço</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/scheduling">Agendamentos</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container mt-4">
        <h1 class="text-center">Bem-vindo! - Sistema de Agendamento</h1>
    </div>

@endsection