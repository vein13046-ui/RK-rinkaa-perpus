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

\App\Models\User::firstOrCreate(
            ['email' => 'sarin@gmail.com'],
            [
                'name' => 'Sarin',
                'password' => \Illuminate\Support\Facades\Hash::make('11223344'),
                'role' => 'admin',
            ]
        );
    }
}
