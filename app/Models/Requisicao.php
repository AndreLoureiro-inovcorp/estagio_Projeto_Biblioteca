<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requisicao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'requisicaos';

    protected $fillable = [
        'numero_requisicao',
        'user_id',
        'livro_id',
        'data_requisicao',
        'data_prevista_entrega',
        'data_entrega_real',
        'dias_decorridos',
        'estado',
        'foto_cidadao',
        'reminder_enviado',
    ];

    protected $casts = [
        'data_requisicao' => 'date',
        'data_prevista_entrega' => 'date',
        'data_entrega_real' => 'date',
        'reminder_enviado' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function scopeAtivas($query)
    {
        return $query->where('estado', 'ativa');
    }

    public function scopeEntregues($query)
    {
        return $query->where('estado', 'entregue');
    }

    public function scopeUltimosDias($query, $dias = 30)
    {
        return $query->where('data_requisicao', '>=', now()->subDays($dias));
    }

    public function getEstaAtrasadaAttribute()
    {
        return $this->estado === 'ativa' && $this->data_prevista_entrega < now();
    }
}
