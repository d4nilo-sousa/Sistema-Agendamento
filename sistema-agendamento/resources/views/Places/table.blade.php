@extends('layout')

@section('content')
<div class="card shadow">
    <div class="card-header bg-secondary"><h1 class="text-white fw-bolder"> 🏫Meus Espaços</h1>
</div>
    <div class="card-body">
        <table class="table table-hover">

        <tbody>
        <thead>
            <tr>         
                <th>#</th>
                <th>Nome</th>
                <th>Capacidade</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
    </tbody>
    @forelse ($places as $place)
        <tr>
            <td>{{ $place->id}}</td>
            <td>{{ $place->name}}</td>
            <td>{{ $place->capacity}}</td>
            <td>{{ $place->description}}</td>
            <td class="d-flex gap-1">

                <a href="/places/{{$place->id}}/edit" class="btn btn-secondary">Editar</a>
               
               
                <form action="/places/{{$place->id}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </td>

        </tr>

        @empty
            <tr>
                <td colspan="5" class="text-center p-3">Nada aqui zé 😞
                <h3 class="fw-light"></h3>
                <p>Para Cadastrar um ambiente
                     <a href="http://">Clique Aqui</a>
                </p>
                
                </td>
            </tr>
        
    @endforelse


      </table>   
    </div>
</div>
@endsection

