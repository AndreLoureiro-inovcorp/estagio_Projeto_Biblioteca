<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    protected $fillable = [
        'numero_encomenda',
        'user_id',
        'nome_completo',
        'morada',
        'cidade',
        'codigo_postal',
        'pais',
        'telefone',
        'valor_total',
        'estado',
        'stripe_payment_intent_id',
        'stripe_status',
    ];

    protected $casts = [
        'valor_total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itens()
    {
        return $this->hasMany(EncomendaItem::class);
    }

    public function scopeDoUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePendente($query)
    {
        return $query->where('estado', 'pendente');
    }

    public function scopePaga($query)
    {
        return $query->where('estado', 'paga');
    }

    public function scopeCancelada($query)
    {
        return $query->where('estado', 'cancelada');
    }

    public function estaPaga()
    {
        return $this->estado === 'paga';
    }

    public function estaPendente()
    {
        return $this->estado === 'pendente';
    }

    public static function gerarNumeroEncomenda()
    {
        $ano = date('Y');
        $ultimaEncomenda = self::whereYear('created_at', $ano)->orderBy('id', 'desc')->first();

        $numeroSequencial = $ultimaEncomenda ? intval(substr($ultimaEncomenda->numero_encomenda, -3)) + 1 : 1;

        return sprintf('ENC-%s-%03d', $ano, $numeroSequencial);
    }
}
