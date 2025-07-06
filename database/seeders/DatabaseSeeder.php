<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Kristina',
            'surname' => 'Urboniene',
            'email' => 'k.urboniene@gmail.com',
            'profile_image' => null,
            'password' => Hash::make('kristina1477+'),
        ]);

        $admin->assignRole('admin');
    }
}
