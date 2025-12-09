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
        Schema::create('encomendas', function (Blueprint $table) {
            
            $table->id();
            $table->string('numero_encomenda')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nome_completo');
            $table->string('morada');
            $table->string('cidade');
            $table->string('codigo_postal');
            $table->string('pais')->default('Portugal');
            $table->string('telefone');

            $table->decimal('valor_total', 8, 2);
            $table->enum('estado', ['pendente', 'paga', 'cancelada'])->default('pendente');
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_status')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('estado');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomendas');
    }
};
