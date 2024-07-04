<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Payment;
use App\Models\TrainerHasUser;
use App\Models\User;
use App\Models\UserHasTrained;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Client User',
            'email' => 'client@mail.com',
        ]);

        User::factory()->create([
            'name' => 'Trainer User',
            'email' => 'trainer@mail.com',
        ]);

        Exercise::factory()->count(10)->create();
        
        Payment::factory()->count(2)->create();

        TrainerHasUser::factory()->create();
        UserHasTrained::factory()->count(10)->create();
        
    }
}
