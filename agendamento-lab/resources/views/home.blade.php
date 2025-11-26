@extends('layout')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center py-10">
    <div class="bg-white shadow-xl rounded-2xl p-10 border border-purple-100 max-w-3xl text-center">
        <h2 class="text-4xl font-bold text-purple-700 mb-4">Bem-vindo ao Sistema de Agendamento de Laboratórios</h2>
        <p class="text-gray-600 text-lg leading-relaxed mb-6">
            Este sistema foi desenvolvido para facilitar a organização, reserva e gerenciamento de espaços e laboratórios.
            Aqui, você pode registrar novos ambientes, visualizar seus espaços cadastrados e realizar agendamentos de forma prática e rápida.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <a href="/places" class="bg-purple-600 text-white py-4 rounded-xl shadow hover:bg-purple-700 transition flex flex-col items-center">
                <i class="ri-folder-2-line text-3xl mb-1"></i>
                Meus Espaços
            </a>
            <a href="/places/new" class="bg-purple-600 text-white py-4 rounded-xl shadow hover:bg-purple-700 transition flex flex-col items-center">
                <i class="ri-add-circle-line text-3xl mb-1"></i>
                Cadastrar Espaço
            </a>
            <a href="/scheduling" class="bg-purple-600 text-white py-4 rounded-xl shadow hover:bg-purple-700 transition flex flex-col items-center">
                <i class="ri-calendar-check-line text-3xl mb-1"></i>
                Agendamentos
            </a>
        </div>

        <p class="text-sm text-gray-500 mt-6">Sistema criado para melhorar a administração dos laboratórios da instituição.</p>
    </div>
</div>
@endsection
