<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {

            $table->id();
            $table->foreignId('requisicao_id')->constrained('requisicaos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');

            $table->tinyInteger('classificacao')->unsigned();
            $table->text('comentario');

            $table->enum('estado', ['suspenso', 'ativo', 'recusado'])->default('suspenso');
            $table->text('justificacao_recusada')->nullable();

            $table->timestamps();

            $table->index('estado');
            $table->unique(['requisicao_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
