<?php

test('movies index lists movie titles', function () {
    $this->get('/movies')
        ->assertSuccessful()
        ->assertSee('The Shawshank Redemption')
        ->assertSee('Inception')
        ->assertSee('Christopher Nolan');
});

test('movies index includes a working page size selector', function () {
    $this->get('/movies')
        ->assertSuccessful()
        ->assertSee('id="perPage"', false)
        ->assertSee('<option value="5">5 per page</option>', false)
        ->assertSee('<option value="10">10 per page</option>', false)
        ->assertSee('<option value="25">25 per page</option>', false);
});

test('movie edit page displays the selected movie', function () {
    $this->get('/movies/2/edit')
        ->assertSuccessful()
        ->assertSee('Inception')
        ->assertSee('name="_token"', false)
        ->assertSee('name="_method"', false);
});

test('movie update redirects to the index', function () {
    $this->put('/movies/2', [
        'title' => 'New title',
        'director' => 'New director',
        'year' => 2026,
    ])
        ->assertRedirect('/movies');

    expect(session('movies.1.title'))->toBe('New title');
});

test('movie can be created', function () {
    $this->post('/movies', [
        'title' => 'Arrival',
        'director' => 'Denis Villeneuve',
        'year' => 2016,
    ])->assertRedirect('/movies');

    expect(session('movies'))->toContainEqual([
        'title' => 'Arrival',
        'director' => 'Denis Villeneuve',
        'year' => 2016,
        'id' => 4,
    ]);
});

test('movie can be deleted', function () {
    $this->delete('/movies/2')->assertRedirect('/movies');

    expect(collect(session('movies'))->pluck('id')->all())->not->toContain(2);
});
