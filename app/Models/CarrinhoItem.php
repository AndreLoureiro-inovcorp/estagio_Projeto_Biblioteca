<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrinhoItem extends Model
{
    protected $table = 'carrinho_itens';

    protected $fillable = [
        'user_id',
        'livro_id',
        'quantidade',
    ];

    protected $casts = [
        'quantidade' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function subtotal()
    {
        return $this->quantidade * $this->livro->preco;
    }

    public function scopeDoUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
