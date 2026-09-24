<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Contracts\AnimalServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnimalController extends Controller
{
    public function __construct(
        private AnimalServiceInterface $animalService
    ) {}

    public function index(): View
    {
        /// Usamos all() tal como lo dicta la especificación
        $animals = $this->animalService->all();

        return view('animals.index', ['animals' => $animals]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('animals.index');
    }

    public function store(StoreAnimalRequest $request): RedirectResponse
    {
        // El servicio se encarga de calcular el ID y guardar en el JSON
        $this->animalService->create($request->validated());

        return redirect()->route('animals.index')
            ->with('success', 'Animal creado correctamente.');
    }

    public function edit(int $id): View
    {
        // El servicio busca el animal (lanzará la Exception requerida si no existe)
        $animal = $this->animalService->find($id);

        return view('animals.edit', ['animal' => $animal]);
    }

    public function update(UpdateAnimalRequest $request, int $id): RedirectResponse
    {
        // El servicio actualiza el registro en el JSON
        $this->animalService->update($id, $request->validated());

        return redirect()->route('animals.index')
            ->with('success', 'Animal actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        // El servicio elimina el registro del JSON
        $this->animalService->delete($id);

        return redirect()->route('animals.index')
            ->with('success', 'Animal eliminado correctamente.');
    }

    public function reset(): RedirectResponse
    {
        $this->animalService->reset();

        return redirect()->route('animals.index')
            ->with('success', 'La lista de animales ha sido reseteada con los datos semilla.');
    }
}