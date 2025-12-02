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


    public function estrelasHtml(): string
    {
        return str_repeat('⭐', $this->classificacao);
    }
}
