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
            
            {{-- Botão Dia Anterior: Desativado se a data atual for a de hoje --}}
            @if ($currentDate > now()->toDateString())
                <a href="{{ route('scheduling.index', ['date' => $prevDay]) }}" class="text-white hover:bg-purple-600 p-2 rounded-full transition" title="Dia Anterior">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            @else
                <span class="text-gray-400 p-2 rounded-full cursor-not-allowed opacity-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </span>
            @endif
            
            <div class="text-center">
                {{-- Input de Data com restrição MIN para o dia atual --}}
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

{{-- ******************************************* --}}
{{-- MODAL DE CONFIRMAÇÃO DE AGENDAMENTO (STORE) --}}
{{-- ******************************************* --}}
<div id="schedule-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all duration-300 scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="flex items-center justify-between border-b pb-3 mb-4">
            <h3 id="modal-title" class="text-xl font-bold text-purple-700 flex items-center">
                <i class="fa-solid fa-calendar-check mr-2"></i> Confirmar Agendamento
            </h3>
            <button onclick="closeModal('schedule-modal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        
        <p class="text-gray-600 mb-6">
            Você está prestes a reservar o espaço <span id="modal-place-name" class="font-semibold text-purple-600"></span> para a <span id="modal-class-number" class="font-semibold text-purple-600"></span> aula do dia {{ $dateFormatted }}.
        </p>

        <input type="hidden" id="modal-hidden-place-id">
        <input type="hidden" id="modal-hidden-class-number">
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal('schedule-modal')" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                Cancelar
            </button>
            <button id="confirm-schedule-btn" class="px-5 py-2 rounded-lg bg-purple-600 text-white font-semibold hover:bg-purple-700 transition shadow-md">
                Agendar Agora
            </button>
        </div>
    </div>
</div>

{{-- *********************************************** --}}
{{-- MODAL DE CONFIRMAÇÃO DE CANCELAMENTO (DESTROY) --}}
{{-- *********************************************** --}}
<div id="cancel-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all duration-300 scale-95" role="dialog" aria-modal="true" aria-labelledby="modal-cancel-title">
        <div class="flex items-center justify-between border-b pb-3 mb-4">
            <h3 id="modal-cancel-title" class="text-xl font-bold text-red-600 flex items-center">
                <i class="fa-solid fa-trash-can mr-2"></i> Cancelar Agendamento
            </h3>
            <button onclick="closeModal('cancel-modal')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        
        <p class="text-gray-600 mb-6">
            Tem certeza que deseja <b>cancelar</b> esta reserva? Esta ação é irreversível e o horário ficará disponível para outros usuários.
        </p>

        <input type="hidden" id="modal-hidden-scheduling-id">
        
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal('cancel-modal')" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                Voltar
            </button>
            <button id="confirm-cancel-btn" class="px-5 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition shadow-md">
                Confirmar Cancelamento
            </button>
        </div>
    </div>
</div>

{{-- *********************************************** --}}
{{-- TOAST (Notificações Flutuantes) --}}
{{-- *********************************************** --}}
<div id="toast-container" class="fixed bottom-5 right-5 z-50 space-y-3">
    </div>


<script>
    // Variável global para armazenar o ID do timeout do Toast
    let toastTimeout;

    // Função utilitária para abrir e fechar modais
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Função para exibir o Toast (Notificação)
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        
        // Determina cores e ícones com base no tipo
        let bgColor, borderColor, iconHtml, title;
        if (type === 'success') {
            bgColor = 'bg-green-50';
            borderColor = 'border-green-400';
            iconHtml = '<i class="fa-solid fa-check-circle text-green-500"></i>';
            title = 'Sucesso!';
        } else if (type === 'error') {
            bgColor = 'bg-red-50';
            borderColor = 'border-red-400';
            iconHtml = '<i class="fa-solid fa-exclamation-triangle text-red-500"></i>';
            title = 'Erro!';
        } else { // Default warning/info
            bgColor = 'bg-yellow-50';
            borderColor = 'border-yellow-400';
            iconHtml = '<i class="fa-solid fa-info-circle text-yellow-500"></i>';
            title = 'Informação';
        }

        // HTML do Toast
        const toastHtml = `
            <div id="liveToast" class="flex items-center w-full max-w-xs p-4 text-gray-500 ${bgColor} rounded-lg shadow-lg border-l-4 ${borderColor} transition-transform transform translate-x-full duration-300" role="alert">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-6 h-6 rounded-full">
                    ${iconHtml}
                </div>
                <div class="ml-3 text-sm font-normal">
                    <p class="font-bold text-gray-800">${title}</p>
                    ${message}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-transparent text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="this.closest('#liveToast').remove()">
                    <span class="sr-only">Fechar</span>
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `;
        
        // Limpa o container e o timeout anterior (se houver)
        container.innerHTML = '';
        clearTimeout(toastTimeout);

        // Adiciona o Toast ao container
        container.insertAdjacentHTML('beforeend', toastHtml);
        const newToast = container.lastElementChild;

        // Animação de entrada
        setTimeout(() => {
            newToast.classList.remove('translate-x-full');
        }, 10);

        // Define o tempo para o Toast desaparecer
        toastTimeout = setTimeout(() => {
            // Animação de saída
            newToast.classList.add('translate-x-full');
            // Remove o elemento após a animação
            setTimeout(() => newToast.remove(), 300);
        }, 4000); // 4 segundos
    }

    document.addEventListener("DOMContentLoaded", function () {
        
        const dateInput = document.getElementById('date-picker');
        
        // 1. Mudança de Data (Recarrega a página)
        dateInput.addEventListener('change', function() {
            window.location.href = "{{ route('scheduling.index') }}?date=" + this.value;
        });

        // ==========================================================
        // 2. Lógica de ABERTURA DO MODAL DE AGENDAMENTO (.btn-schedule)
        // ==========================================================
        const scheduleButtons = document.querySelectorAll('.btn-schedule');
        const confirmScheduleBtn = document.getElementById('confirm-schedule-btn');
        
        scheduleButtons.forEach(button => {
            button.addEventListener('click', function(){
                document.getElementById('modal-place-name').textContent = this.closest('table').querySelector('thead th:nth-child(' + (this.closest('td').cellIndex + 1) + ')').textContent;
                document.getElementById('modal-class-number').textContent = this.dataset.classNumber + 'ª';
                document.getElementById('modal-hidden-place-id').value = this.dataset.placeId;
                document.getElementById('modal-hidden-class-number').value = this.dataset.classNumber;
                
                confirmScheduleBtn.onclick = null;
                confirmScheduleBtn.onclick = function() {
                    handleScheduleStore(button);
                };
                
                openModal('schedule-modal');
            });
        });

        // Função de requisição POST (Agendar)
        function handleScheduleStore(originalButton) {
            closeModal('schedule-modal');
            
            const originalText = originalButton.innerHTML;
            originalButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processando...';
            originalButton.disabled = true;
            originalButton.classList.add('opacity-75', 'cursor-not-allowed');

            const schedulingData = {
                date: dateInput.value,
                class_number: originalButton.dataset.classNumber,
                shift: originalButton.dataset.shift,
                place_id: originalButton.dataset.placeId,
            };

            fetch("{{ route('scheduling.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(schedulingData)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        let errorMessage = errorData.message || 'Erro desconhecido na requisição.';
                        if (errorData.errors && Object.keys(errorData.errors).length > 0) {
                            const firstKey = Object.keys(errorData.errors)[0];
                            errorMessage = errorData.errors[firstKey][0];
                        }
                        throw new Error(errorMessage);
                    });
                }
                return response.json();
            })
            .then(data => {
                // *** SUBSTITUIÇÃO DO ALERT() POR TOAST DE SUCESSO ***
                showToast(data.message || "Agendado com sucesso!", 'success');
                // Adiciona um pequeno delay antes de recarregar
                setTimeout(() => window.location.reload(), 500);
            })
            .catch(error => {
                console.error('Erro:', error);
                // *** SUBSTITUIÇÃO DO ALERT() POR TOAST DE ERRO ***
                showToast('Falha no agendamento: ' + error.message, 'error');
                
                // Reverte o estado de loading
                originalButton.innerHTML = originalText;
                originalButton.disabled = false;
                originalButton.classList.remove('opacity-75', 'cursor-not-allowed');
            });
        }


        // ==============================================================
        // 3. Lógica de ABERTURA DO MODAL DE CANCELAMENTO (.btn-cancel-schedule)
        // ==============================================================
        const cancelButtons = document.querySelectorAll('.btn-cancel-schedule');
        const confirmCancelBtn = document.getElementById('confirm-cancel-btn');

        cancelButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.getElementById('modal-hidden-scheduling-id').value = this.dataset.schedulingId;
                
                confirmCancelBtn.onclick = null;
                confirmCancelBtn.onclick = function() {
                    handleScheduleDestroy(button);
                };
                
                openModal('cancel-modal');
            });
        });

        // Função de requisição DELETE (Cancelar)
        function handleScheduleDestroy(originalButton) {
            closeModal('cancel-modal');
            
            const schedulingId = document.getElementById('modal-hidden-scheduling-id').value;

            const originalText = originalButton.innerHTML;
            originalButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Cancelando...';
            originalButton.disabled = true;
            originalButton.classList.add('opacity-75', 'cursor-not-allowed');

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
                // *** SUBSTITUIÇÃO DO ALERT() POR TOAST DE SUCESSO ***
                showToast(data.message || "Agendamento cancelado com sucesso.", 'success');
                // Adiciona um pequeno delay antes de recarregar
                setTimeout(() => window.location.reload(), 500); 
            })
            .catch(error => {
                console.error('Erro:', error);
                // *** SUBSTITUIÇÃO DO ALERT() POR TOAST DE ERRO ***
                showToast('Falha no cancelamento: ' + error.message, 'error');

                // Reverte o estado de loading
                originalButton.innerHTML = originalText;
                originalButton.disabled = false;
                originalButton.classList.remove('opacity-75', 'cursor-not-allowed');
            });
        }
        
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