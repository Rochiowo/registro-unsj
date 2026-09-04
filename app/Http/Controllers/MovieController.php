<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function __construct()
    {
        if (! session()->has('movies')) {
            session([
                'movies' => [
                    [
                        'id' => 1,
                        'title' => 'The Shawshank Redemption',
                        'genre' => 'Drama',
                        'year' => 1994,
                    ],
                    [
                        'id' => 2,
                        'title' => 'Inception',
                        'genre' => 'Science Fiction',
                        'year' => 2010,
                    ],
                    [
                        'id' => 3,
                        'title' => 'Spirited Away',
                        'genre' => 'Animation',
                        'year' => 2001,
                    ],
                ],
            ]);
        }
    }

    public function index(): View
    {
        return view('movies.index', ['movies' => session('movies')]);
    }

    public function edit(int $id): View
    {
        $movie = collect(session('movies'))->firstWhere('id', $id);

        abort_unless($movie, 404);

        return view('movies.edit', ['movie' => $movie]);
    }

    public function update(int $id): RedirectResponse
    {
        abort_unless(collect(session('movies'))->firstWhere('id', $id), 404);

        return redirect()->route('movies.index');
    }
}
