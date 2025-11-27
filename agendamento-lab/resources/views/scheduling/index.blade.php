@extends('layout')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="bg-purple-700 rounded-t-xl shadow-lg p-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">
                <i class="fa-solid fa-calendar-days mr-2"></i> Reservas de Laboratório
            </h1>
            <p class="text-purple-200 text-sm mt-1">Gerencie os espaços da escola de forma simples.</p>
        </div>
        
        <div class="flex items-center space-x-3 bg-purple-800 p-2 rounded-lg bg-opacity-50">
            {{-- O link 'Anterior' é desativado se a data atual for a de hoje --}}
            @if ($currentDate > now()->toDateString())
                <a href="{{ route('scheduling.index', ['date' => $prevDay]) }}" class="text-white hover:bg-purple-600 p-2 rounded-full transition" title="Dia Anterior">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            @else
                {{-- Botão desativado para o dia anterior se for hoje --}}
                <span class="text-gray-400 p-2 rounded-full cursor-not-allowed opacity-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </span>
            @endif
            
            <div class="text-center">
                {{-- LIMITAÇÃO DE DATA: min="{{ now()->toDateString() }}" --}}
                <input type="date" id="date-picker" value="{{ $currentDate }}" 
                    min="{{ now()->toDateString() }}" 
                    class="bg-white text-gray-800 text-sm font-semibold rounded-md border-0 py-1.5 px-3 focus:ring-2 focus:ring-purple-400 cursor-pointer text-center">
                <div class="text-xs text-purple-200 mt-1 uppercase font-bold tracking-wider">{{ $dateFormatted }}</div>
            </div>

            <a href="{{ route('scheduling.index', ['date' => $nextDay]) }}" class="text-white hover:bg-purple-600 p-2 rounded-full transition" title="Próximo Dia">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <div class="bg-white shadow-xl rounded-b-xl overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-sm uppercase font-bold tracking-wider">
                        <th class="p-4 border-r border-gray-100 w-20">Aula</th>
                        @forelse ($places as $place)
                            <th class="p-4 border-r border-gray-100 min-w-[150px]">{{ $place->name }}</th>
                        @empty
                            <th class="p-4 text-red-500">Nenhum laboratório cadastrado</th>
                        @endforelse
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($classNumbers as $class)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="p-4 font-bold text-gray-400 border-r border-gray-100 bg-gray-50">
                                {{ $class }}º
                            </td>

                            @foreach ($places as $place)
                                @php
                                    // Verifica se existe agendamento para essa célula (Aula x Lab)
                                    $key = $class . '-' . $place->id;
                                    $schedule = $schedules[$key] ?? null;
                                    $isTodayOrFuture = \Carbon\Carbon::parse($currentDate)->gte(\Carbon\Carbon::today());
                                @endphp

                                <td class="p-3 border-r border-gray-100 align-middle">
                                    @if ($schedule)
                                        <div class="flex flex-col items-center justify-center p-2 bg-red-50 border border-red-100 rounded-lg shadow-sm">
                                            <span class="text-xs font-bold text-red-600 uppercase mb-1">Reservado</span>
                                            <div class="flex items-center space-x-1 text-gray-700 font-medium text-sm">
                                                <svg class="w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                                <span>{{ $schedule->user->name ?? 'Usuário' }}</span>
                                            </div>
                                            
                                            {{-- BOTÃO CANCELAR: Apenas se for o dono E a data for hoje ou futura --}}
                                            @if ($schedule->user_id === Auth::id() && $isTodayOrFuture) 
                                                <button 
                                                    class="btn-cancel-schedule mt-2 text-xs font-semibold text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md transition"
                                                    data-scheduling-id="{{ $schedule->id }}"
                                                    title="Cancelar Agendamento">
                                                    <i class="fa-solid fa-trash mr-1"></i> Cancelar
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        @if ($isTodayOrFuture)
                                            <button 
                                                class="btn-schedule w-full group flex items-center justify-center space-x-2 py-2 px-4 rounded-lg border border-purple-200 text-purple-600 font-semibold hover:bg-purple-600 hover:text-white hover:border-purple-600 hover:shadow-md transition-all duration-200"
                                                data-place-id="{{ $place->id }}"
                                                data-class-number="{{ $class }}"
                                                data-shift="MANHA"
                                            >
                                                <span class="group-hover:hidden">Disponível</span>
                                                <span class="hidden group-hover:inline">Agendar <i class="fa-solid fa-plus ml-1"></i></span>
                                            </button>
                                        @else
                                            <span class="text-sm text-gray-400">Data Passada</span>
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        // 1. Mudança de Data (Recarrega a página)
        const dateInput = document.getElementById('date-picker');
        dateInput.addEventListener('change', function() {
            window.location.href = "{{ route('scheduling.index') }}?date=" + this.value;
        });

        // FUNÇÃO DE TRATAMENTO DE REQUISIÇÃO (STORE)
        const scheduleButtons = document.querySelectorAll('.btn-schedule');
        scheduleButtons.forEach(button => {
            button.addEventListener('click', function(e){
                e.preventDefault();

                // 1. Estado de loading
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processando...';
                this.disabled = true;
                this.classList.add('opacity-75', 'cursor-not-allowed');

                const schedulingData = {
                    date: dateInput.value,
                    class_number: this.dataset.classNumber,
                    shift: this.dataset.shift,
                    place_id: this.dataset.placeId,
                };

                // 2. Requisição FETCH
                fetch("{{ route('scheduling.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(schedulingData)
                })
                .then(response => {
                    // *** TRATAMENTO DE ERRO ROBUSTO (422, 409, 500) ***
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            let errorMessage = 'Erro desconhecido na requisição.';
                            
                            // Tenta pegar a mensagem do nosso erro customizado (409) ou Erro 500
                            if (errorData.message) {
                                errorMessage = errorData.message;
                            } 
                            // Tenta pegar o primeiro erro de validação do Laravel (422)
                            else if (errorData.errors && Object.keys(errorData.errors).length > 0) {
                                // Pega o primeiro erro do primeiro campo (ex: 'date' -> ['O campo data é obrigatório'])
                                const firstKey = Object.keys(errorData.errors)[0];
                                errorMessage = errorData.errors[firstKey][0];
                            }
                            
                            throw new Error(errorMessage);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // 3. Sucesso
                    alert(data.message || "Agendado com sucesso!");
                    window.location.reload(); 
                })
                .catch(error => {
                    // 4. Falha (Erros de rede ou erros lançados acima)
                    console.error('Erro:', error);
                    alert('Falha no agendamento: ' + error.message);
                    
                    // Reverte o estado de loading
                    this.innerHTML = originalText;
                    this.disabled = false;
                    this.classList.remove('opacity-75', 'cursor-not-allowed');
                });
            });
        });

        // FUNÇÃO DE TRATAMENTO DE REQUISIÇÃO (DESTROY)
        const cancelButtons = document.querySelectorAll('.btn-cancel-schedule');
        cancelButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const schedulingId = this.dataset.schedulingId;
                
                if (!confirm('Você realmente deseja cancelar este agendamento?')) {
                    return;
                }

                // Estado de loading
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Cancelando...';
                this.disabled = true;
                this.classList.add('opacity-75', 'cursor-not-allowed');

                // Requisição DELETE
                fetch(`/scheduling/${schedulingId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            let errorMessage = errorData.message || 'Erro desconhecido ao cancelar.';
                            throw new Error(errorMessage);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message || "Agendamento cancelado com sucesso.");
                    window.location.reload(); 
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Falha no cancelamento: ' + error.message);

                    // Reverte o estado de loading
                    this.innerHTML = originalText;
                    this.disabled = false;
                    this.classList.remove('opacity-75', 'cursor-not-allowed');
                });
            });
        });

        // 4. Websocket (Echo) - Mantido
        if (typeof window.Echo !== 'undefined') {
            window.Echo.channel('schedules')
                .listen('.scheduling.created', (e) => {
                    // Verifica se o agendamento recebido é para a data que estamos vendo
                    if (e.schedule.date === dateInput.value) {
                        // Encontra o botão correspondente
                        const btn = document.querySelector(`button[data-place-id="${e.schedule.place_id}"][data-class-number="${e.schedule.class_number}"]`);
                        
                        if (btn) {
                            const td = btn.parentElement;
                            // Substitui o botão pelo card de "Reservado"
                            td.innerHTML = `
                                <div class="flex flex-col items-center justify-center p-2 bg-red-50 border border-red-100 rounded-lg shadow-sm animate-pulse">
                                    <span class="text-xs font-bold text-red-600 uppercase mb-1">Novo!</span>
                                    <div class="flex items-center space-x-1 text-gray-700 font-medium text-sm">
                                        <span>Ocupado</span>
                                    </div>
                                </div>
                            `;
                        }
                    }
                });
        }
    });
</script>
@endsection