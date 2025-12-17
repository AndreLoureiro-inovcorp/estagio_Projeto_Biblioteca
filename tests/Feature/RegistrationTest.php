<?php

use App\Models\User;
use Laravel\Jetstream\Jetstream;

test('registration screen can be rendered', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('registration screen cannot be rendered if support is disabled', function () {
    $this->markTestSkipped('Registration support is enabled.');
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();

    $response->assertRedirect('/biblioteca/livros');
});
