<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ACCESS_LEVEL_CLIENT = 1;
    const ACCESS_LEVEL_TRAINER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'user_id');
    }

    public function trainerExercises()
    {
        return $this->hasMany(Exercise::class, 'trainer_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isClient()
    {
        return $this->access_level === self::ACCESS_LEVEL_CLIENT;
    }

    public function isTrainer()
    {
        return $this->access_level === self::ACCESS_LEVEL_TRAINER;
    }
}
