<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Payment;
use App\Models\TrainerHasUser;
use App\Models\User;
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
            'access_level' => 'client'
        ]);

        User::factory()->create([
            'name' => 'Trainer User',
            'email' => 'trainer@mail.com',
            'access_level' => 'trainer'
        ]);

        Exercise::factory()->count(10)->create();
        
        Payment::factory()->count(2)->create();

        TrainerHasUser::factory()->create();
    }
}
