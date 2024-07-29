<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserHasExercise;
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
            'description' => 'required|string',
        ]);

        // Create a new exercise
        $exercise = new Exercise();
        $exercise->trainer_id = $request->trainer_id;
        $exercise->title = $request->title;
        $exercise->description = $request->description;

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
        $user = User::findOrFail($id);
        $exercises = Exercise::where('trainer_id', '=', $trainerId)->get();

        return view('exercises.assign', compact(['user', 'exercises']));
    }

    /**
     * Assign selected exercises to a user
     */
    public function assignToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $exerciseIds = $request->input('exercises', []);

        foreach ($exerciseIds as $exerciseId) {
            UserHasExercise::create([
                'user_id' => $user->id,
                'exercise_id' => $exerciseId,
                'done' => false,
            ]);
        }

        return redirect()->route('client.show', $user->id)->with('success', 'Exercises assigned successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userId = Auth::user()->id;

        // Tentar encontrar o exercício pelo user_id
        $exercise = Exercise::find($id);
        $review = UserHasExercise::where('exercise_id', '=', $id)->where('user_id', '=', $userId)->first();

        $exerciseDetails = [
            'exercise' => $exercise,
            'review' => $review
        ];

        return view('exercises.show', compact(['exerciseDetails']));
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
