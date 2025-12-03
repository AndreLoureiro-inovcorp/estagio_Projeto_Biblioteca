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
        'preco',
    ];

    protected $casts = [
        'disponivel' => 'boolean',
    ];

    private static $stopwords = [
        'a', 'o', 'as', 'os', 'de', 'do', 'da', 'dos', 'das',
        'em', 'no', 'na', 'nos', 'nas',
        'e', 'ou', 'mas', 'que', 'se', 'como', 'para', 'por', 'com',
        'the', 'a', 'an', 'and', 'or', 'but', 'of', 'in', 'on',
        'to', 'for', 'with', 'by', 'from', 'is', 'are', 'was', 'were',
    ];

    private function limparTexto(string $texto): array
    {
        $texto = mb_strtolower($texto, 'UTF-8');

        $texto = preg_replace('/[^a-záàâãéèêíïóôõöúçñ\s]/u', ' ', $texto);

        $palavras = preg_split('/\s+/', $texto, -1, PREG_SPLIT_NO_EMPTY);

        $palavrasLimpas = array_filter($palavras, function ($palavra) {
            return strlen($palavra) >= 3 && ! in_array($palavra, self::$stopwords);
        });

        return array_unique($palavrasLimpas);
    }

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewsAtivos()
    {
        return $this->hasMany(Review::class)->where('estado', 'ativo');
    }

    public function mediaClassificacao()
    {
        return $this->reviews()->where('estado', 'ativo')->avg('classificacao');
    }
}
