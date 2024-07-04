<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasTrained extends Model
{
    use HasFactory;

    protected $table = 'user_has_trained';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exercise_id',
        'user_id',
    ];
}
