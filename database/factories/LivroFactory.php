<?php

namespace Database\Factories;

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
            'nome' => fake()->sentence(3),
            'editora_id' => \App\Models\Editora::factory(),
            'bibliografia' => fake()->paragraph(3),
            'imagem_capa' => fake()->imageUrl(300, 400, 'books', true, 'livro'),
            'preco' => fake()->randomFloat(2, 10, 200),
        ];
    }
}
