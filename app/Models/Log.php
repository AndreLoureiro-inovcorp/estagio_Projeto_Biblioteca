<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'modulo',
        'acao',
        'descricao',
        'ip',
        'user_agent',
    ];

    public function getBrowserNameAttribute(): string
    {
        return $this->detetarBrowser($this->user_agent);
    }

    private function detetarBrowser(?string $agent): string
    {
        $agent = strtolower($agent ?? '');

        if (str_contains($agent, 'edg')) {
            return 'Edge';
        }

        if (str_contains($agent, 'chrome')) {
            return 'Chrome';
        }

        if (str_contains($agent, 'firefox')) {
            return 'Firefox';
        }

        if (str_contains($agent, 'safari')) {
            return 'Safari';
        }

        if (str_contains($agent, 'opera') || str_contains($agent, 'opr')) {
            return 'Opera';
        }

        return 'Desconhecido';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
