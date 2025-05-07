@extends('layout')

@section('content')
<div class="card shadow">
    <div class="card-header bg-secondary"><h1 class="text-white fw-bolder"> 🏫Novo Espaço</h1>
</div>
    <div class="card-body">
       <form action="{{isset($place) ? '/places/'.$place->id : '/places/new'}}" method="POST">
        @csrf
        @if(isset($place))
        @method('put')
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

<!--Toast-->
<button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

<div class="toast-container position-fixed top-0 end-0 p-3">
  <div data-bs-delay="2500" id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">✔ Bootstrap</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ session('success')}}
    </div>
  </div>
</div>

@endsection

@section ('scripts')
@if (session('success') != null)
    
@endif
<script>

    const toastLiveExample = document.getElementById('liveToast')   
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
    toastBootstrap.show()

</script>

@endsection
