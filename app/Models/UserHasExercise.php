<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasExercise extends Model
{
    use HasFactory;

    protected $table = 'user_has_exercise';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exercise_id',
        'user_id',
        'review',
        'done',
        'done_at',
        'do_again_every'
    ];
}
