<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'requisicao_id',
        'user_id',
        'livro_id',
        'classificacao',
        'comentario',
        'estado',
        'justificacao_recusada',
    ];

    protected $casts = [
        'classificacao' => 'integer',
        
    ];

    public function requisicao()
    {
        return $this->belongsTo(Requisicao::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }


    public function scopeAtivo($query)
    {
        return $query->where('estado', 'ativo');
    }

    public function scopeSuspenso($query)
    {
        return $query->where('estado', 'suspenso');
    }

    public function scopeRecusado($query)
    {
        return $query->where('estado', 'recusado');
    }

    public function isAtivo(): bool
    {
        return $this->estado === 'ativo';
    }

    public function isSuspenso(): bool
    {
        return $this->estado === 'suspenso';
    }

    public function isRecusado(): bool
    {
        return $this->estado === 'recusado';
    }

    public function aprovar(): void
    {
        $this->update([
            'estado' => 'ativo',
            'justificacao_recusada' => null,
        ]);
    }

    public function recusar(string $justificacao_recusada): void
    {
        $this->update([
            'estado' => 'recusado',
            'justificacao_recusada' => $justificacao_recusada,
        ]);
    }

    public function estrelasHtml(): string
    {
        return str_repeat('⭐', $this->classificacao);
    }
}
