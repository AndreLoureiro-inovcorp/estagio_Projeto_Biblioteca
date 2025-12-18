<?php

use App\Models\Livro;
use App\Models\Requisicao;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

// TESTE 1: Pode criar requisição
test('pode criar requisicao', function () {
    Mail::fake();

    Role::create(['name' => 'admin']);
    Role::create(['name' => 'cidadao']);

    $user = User::factory()->create();
    $livro = Livro::factory()->create(['disponivel' => true]);

    Livewire::actingAs($user)->test(\App\Livewire\Biblioteca\RequisicaoCriar::class)->set('livro_id', $livro->id)->call('criar');

    $this->assertDatabaseHas('requisicaos', [
        'user_id' => $user->id,
        'livro_id' => $livro->id,
        'estado' => 'ativa',
    ]);
});

// TESTE 2: Não pode criar requisição sem livro válido
test('nao cria requisicao sem livro valido', function () {
    Mail::fake();

    Role::create(['name' => 'admin']);
    Role::create(['name' => 'cidadao']);

    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Biblioteca\RequisicaoCriar::class)
        ->set('livro_id', '')
        ->call('criar')
        ->assertHasErrors(['livro_id']);

    $this->assertDatabaseCount('requisicaos', 0);
});
