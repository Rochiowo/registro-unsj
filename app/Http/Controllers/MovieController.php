<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function __construct()
    {
        if (! session()->has('movies')) {
            session()->put('movies', $this->defaultMovies());
        }

        $this->normalizeMovies();
    }

    public function index(): View
    {
        return view('movies.index', ['movies' => $this->movies()]);
    }

    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $movies = $this->movies();
        $movie = $request->validated();
        $movie['id'] = (collect($movies)->max('id') ?? 0) + 1;

        $movies[] = $movie;
        session()->put('movies', $movies);

        return redirect()->route('movies.index')->with('success', 'Película agregada correctamente.');
    }

    public function edit(int $id): View
    {
        $movie = collect($this->movies())->firstWhere('id', $id);

        abort_unless($movie, 404);

        return view('movies.edit', ['movie' => $movie]);
    }

    public function update(UpdateMovieRequest $request, int $id): RedirectResponse
    {
        $movies = $this->movies();
        $movieIndex = collect($movies)->search(fn (array $movie): bool => $movie['id'] === $id);

        abort_unless($movieIndex !== false, 404);

        $movies[$movieIndex] = array_merge($movies[$movieIndex], $request->validated());
        session()->put('movies', $movies);

        return redirect()->route('movies.index')->with('success', 'Película actualizada correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $movies = $this->movies();
        $movieIndex = collect($movies)->search(fn (array $movie): bool => $movie['id'] === $id);

        abort_unless($movieIndex !== false, 404);

        unset($movies[$movieIndex]);
        session()->put('movies', array_values($movies));

        return redirect()->route('movies.index')->with('success', 'Película eliminada correctamente.');
    }

    private function movies(): array
    {
        return session('movies', []);
    }

    private function normalizeMovies(): void
    {
        $defaults = collect($this->defaultMovies())->keyBy('id');
        $movies = collect(session('movies', []))->map(function (array $movie) use ($defaults): array {
            $default = $defaults->get($movie['id'], []);

            return array_merge($default, $movie, [
                'director' => $movie['director'] ?? $default['director'] ?? 'Sin director',
            ]);
        })->values()->all();

        session()->put('movies', $movies);
    }

    private function defaultMovies(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'The Shawshank Redemption',
                'director' => 'Frank Darabont',
                'year' => 1994,
            ],
            [
                'id' => 2,
                'title' => 'Inception',
                'director' => 'Christopher Nolan',
                'year' => 2010,
            ],
            [
                'id' => 3,
                'title' => 'Spirited Away',
                'director' => 'Hayao Miyazaki',
                'year' => 2001,
            ],
        ];
    }
}
