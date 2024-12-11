<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trainer_id',
        'user_id',
        'title',
        'description',
    ];

    /**
     * Definir a relação com a tabela exercise_days.
     * Um exercício pode ter vários ExerciseDays.
     */
    public function exerciseDays()
    {
        return $this->hasMany(ExerciseDay::class);
    }

    /**
     * Apagar os exercise_days quando o exercício for deletado.
     */
    protected static function booted()
    {
        static::deleting(function ($exercise) {
            // Apagar os registros associados de exercise_days
            $exercise->exerciseDays()->delete();
        });
    }
}
