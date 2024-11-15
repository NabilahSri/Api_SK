<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'nisn' => '0000',
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('smkypc2024'),
        ]);
    }
}
