<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\TrainerHasUser;
use App\Models\UserHasExercise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = User::findOrFail($id);
        $Userexercises = UserHasExercise::where('user_id', '=', $id)->get();
        if (!$Userexercises->isEmpty()) {
            foreach ($Userexercises as $exercise) {
                $exercises[] = Exercise::findOrFail($exercise->exercise_id);
                $reviews[] = UserHasExercise::where('exercise_id', '=', $exercise->exercise_id)->where('user_id', '=', $id)->first();
            }
        }

        $data = [
            'client' => $client,
            'exercises' => $exercises ?? null,
            'reviews' => $reviews ?? null
        ];
        return view('clients.show', compact(['data']));
    }

    /**
     * Display the specified resource.
     */
    public function showTrainer($id)
    {
        $exercise = Exercise::findOrFail($id);
        $usersExercise = UserHasExercise::where('exercise_id', '=', $id)->get();
        if (!$usersExercise->isEmpty()) {
            foreach ($usersExercise as $key => $value) {
                $clients[] = User::findOrFail($value->user_id);
                $reviews[] = UserHasExercise::where('user_id', '=', $clients[$key]->id)->first();
            }
        }

        $data = [
            'clients' => $clients ?? null,
            'exercise' => $exercise,
            'reviews' => $reviews ?? null
        ];

        return view('exercises.show-trainer', compact(['data']));
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
}
