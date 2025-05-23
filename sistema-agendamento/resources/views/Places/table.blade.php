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
               
               
             <!--=- data: Atributos de dados personalizados ---->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-place-id="{{$place->id}}">
                    Excluir
                </button>

            </td>

        </tr>

        @empty
            <tr>
                <td colspan="5" class="text-center p-3">Nada aqui zé 😞
                <h3 class="fw-light"></h3>
                <p>Para Cadastrar um ambiente
                     <a href="/places/new">Clique Aqui</a>
                </p>
                
                </td>
            </tr>
        
    @endforelse

      </table>   
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Atenção</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Deseja realmente excluir este espaço?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
           <form id="delete_place_form" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>

      </div>
    </div>
  </div>
</div>


@endsection


@section('scripts')
<script src="{{asset('js/confirmationModal.js')}}"> </script>
  
@endsection

