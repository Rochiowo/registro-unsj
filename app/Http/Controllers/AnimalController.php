<?php

namespace App\Http\Controllers;

use App\Services\AnimalServiceInterface;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnimalController extends Controller
{
    public function __construct(
        protected AnimalServiceInterface $animalService
    ) {}

    public function index(): View
    {
        // El controlador no sabe si los datos vienen de sesión o de una base de datos real
        $animals = $this->animalService->all();

        return view('animals.index', compact('animals'));
    }

    public function create(): View
    {
        return view('animals.create');
    }

    public function store(StoreAnimalRequest $request): RedirectResponse
    {
        // Delegamos la creación al contrato/servicio
        $this->animalService->create($request->validated());

        return redirect()->route('animals.index')->with('success', 'Animal creado correctamente.');
    }

    public function show(string $id): View
    {
        $animal = $this->animalService->find($id);
        abort_if(!$animal, 404, 'Animal no encontrado.');

        return view('animals.show', compact('animal'));
    }

    public function edit(string $id): View
    {
        $animal = $this->animalService->find($id);
        abort_if(!$animal, 404, 'Animal no encontrado.');

        return view('animals.edit', compact('animal'));
    }

    public function update(UpdateAnimalRequest $request, string $id): RedirectResponse
    {
        $updated = $this->animalService->update($id, $request->validated());
        abort_if(!$updated, 404, 'Animal no encontrado.');

        return redirect()->route('animals.index')->with('success', 'Animal actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $deleted = $this->animalService->delete($id);
        abort_if(!$deleted, 404, 'Animal no encontrado.');

        return redirect()->route('animals.index')->with('success', 'Animal eliminado correctamente.');
    }
}