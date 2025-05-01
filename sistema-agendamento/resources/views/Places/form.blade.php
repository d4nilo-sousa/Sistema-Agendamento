@extends('layout')

@section('content')
<div class="card shadow">
    <div class="card-header bg-secondary"><h1 class="text-white fw-bolder"> 🏫Novo Espaço</h1>
</div>
    <div class="card-body">
       <form action="{{isset($place) ? '/places/'.$place->id : '/places/new'}}" method="POST">
        @csrf
        @if(isset($place))
        @method('PUT')
        @endif
           <label for="">Nome do Espaço</label>
           <input class="form-control" type="text" name="name" value="{{$place->name ?? null}}">

           <label for="">Capacidade</label>
           <input class="form-control" type="text" name="capacity" value="{{$place->capacity ?? null}}">


           <label for="">Descrição</label>
           <textarea class="form-control mb-3" name="description">{{$place->description ?? null}}</textarea>

           <button class="btn btn-outline-secondary" type="reset">Limpar</button>
           <button class="btn btn-primary" type="submit">Salvar</button>
       </form>
    </div>
</div>
@endsection

