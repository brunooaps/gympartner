<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExerciseDay;
use App\Models\TrainerHasUser;
use App\Models\UserHasExercise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainerId = Auth::user()->id;
        $userIds = TrainerHasUser::where('trainer_id', $trainerId)->pluck('user_id');

        $clients = User::whereIn('id', $userIds)->get();

        // Gerar um hash para o id de cada cliente
        $clients->transform(function ($client) {
            $client->hash_id = base64_encode($client->id); // Gerando o hash para o id
            return $client;
        });

        return view('dashboard-trainer', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'access_level' => 'client',
            'password' => Hash::make($request->email),
        ]);

        TrainerHasUser::create([
            'trainer_id' => Auth::user()->id,
            'user_id' => $client->id
        ]);

        return redirect()->route('client.index')->with('success', 'Client created successfully');
    }

    public function show($hash)
    {
        $trainerId = Auth::user()->id;
        $decodedId = base64_decode($hash);
        if (count(TrainerHasUser::where('trainer_id', $trainerId)->where('user_id', $decodedId)->get()) > 0) {
            $client = User::findOrFail($decodedId);
            $Userexercises = UserHasExercise::where('user_id', '=', $decodedId)->get();
            $exercises = [];
            $reviews = [];
            $exercisesByDay = [];

            if (!$Userexercises->isEmpty()) {
                foreach ($Userexercises as $exercise) {
                    $exerciseData = Exercise::findOrFail($exercise->exercise_id);
                    $exercises[] = $exerciseData;
                    $review = UserHasExercise::where('exercise_id', '=', $exercise->exercise_id)
                        ->where('user_id', '=', $decodedId)
                        ->first();
                    $reviews[] = $review;

                    // Separando os exercícios por dia
                    $expirationDate = \Carbon\Carbon::parse($review->expiration_date);
                    $dayKey = $expirationDate->format('Y-m-d'); // Usa a data para agrupar

                    if (!isset($exercisesByDay[$dayKey])) {
                        $exercisesByDay[$dayKey] = [];
                    }

                    $exercisesByDay[$dayKey][] = [
                        'exercise' => $exerciseData,
                        'review' => $review
                    ];
                }
            }

            $data = [
                'client' => $client,
                'exercisesByDay' => $exercisesByDay,
            ];

            return view('clients.show', compact('data'));
        }
        return redirect()->back();
    }

    public function showTrainer($hash)
    {

        $decodedId = base64_decode($hash);
        $trainerId = Auth::user()->id;

        if (count(Exercise::where('trainer_id', $trainerId)->where('id', $decodedId)->get()) > 0) {
            // Buscar o exercício
            $exercise = Exercise::findOrFail($decodedId);

            // Buscar os dias e dados relacionados ao exercício
            $exerciseDays = ExerciseDay::where('exercise_id', $decodedId)->get();

            // Definir os dias da semana
            $daysOfWeek = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];

            // Organizar os dados por dia da semana
            $descriptionByDays = array_fill_keys($daysOfWeek, []);
            foreach ($exerciseDays as $day) {
                $descriptionByDays[$day->dia][] = [
                    'nome' => $day->nome,
                    'series' => $day->series,
                    'repeticoes' => $day->repeticoes,
                    'peso' => $day->peso,
                ];
            }

            // Obter os usuários vinculados ao exercício
            $usersExercise = UserHasExercise::where('exercise_id', '=', $decodedId)->get();

            $clients = [];
            if (!$usersExercise->isEmpty()) {
                foreach ($usersExercise as $value) {
                    $client = User::find($value->user_id);
                    if ($client) {
                        $clients[] = $client;
                    }
                }
            }

            $data = [
                'clients' => $clients ?: null,
                'exercise' => $exercise,
                'descriptionByDays' => $descriptionByDays,
            ];

            return view('exercises.show-trainer', compact('data'));
        }
        return redirect()->back();
    }

    /**
     * Organiza a descrição do exercício nos dias da semana.
     *
     * @param string $description
     * @return array
     */
    private function organizeDescriptionByDays($description)
    {
        $days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
        $organized = [];

        // Normaliza as quebras de linha para o formato Unix
        $description = preg_replace("/\r\n|\r|\n/", "\n", $description);
        // Monta a regex para capturar os blocos entre os dias
        // Usamos \s*\n? para garantir que podemos pegar o final da string (sem exigir uma nova linha após o último dia)
        $pattern = "/(?<day>" . implode('|', $days) . ")\s*\n(.+?)(?=\s*\n(?:Segunda|Terça|Quarta|Quinta|Sexta|Sábado|Domingo|$))/s";

        if (preg_match_all($pattern, $description, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $day = $match['day'];
                Log::info("Dia: " . $day);  // Log para verificar o dia
                $content = trim($match[2]);  // Conteúdo após o nome do dia
                $organized[$day] = $content;
            }
        }

        return $organized;
    }



    /**
     * Assign an exercise to a user
     */
    public function assign($id)
    {
        $trainerId = Auth::user()->id;
        $user = User::find($id);
        $exercises = Exercise::where('trainer_id', '=', $trainerId)->get();

        return view('exercises.assign', compact(['user', 'exercises']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function removeExercise($clientId, $exerciseId)
    {
        $exercise = UserHasExercise::where("user_id", "=", $clientId)->where("exercise_id", "=", $exerciseId)->delete();

        return back()->with('message', 'Exercise removed successfully');
    }
}
