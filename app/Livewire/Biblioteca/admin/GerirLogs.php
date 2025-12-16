<?php

namespace App\Livewire\Biblioteca\Admin;

use App\Models\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class GerirLogs extends Component
{
    use WithPagination;

    public function render()
    {
        $logs = Log::with('user')->orderBy('created_at', 'desc')->paginate(20);

        return view('livewire.biblioteca.admin.gerir-logs', [
            'logs' => $logs,
        ]);
    }
}
