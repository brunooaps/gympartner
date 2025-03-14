<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\UserHasExercise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->access_level == 'trainer') {
            $exercises = $user->trainerExercises;

            // Gerar um hash para o id de cada cliente
            $exercises->transform(function ($exercise) {
                $exercise->hash_id = base64_encode($exercise->id); // Gerando o hash para o id
                return $exercise;
            });

            return view('exercises', compact('exercises'));
        } else {
            $userExercises = $user->exercises;
        }
        if (count($userExercises) > 0) {
            foreach ($userExercises as $key => $userExercise) {
                $exercises[$key] = Exercise::find($userExercise->exercise_id);
                if ($userExercise->done && isset($userExercise->do_again_every)) {
                    $doneAt = Carbon::parse($userExercise->done_at);
                    $nextDueDate = $doneAt->copy()->addDays($userExercise->do_again_every);
                    $exercises[$key]->next_due_date = $nextDueDate->format('d/m/Y');
                }
            }

            // Convertendo para coleção antes de usar o transform
            $exercises = collect($exercises);  // Convertendo para uma coleção

            // Adicionando o hash_id para cada exercício
            $exercises->transform(function ($exercise) {
                $exercise->hash_id = base64_encode($exercise->id); // Gerando o hash para o id
                return $exercise;
            });

            return view('exercises', compact('exercises'));
        } else {
            return view('exercises');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
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
}
