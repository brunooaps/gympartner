<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Controllers\Controller;
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
    public function show($id)
    {
        $userId = Auth::user()->id;
        $exercise = Exercise::where('user_id', '=', $userId)->findOrFail($id);
        return view('exercises.show', compact('exercise'));
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
        $exercise = Exercise::findOrFail($id);
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

        $exercise = Exercise::findOrFail($id);
        $exercise->client_description = $request->client_description;
        $exercise->save();

        return redirect()->route('exercise.show', $id)->with('status', 'Description added successfully!');
    }
}
