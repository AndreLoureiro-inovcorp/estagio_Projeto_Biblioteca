<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    
    public static function registar(string $modulo, string $acao, string $descricao): void
    {
        $userId = Auth::id();
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        Log::create([
            'user_id' => $userId,
            'modulo' => $modulo,
            'acao' => $acao,
            'descricao' => $descricao,
            'ip' => $ip,
            'user_agent' => $userAgent,
        ]);
    }
}
