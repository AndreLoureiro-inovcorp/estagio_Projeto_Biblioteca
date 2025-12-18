<?php

namespace Database\Factories;

use App\Models\Editora;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn' => fake()->isbn13(),
            'nome' => fake()->words(3, true),
            'editora_id' => Editora::factory(),
            'bibliografia' => fake()->paragraph(3),
            'imagem_capa' => 'https://picsum.photos/200/300',
            'preco' => fake()->randomFloat(2, 10, 200),
        ];
    }
}
