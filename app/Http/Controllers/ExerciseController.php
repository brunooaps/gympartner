<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use App\Models\TrainerHasUser;
use App\Models\User;
use App\Models\UserHasExercise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Validate the incoming request data
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'days' => 'required|array|min:1', // Verifica se há pelo menos um dia selecionado
            'days.*' => 'required|string', // Cada dia deve ser uma string válida
            'descriptions' => 'required|array|min:1', // Verifica se há descrições associadas
            'descriptions.*' => 'required|string', // Cada descrição deve ser uma string válida
        ]);

        // Combinar os dias e as descrições
        $formattedDescription = "";
        foreach ($request->days as $index => $day) {
            $description = $request->descriptions[$index] ?? '';
            $formattedDescription .= "$day\n\"$description\"\n";
        }

        // Create a new exercise
        $exercise = new Exercise();
        $exercise->trainer_id = $request->trainer_id;
        $exercise->title = $request->title;
        $exercise->description = trim($formattedDescription); // Remove espaços extras

        // Save the exercise to the database
        $exercise->save();

        // Redirect to the exercises list or another appropriate page
        return redirect()->route('exercises')->with('success', 'Exercise created successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function assign($id)
    {
        $trainerId = Auth::user()->id;
        $usersByTrainer = TrainerHasUser::where("trainer_id", "=", $trainerId)->get();
        foreach ($usersByTrainer as $key => $value) {
            $users[$key] = User::find($value['user_id']);
        }
        $exercises = Exercise::where('id', '=', $id)->get();

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

        // Verificar se a descrição do exercício no banco é a mesma que a descrição no request
        if ($exercise->description === $request->input('description')) {
            // $saveUserHasExercise = new UserHasExercise();
            // $saveUserHasExercise->exercise_id = $exercise->id;
            // $saveUserHasExercise->user_id = $user->id;
            // $saveUserHasExercise->expiration_date = $request['expiration_date'];

            // $saveUserHasExercise->save();

            UserHasExercise::create([
                'user_id' => $user->id,
                'exercise_id' => $exercise->id,
                'expiration_date' => $expirationDate,
            ]);
        } else {

            $saveExercise = Exercise::create([
                'trainer_id' => Auth::user()->id,
                'title' => $exercise->title,
                'description' => $request['description'],
            ]);

            UserHasExercise::create([
                'user_id' => $user->id,
                'exercise_id' => $saveExercise->id,
                'expiration_date' => $expirationDate,
            ]);
            // $saveExercise = new Exercise();
            // $saveExercise = Auth::user()->id;
            // $saveExercise = $exercise->title;
            // $saveExercise = $exercise->description;
            // $saveExercise->save();

            // $saveUserHasExercise = new UserHasExercise();
            // $saveUserHasExercise->exercise_id = $saveExercise->id;
            // $saveUserHasExercise->user_id = $user->id;
            // $saveUserHasExercise->expiration_date = $request['expiration_date'];
            // $saveUserHasExercise->save();
        }

        // // Criar o relacionamento entre o usuário e o exercício
        // UserHasExercise::create([
        //     'user_id' => $user->id,
        //     'exercise_id' => $exerciseId,
        //     'done' => false,
        // ]);

        // Retornar a resposta, redirecionando para a página do usuário com uma mensagem de sucesso
        return redirect()->route('client.show', $user->id)->with('success', 'Exercises assigned successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userId = Auth::user()->id;

        // Tentar encontrar o exercício pelo ID
        $exercise = Exercise::findOrFail($id);

        // Verificar se o exercício está atribuído ao usuário atual
        $review = UserHasExercise::where('exercise_id', '=', $id)
            ->where('user_id', '=', $userId)
            ->first();

        // Processar a descrição do exercício para separar dias e descrições
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $descriptionByDays = [];
        if ($exercise->description) {
            // Normaliza as quebras de linha para o formato Unix
            $description = preg_replace("/\r\n|\r|\n/", "\n", $exercise->description);

            // Regex para capturar blocos de dias e descrições
            $pattern = "/(?<day>" . implode('|', $days) . ")\s*\n(.+?)(?=\s*\n(?:Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday|$))/s";
            if (preg_match_all($pattern, $description, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $day = $match['day'];
                    $content = trim($match[2]); // Descrição do dia
                    $descriptionByDays[$day] = $content;
                }
            }
        }

        $exerciseDetails = [
            'exercise' => $exercise,
            'review' => $review,
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
}
