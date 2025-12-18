<?php

use App\Models\Livro;
use App\Models\Requisicao;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use App\Livewire\Biblioteca\RequisicaoCriar;
use App\Livewire\Biblioteca\admin\RequisicaoConfirmarDevolucao;
use App\Livewire\Biblioteca\Requisicoes;

// TESTE 1: Pode criar requisição
test('pode criar requisicao', function () {
    Mail::fake();

    Role::create(['name' => 'admin']);
    Role::create(['name' => 'cidadao']);

    $user = User::factory()->create();
    $livro = Livro::factory()->create(['disponivel' => true]);

    Livewire::actingAs($user)->test(RequisicaoCriar::class)->set('livro_id', $livro->id)->call('criar');

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
        ->test(RequisicaoCriar::class)
        ->set('livro_id', '')
        ->call('criar')
        ->assertHasErrors(['livro_id']);

    $this->assertDatabaseCount('requisicaos', 0);
});

// TESTE 3: Admin pode confirmar devolução de livro
test('admin pode devolver livro', function () {
    Mail::fake();

    Role::create(['name' => 'admin']);
    Role::create(['name' => 'cidadao']);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $cidadao = User::factory()->create();

    $livro = Livro::factory()->create(['disponivel' => false]);

    $requisicao = Requisicao::create([
        'numero_requisicao' => 'REQ-0001',
        'user_id' => $cidadao->id,
        'livro_id' => $livro->id,
        'data_requisicao' => now(),
        'data_prevista_entrega' => now()->addDays(5),
        'estado' => 'ativa',
    ]);

    Livewire::actingAs($admin)
        ->test(RequisicaoConfirmarDevolucao::class, ['requisicao' => $requisicao->id])
        ->set('data_entrega_real', now()->format('Y-m-d'))
        ->call('confirmar');

    $this->assertDatabaseHas('requisicaos', [
        'id' => $requisicao->id,
        'estado' => 'entregue',
    ]);

    $this->assertDatabaseHas('livros', [
        'id' => $livro->id,
        'disponivel' => true,
    ]);
});

// TESTE 4: User vê apenas suas requisições
test('user ve apenas suas requisicoes', function () {
    Mail::fake();

    Role::create(['name' => 'admin']);
    Role::create(['name' => 'cidadao']);

    $user1 = User::factory()->create();
    $livro1 = Livro::factory()->create();
    $livro2 = Livro::factory()->create();

    Requisicao::create([
        'numero_requisicao' => 'REQ-0001',
        'user_id' => $user1->id,
        'livro_id' => $livro1->id,
        'data_requisicao' => now(),
        'data_prevista_entrega' => now()->addDays(5),
        'estado' => 'ativa',
    ]);

    Requisicao::create([
        'numero_requisicao' => 'REQ-0002',
        'user_id' => $user1->id,
        'livro_id' => $livro2->id,
        'data_requisicao' => now(),
        'data_prevista_entrega' => now()->addDays(5),
        'estado' => 'ativa',
    ]);

    $user2 = User::factory()->create();
    $livro3 = Livro::factory()->create();

    Requisicao::create([
        'numero_requisicao' => 'REQ-0003',
        'user_id' => $user2->id,
        'livro_id' => $livro3->id,
        'data_requisicao' => now(),
        'data_prevista_entrega' => now()->addDays(5),
        'estado' => 'ativa',
    ]);

    $component = Livewire::actingAs($user1)->test(Requisicoes::class);

    $component->assertSee('REQ-0001') ->assertSee('REQ-0002')->assertDontSee('REQ-0003');
});

// TESTE 5: Não pode requisitar livro indisponível
test('nao pode requisitar livro indisponivel', function () {
    Mail::fake();

    Role::create(['name' => 'admin']);
    Role::create(['name' => 'cidadao']);

    $user = User::factory()->create();
    $livro = Livro::factory()->create(['disponivel' => false]);

    Livewire::actingAs($user)->test(RequisicaoCriar::class)->set('livro_id', $livro->id)->call('criar');

    $this->assertDatabaseCount('requisicaos', 0);
});
