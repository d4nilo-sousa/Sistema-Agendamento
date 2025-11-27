<?php

namespace App\Http\Controllers;

use App\Models\Scheduling;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Events\SchedulingCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class SchedulingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Define a data (pela URL ou hoje)
        $date = $request->query('date', now()->toDateString());
        
        // Formata para exibição bonita na view (ex: "Quarta-feira, 21 de Novembro")
        $dateCarbon = Carbon::parse($date)->locale('pt-BR');
        $dateFormatted = $dateCarbon->translatedFormat('l, d \d\e F \d\e Y');

        // 2. Busca Laboratórios
        $places = Place::orderBy('name')->get(['id', 'name']);

        // 3. Busca Agendamentos EXISTENTES nessa data
        $schedules = Scheduling::with(['user:id,name'])
            ->whereDate('date', $date)
            ->get()
            // Cria uma chave única para busca rápida: "aula-labID"
            ->keyBy(fn($s) => $s->class_number . '-' . $s->place_id);

        // 4. Aulas (1 a 7)
        $classNumbers = range(1, 7);

        return view('Scheduling.index', [
            'schedules'    => $schedules,
            'places'       => $places,
            'classNumbers' => $classNumbers,
            'currentDate'  => $date,
            'dateFormatted'=> $dateFormatted,
            'nextDay'      => $dateCarbon->copy()->addDay()->toDateString(),
            'prevDay'      => $dateCarbon->copy()->subDay()->toDateString(),
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validação dos dados recebidos
        $validated = $request->validate([
            'date'         => 'required|date',
            'class_number' => 'required|integer|min:1|max:7',
            'place_id'     => 'required|exists:places,id',
            'shift'        => 'required|string',
        ]);

        // 2. Regra de Negócio: Verificar se já existe agendamento
        // SELECT * FROM schedulings WHERE date = ? AND class = ? AND place = ?
        $exists = Scheduling::where('date', $validated['date'])
            ->where('class_number', $validated['class_number'])
            ->where('place_id', $validated['place_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Este horário já foi reservado por outro usuário.'
            ], 409); // 409 Conflict
        }

        try {
            // 3. Criação
            $scheduling = Scheduling::create([
                'date'         => $validated['date'],
                'class_number' => $validated['class_number'],
                'shift'        => $validated['shift'],
                'place_id'     => $validated['place_id'],
                'user_id'      => Auth::id(), // Pega o ID do usuário logado seguramente
            ]);

            // 4. Evento (Websocket)
            event(new SchedulingCreated($scheduling));

            return response()->json([
                'success' => true, 
                'message' => 'Agendamento realizado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Erro interno ao salvar.'
            ], 500);
        }
    }

    /**
     * Remove o agendamento especificado do storage.
     */
    public function destroy(Scheduling $scheduling)
    {
        // 1. Autorização: Verifica se o usuário logado é o dono do agendamento
        if ($scheduling->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Você não tem permissão para cancelar este agendamento.'
            ], 403); // 403 Forbidden
        }

        try {
            $scheduling->delete();
            
            // Aqui você pode disparar um evento para o Laravel Echo (ex: SchedulingDeleted)
            // event(new SchedulingDeleted($scheduling)); 
            
            return response()->json([
                'success' => true, 
                'message' => 'Agendamento cancelado com sucesso.',
                'schedule' => $scheduling // Retorna o objeto para uso no front (opcional)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Erro interno ao cancelar o agendamento.'
            ], 500);
        }
    }
}