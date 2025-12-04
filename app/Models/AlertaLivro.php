<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertaLivro extends Model
{

    protected $table = 'alertas_livro';

    protected $fillable = [
        'user_id',
        'livro_id',
        'notificado',
    ];

    protected $casts = [
        'notificado' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function scopePendente($query)
    {
        return $query->where('notificado', false);
    }

    public function scopePorLivro($query, $livroId)
    {
        return $query->where('livro_id', $livroId);
    }

    public function marcarComoNotificado()
    {
        $this->update(['notificado' => true]);
    }
}
