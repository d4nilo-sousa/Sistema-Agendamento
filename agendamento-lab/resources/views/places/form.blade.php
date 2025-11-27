@extends('layout')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Título da página --}}
    <div class="flex items-center gap-3 mb-6">
        <i class="bi bi-door-open-fill text-purple-600 text-4xl"></i>
        <h1 class="text-3xl font-bold text-purple-700">
            @isset($place)
                Editar espaço
            @else
                Novo espaço
            @endisset
        </h1>
    </div>

    {{-- Card do formulário --}}
    <div class="bg-white shadow-lg rounded-2xl p-6 border border-purple-200">

        <form action="" method="POST" class="space-y-5">
            @isset($place)
                @method('put')
            @endisset

            @csrf

            {{-- Nome --}}
            <div>
                <label class="font-medium text-gray-700 flex items-center gap-2 mb-1">
                    <i class="bi bi-tag-fill text-purple-600"></i> Nome do Espaço
                </label>
                <input
                    type="text"
                    name="name"
                    class="form-control rounded-xl border-purple-300 focus:ring-2 focus:ring-purple-500"
                    placeholder="Ex: Laboratório de Informática"
                    value="{{ $place->name ?? '' }}"
                    required
                >
            </div>

            {{-- Capacidade --}}
            <div>
                <label class="font-medium text-gray-700 flex items-center gap-2 mb-1">
                    <i class="bi bi-people-fill text-purple-600"></i> Capacidade
                </label>
                <input
                    type="number"
                    name="capacity"
                    class="form-control rounded-xl border-purple-300 focus:ring-2 focus:ring-purple-500"
                    placeholder="Ex: 30"
                    value="{{ $place->capacity ?? '' }}"
                    required
                >
            </div>

            {{-- Descrição --}}
            <div>
                <label class="font-medium text-gray-700 flex items-center gap-2 mb-1">
                    <i class="bi bi-card-text text-purple-600"></i> Descrição
                </label>
                <textarea
                    name="description"
                    rows="4"
                    class="form-control rounded-xl border-purple-300 focus:ring-2 focus:ring-purple-500"
                    placeholder="Descreva detalhes sobre o espaço..."
                >{{ $place->description ?? '' }}</textarea>
            </div>

            {{-- Botões --}}
            <div class="flex justify-end gap-3 pt-4">
                <button type="reset"
                    class="px-4 py-2 rounded-xl border border-purple-300 text-purple-700 hover:bg-purple-50 transition">
                    <i class="bi bi-arrow-counterclockwise"></i> Limpar
                </button>

                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-purple-600 text-white hover:bg-purple-700 shadow-md transition">
                    <i class="bi bi-check2-circle"></i> Salvar
                </button>
            </div>
        </form>
    </div>

</div>


@endsection

@section('scripts')
    <script src="{{ asset('js/toast.js') }}"></script>
@endsection
