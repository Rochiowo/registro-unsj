<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnimalController extends Controller
{
    public function index(): View
    {
        $this->initializeAnimals();

        return view('animals.index', ['animals' => session('animals')]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('animals.index');
    }

    public function store(StoreAnimalRequest $request): RedirectResponse
    {
        $animals = $this->animals();
        $animal = $request->validated();
        $animal['id'] = (collect($animals)->max('id') ?? 0) + 1;

        $animals[] = $animal;
        session()->put('animals', $animals);

        return redirect()->route('animals.index')->with('success', 'Animal creado correctamente.');
    }

    public function edit(int $id): View
    {
        $animal = collect($this->animals())->firstWhere('id', $id);

        abort_unless($animal, 404);

        return view('animals.edit', ['animal' => $animal]);
    }

    public function update(UpdateAnimalRequest $request, int $id): RedirectResponse
    {
        $animals = $this->animals();
        $animalIndex = collect($animals)->search(fn (array $animal): bool => $animal['id'] === $id);

        abort_unless($animalIndex !== false, 404);

        $animals[$animalIndex] = array_merge($animals[$animalIndex], $request->validated());
        session()->put('animals', $animals);

        return redirect()->route('animals.index')->with('success', 'Animal actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $animals = $this->animals();
        $animalIndex = collect($animals)->search(fn (array $animal): bool => $animal['id'] === $id);

        abort_unless($animalIndex !== false, 404);

        unset($animals[$animalIndex]);
        session()->put('animals', array_values($animals));

        return redirect()->route('animals.index')->with('success', 'Animal eliminado correctamente.');
    }

    private function animals(): array
    {
        $this->initializeAnimals();

        return session('animals', []);
    }

    private function initializeAnimals(): void
    {
        if (! session()->has('animals')) {
            session()->put('animals', [
                ['id' => 1, 'name' => 'Luna', 'species' => 'Perro', 'age' => 4],
                ['id' => 2, 'name' => 'Milo', 'species' => 'Gato', 'age' => 2],
                ['id' => 3, 'name' => 'Nube', 'species' => 'Conejo', 'age' => 1],
            ]);
        }
    }
}
