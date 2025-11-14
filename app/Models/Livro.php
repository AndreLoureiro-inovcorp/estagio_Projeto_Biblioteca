<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Livro extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'isbn', 'editora_id', 'imagem_capa', 'bibliografia', 'preco'];

    protected $casts = [
        'isbn' => 'encrypted',
    ];

    public function autores()
    {
        return $this->belongsToMany(Autor::class);
    }

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }
}
