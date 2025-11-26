<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'imagem_capa',
        'disponivel',
        'preco'
    ];

    protected $casts = [
        'disponivel' => 'boolean',
    ];

    public function autores()
    {
        return $this->belongsToMany(Autor::class);
    }

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }

    public function historicoRequisicoes()
    {
        return $this->hasMany(Requisicao::class)->orderBy('created_at', 'desc');
    }
    public function scopeDisponiveis($query)
    {
        return $query->where('disponivel', true);
    }

    public function scopeIndisponiveis($query)
    {
        return $query->where('disponivel', false);
    }
}
