<?php

namespace Database\Seeders\CustomSeeder;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

return new class extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'surname' => 'adminov',
            'email' => 'admin@admin',
            'password' => Hash::make('admin'),
            'user_role_id' => UserRole::query()->where('id', '3')->first(),
        ]);
        User::factory()->create([
            'name' => 'admin',
            'surname' => 'adminov',
            'email' => 'admin2@admin',
            'password' => Hash::make('admin2'),
            'user_role_id' => UserRole::query()->where('id', '3')->first(),
        ]);
    }
};
