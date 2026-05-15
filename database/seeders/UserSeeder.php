<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@estate.local',
            'password' => 'adminadmin',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Сотрудник',
            'email' => 'employee@estate.local',
            'password' => 'employee',
            'role' => 'employee',
            'email_verified_at' => now(),
        ]);
    }
}
