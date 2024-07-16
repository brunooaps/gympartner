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
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/exercise/{id}', [ExerciseController::class, 'show'])->name('exercise.show');
    Route::put('/exercise/{id}/done', [ExerciseController::class, 'markAsDone'])->name('exercise.markAsDone');
    Route::post('/exercise/{id}/add-description', [ExerciseController::class, 'addDescription'])->name('exercise.addDescription');
});

Route::middleware(['auth', CheckAccessLevel::class])->group(function () {
    Route::get('/dashboard-trainer', [TrainerController::class, 'index'])->name('dashboard-trainer');
    Route::post('/client', [TrainerController::class, 'create'])->name('client.create');
    Route::put('/client/{id}', [TrainerController::class, 'update'])->name('client.update');
    Route::post('/exercise', [ExerciseController::class, 'create'])->name('exercise.create');
    Route::post('/exerciseAttribute', [ExerciseController::class, 'attribute'])->name('exercise.attribute');
    Route::put('/exercise/{id}', [ExerciseController::class, 'update'])->name('exercise.update');
});

require __DIR__.'/auth.php';
