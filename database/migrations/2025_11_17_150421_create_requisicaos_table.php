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
        Schema::create('requisicaos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_requesicao')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('livro_id')->constrained()->onDelete('restrict');
            $table->date('data_requisicao');
            $table->date('data_prevista_entrega');
            $table->date('data_entrega_real')->nullable();
            $table->enum('estado', ['ativa', 'entregue', 'atrasada'])->default('ativa');
            $table->string('foto_cidadao')->nullable();
            $table->boolean('reminder_enviado')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisicaos');
    }
};
