<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Livro::factory()->count(20)->create()->each(function ($livro) {

            $autores = Autor::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $livro->autores()->attach($autores);
        });
    }
}
