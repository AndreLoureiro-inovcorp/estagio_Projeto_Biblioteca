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
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->text('isbn');
            $table->string('nome');
            $table->foreignId('editora_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('bibliografia')->nullable();
            $table->text('imagem_capa')->nullable();
            $table->boolean('disponivel')->default(true);
            $table->decimal('preco', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
