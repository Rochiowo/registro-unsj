<?php

test('animals index lists the session animals', function () {
    $this->get('/animals')
        ->assertSuccessful()
        ->assertSee('AnimalsApp')
        ->assertSee('Luna')
        ->assertSee('Perro');
});

test('animal creation stores a new animal in session', function () {
    $this->post('/animals', [
        'name' => 'Toby',
        'species' => 'Perro',
        'age' => 6,
    ])->assertRedirect('/animals');

    expect(session('animals'))->toContainEqual([
        'name' => 'Toby',
        'species' => 'Perro',
        'age' => 6,
        'id' => 4,
    ]);
});

test('animal edit page displays the selected animal', function () {
    $this->get('/animals/2/edit')
        ->assertSuccessful()
        ->assertSee('Milo')
        ->assertSee('name="_token"', false)
        ->assertSee('name="_method"', false);
});

test('animal update changes the animal in session', function () {
    $this->put('/animals/2', [
        'name' => 'Milo actualizado',
        'species' => 'Gato',
        'age' => 3,
    ])->assertRedirect('/animals');

    expect(session('animals.1.name'))->toBe('Milo actualizado');
});

test('animal deletion removes the animal from session', function () {
    $this->delete('/animals/2')->assertRedirect('/animals');

    expect(collect(session('animals'))->pluck('id')->all())->not->toContain(2);
});
