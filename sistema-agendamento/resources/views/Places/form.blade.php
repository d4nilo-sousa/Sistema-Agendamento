@extends('layout')

@section('content')
<div class="card shadow">
    <div class="card-header bg-secondary"><h1 class="text-white fw-bolder"> 🏫Novo Espaço</h1>
</div>
    <div class="card-body">
       <form action="" method="POST">
        @csrf
           <label for="">Nome do Espaço</label>
           <input class="form-control" type="text" name="name">

           <label for="">Capacidade</label>
           <input class="form-control" type="text" name="capacity">


           <label for="">Descrição</label>
           <textarea class="form-control mb-3" name="description"></textarea>

           <button class="btn btn-outline-secondary" type="submit">Limpar</button>
           <button class="btn btn-primary" type="submit">Salvar</button>
       </form>
    </div>
</div>
@endsection

