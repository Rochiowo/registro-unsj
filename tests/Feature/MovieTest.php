<?php

test('movies index lists movie titles', function () {
    $this->get('/movies')
        ->assertSuccessful()
        ->assertSee('The Shawshank Redemption')
        ->assertSee('Inception');
});

test('movie edit page displays the selected movie', function () {
    $this->get('/movies/2/edit')
        ->assertSuccessful()
        ->assertSee('Inception')
        ->assertSee('name="_token"', false)
        ->assertSee('name="_method"', false);
});

test('movie update redirects to the index', function () {
    $this->put('/movies/2', ['title' => 'New title'])
        ->assertRedirect('/movies');
});
