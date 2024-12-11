<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseDay extends Model
{
    use HasFactory;

    // Definir o nome correto da tabela
    protected $table = 'exercise_days';

    // Permitir a atribuição em massa para os campos
    protected $fillable = [
        'exercise_id',
        'nome',
        'series',
        'repeticoes',
        'peso',
    ];
}
