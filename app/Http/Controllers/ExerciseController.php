<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\TrainerHasUser;
use App\Models\User;
use App\Models\UserHasExercise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exercises.create');
    }

    /**
     * Store a newly created exercise in storage.
     */
    public function store(Request $request)
    {
        // Validar os dados de entrada
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'days_data' => 'required|string', // Verifica se os dados de dias foram passados como string JSON
        ]);

        // Decodificar o JSON para um array
        $daysData = json_decode($request->days_data, true);

        // Verificar se a decodificação foi bem-sucedida
        if ($daysData === null) {
            return redirect()->back()->with('error', 'Formato de dados de dias inválido.');
        }

        // Criar um novo exercício
        $exercise = new Exercise();
        $exercise->trainer_id = $request->trainer_id;
        $exercise->title = $request->title;

        // Salvar o exercício no banco de dados
        $exercise->save();

        // Inserir os dados dos dias na tabela exercise_days
        foreach ($daysData as $day => $exercises) {
            foreach ($exercises as $data) {
                DB::table('exercise_days')->insert([
                    'exercise_id' => $exercise->id,
                    'dia' => $day,  // Adiciona o dia correspondente (Segunda, Terça, etc.)
                    'nome' => $data['nome'] ?? null,
                    'series' => $data['series'] ?? null,
                    'repeticoes' => $data['repeticoes'] ?? null,
                    'peso' => $data['peso'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Redirecionar com mensagem de sucesso
        return redirect()->route('exercises')->with('success', 'Exercício criado com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function assign($id)
    {
        $trainerId = Auth::user()->id;
        $usersByTrainer = TrainerHasUser::where("trainer_id", "=", $trainerId)->get();
        if (isset($usersByTrainer[0])) {
            foreach ($usersByTrainer as $key => $value) {
                $users[$key] = User::find($value['user_id']);
            }
        }
        else {
            $users = null;
        }

        $exercises = Exercise::where('trainer_id', '=', $trainerId)->get();

        return view('exercises.assign', compact(['users', 'exercises']));
    }

    /**
     * Assign selected exercises to a user
     */
    public function assignToUser(Request $request)
    {
        // Recuperar o ID do usuário e os IDs dos exercícios do request
        $user = User::findOrFail($request['user_id']);

        // Buscar o exercício no banco
        $exercise = Exercise::findOrFail($request['exercise_id']);

        $expirationDate = Carbon::parse($request['expiration_date'])->startOfDay();

        UserHasExercise::create([
            'user_id' => $user->id,
            'exercise_id' => $exercise->id,
            'expiration_date' => $expirationDate,
        ]);

        // Retornar a resposta, redirecionando para a página do usuário com uma mensagem de sucesso
        return redirect()->route('client.show', $user->id)->with('success', 'Exercises assigned successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Recupera o ID do usuário autenticado
        $userId = Auth::user()->id;

        // Tentar encontrar o exercício pelo ID
        $exercise = Exercise::findOrFail($id);

        // Recuperar os chats relacionados ao exercício, incluindo o nome do usuário associado
        $chats = Chat::where('exercise_id', $id)
            ->with('user') // Certifique-se que a relação está configurada na Model
            ->orderBy('created_at', 'asc')
            ->get();


        // Processar a descrição do exercício para separar dias e descrições
        $days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        $descriptionByDays = [];
        if ($exercise->description) {
            // Normaliza as quebras de linha para o formato Unix
            $description = preg_replace("/\r\n|\r|\n/", "\n", $exercise->description);

            // Regex para capturar blocos de dias e descrições
            $pattern = "/(?<day>" . implode('|', $days) . ")\s*\n(.+?)(?=\s*\n(?:Segunda|Terça|Quarta|Quinta|Sexta|Sábado|Domingo|$))/s";
            if (preg_match_all($pattern, $description, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $day = $match['day'];
                    $content = trim($match[2]); // Descrição do dia
                    $descriptionByDays[$day] = $content;
                }
            }
        }

        // Montar os detalhes do exercício
        $exerciseDetails = [
            'exercise' => $exercise,
            'chats' => $chats,
            'descriptionByDays' => $descriptionByDays,
        ];

        return view('exercises.show', compact('exerciseDetails'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exercise $exercise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        //
    }


    /**
     * Mark the exercise as done.
     */
    public function markAsDone($id)
    {
        $userId = Auth::user()->id;
        $exercise = UserHasExercise::where('exercise_id', '=', $id)->where('user_id', '=', $userId)->first();
        $exercise->done = true;
        $exercise->done_at = today();
        $exercise->save();

        return redirect()->route('exercise.show', $id)->with('status', 'Exercise marked as done!');
    }

    public function addDescription(Request $request, $id)
    {
        $request->validate([
            'client_description' => 'required|string|max:1000',
        ]);

        $userId = Auth::user()->id;
        $exercise = UserHasExercise::where('exercise_id', '=', $id)->where('user_id', '=', $userId)->first();
        $exercise->review = $request->client_description;
        $exercise->save();

        return redirect()->route('exercise.show', $id)->with('status', 'Description added successfully!');
    }

    public function storeChat(Request $request)
    {
        // Validar os dados recebidos
        $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'commentary' => 'required|string|max:1000',
        ]);

        // Obter o usuário atual
        $user = Auth::user();

        // Determinar os dados do chat com base no nível de acesso
        $chatData = [
            'exercise_id' => $request->exercise_id,
            'commentary' => $request->commentary, // Corrigido para usar o nome correto do campo
        ];
        if ($user->access_level === 'trainer') {
            $chatData['trainer_id'] = $user->id;
        } elseif ($user->access_level === 'client') {
            $chatData['user_id'] = $user->id;
        } else {
            return back()->withErrors(['access_level' => 'Invalid access level']);
        }

        Log::info($chatData);

        // Criar o registro diretamente
        Chat::create($chatData);

        // Retornar à mesma página
        return back()->with('success', 'Comment successfully added');
    }
}
