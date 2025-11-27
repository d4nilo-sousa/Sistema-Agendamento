@extends('layout')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <i class="bi bi-building-fill-gear text-purple-600 text-4xl"></i>
            <h1 class="text-3xl font-bold text-purple-700">Meus Espaços</h1>
        </div>

        <a href="/places/new"
           class="px-4 py-2 rounded-xl bg-purple-600 text-white hover:bg-purple-700 shadow-md transition flex items-center gap-2">
            <i class="bi bi-plus-circle"></i> Novo Espaço
        </a>
    </div>

    {{-- Card da tabela --}}
    <div class="bg-white shadow-lg rounded-2xl border border-purple-200 p-4">

        <table class="table table-hover text-center align-middle">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Capacidade</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody class="table-group-divider">

                @forelse ($places as $place)
                <tr class="hover:bg-purple-50">
                    <td class="fw-bold text-purple-700">{{ $place->id }}</td>
                    <td>{{ $place->name }}</td>
                    <td>{{ $place->capacity }}</td>
                    <td class="text-start px-4">{{ $place->description }}</td>

                    <td class="flex justify-center gap-2">
                        {{-- Editar --}}
                        <a href="/places/{{ $place->id }}/edit"
                           class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 rounded-pill">
                            <i class="bi bi-pencil-fill"></i> Editar
                        </a>

                        {{-- Excluir --}}
                        <button type="button"
                            class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 rounded-pill"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmationModal"
                            data-place-id="{{ $place->id }}">
                            <i class="bi bi-trash-fill"></i> Excluir
                        </button>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="py-5">
                        <div class="flex flex-col items-center text-center text-gray-600">
                            <i class="bi bi-emoji-frown text-5xl text-purple-500 mb-3"></i>
                            <h3 class="text-xl font-semibold">Nenhum espaço cadastrado</h3>
                            <p class="text-sm">Clique abaixo para adicionar um novo.</p>

                            <a href="/places/new"
                               class="mt-3 px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition flex items-center gap-2">
                                <i class="bi bi-plus-circle"></i> Cadastrar Espaço
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

{{-- Modal de confirmação --}}
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow-lg">

        <div class="modal-header bg-purple-600 text-white">
            <h1 class="modal-title fs-5">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Aviso!
            </h1>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center py-4">
            <p class="text-lg">Deseja realmente excluir este espaço?</p>
        </div>

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancelar
            </button>

            <form id="delete_place_form" method="POST">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash-fill"></i> Excluir
                </button>
            </form>
        </div>

    </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/confirmationModal.js') }}"></script>
@endsection
