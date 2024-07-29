<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainerController;
use App\Http\Middleware\CheckAccessLevel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/exercises', [HomeController::class, 'index'])->name('exercises');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/exercise/{id}', [ExerciseController::class, 'show'])->name('exercise.show');
    Route::post('/exercise/{id}/done', [ExerciseController::class, 'markAsDone'])->name('exercise.markAsDone');
    Route::post('/exercise/{id}/add-description', [ExerciseController::class, 'addDescription'])->name('exercise.addDescription');
});

Route::middleware(['auth', CheckAccessLevel::class])->group(function () {
    Route::get('/dashboard-trainer', [TrainerController::class, 'index'])->name('client.index');
    Route::get('/clients', [TrainerController::class, 'create'])->name('client.create');
    Route::get('/client/{id}', [TrainerController::class, 'show'])->name('client.show');
    Route::get('/exercise/trainer/{id}', [TrainerController::class, 'showTrainer'])->name('exercise.show-trainer');
    Route::get('/exercise/assign/{id}', [ExerciseController::class, 'assign'])->name('exercise.assign');
    Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercise.create');
    Route::post('/exercise/store', [ExerciseController::class, 'store'])->name('exercise.store');
    Route::post('/client', [TrainerController::class, 'store'])->name('client.store');
    Route::post('/client/{id}', [TrainerController::class, 'edit'])->name('client.edit');
    Route::put('/client/{id}', [TrainerController::class, 'update'])->name('client.update');
    Route::delete('/client/{id}', [TrainerController::class, 'destroy'])->name('client.destroy');
    Route::post('/exercise/assign-to-user/{id}', [ExerciseController::class, 'assignToUser'])->name('exercise.assignToUser');
    // Route::put('/exercise/{id}', [ExerciseController::class, 'update'])->name('exercise.update');
});

require __DIR__.'/auth.php';
