<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AutorSeeder::class,
            EditoraSeeder::class,
            LivroSeeder::class,
            RoleSeeder::class,
            AdminUserSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'andreteste',
            'email' => 'teste@example.com',
            'password' => Hash::make('andreteste'),
        ]);
        
    }
}
