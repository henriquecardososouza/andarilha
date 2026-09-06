<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => config('auth.default_user.email')
        ], [
            'name' => 'Usuário padrão',
            'password' => config('auth.default_user.password'),
            'email_verified_at' => now()
        ]);
    }
}
