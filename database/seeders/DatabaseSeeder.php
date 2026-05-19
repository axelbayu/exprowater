<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ✅ field 'name' sesuai dengan User model & migration
        User::factory()->create([
            'name'     => 'Axel Bayu',
            'email'    => 'axelbayu@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}