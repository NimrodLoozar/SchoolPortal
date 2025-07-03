<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'role' => 'student',
        ]);

        User::factory()->create([
            'name' => 'Test Teacher',
            'email' => 'teacher@example.com',
            'role' => 'teacher',
        ]);

        User::factory()->create([
            'name' => 'Test Schedule Admin',
            'email' => 'schedule_admin@example.com',
            'role' => 'schedule_admin',
        ]);

        User::factory()->create([
            'name' => 'Test Owner',
            'email' => 'owner@example.com',
            'role' => 'owner',
        ]);
    }
}
