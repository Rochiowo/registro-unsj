<?php

namespace App\Services;

use App\Contracts\AnimalServiceInterface;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileAnimalService implements AnimalServiceInterface
{
    private string $fileName = 'animals.json';

    // --- Métodos Privados (DRY) ---
    private function getAnimals(): array
    {
        if (!Storage::disk('local')->exists($this->fileName)) {
            return [];
        }

        $jsonContent = Storage::disk('local')->get($this->fileName);
        return json_decode($jsonContent, true) ?? [];
    }

    private function saveAnimals(array $animals): void
    {
        $jsonContent = json_encode($animals, JSON_PRETTY_PRINT);
        Storage::disk('local')->put($this->fileName, $jsonContent);
    }

    // --- Métodos Públicos (Contrato) ---
    public function all(): array
    {
        return $this->getAnimals();
    }

    public function find(int|string $id): array
    {
        $animals = $this->getAnimals();
        
        foreach ($animals as $animal) {
            if ($animal['id'] == $id) {
                return $animal;
            }
        }

        throw new Exception("El animal con ID {$id} no fue encontrado.");
    }

    public function create(array $data): array
    {
        $animals = $this->getAnimals();
        
        $nextId = 1;
        if (count($animals) > 0) {
            $ids = array_column($animals, 'id');
            $nextId = max($ids) + 1;
        }

        $data['id'] = $nextId;
        $animals[] = $data;
        
        $this->saveAnimals($animals);
        
        return $data; // Retorna el recurso recién creado según la rúbrica
    }

    public function update(int|string $id, array $data): void
    {
        $animals = $this->getAnimals();
        $found = false;

        foreach ($animals as $key => $animal) {
            if ($animal['id'] == $id) {
                $data['id'] = $id; // Protegemos el ID original
                $animals[$key] = array_merge($animal, $data);
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw new Exception("El animal con ID {$id} no fue encontrado.");
        }

        $this->saveAnimals($animals);
    }

    public function delete(int|string $id): bool
    {
        $animals = $this->getAnimals();
        
        foreach ($animals as $key => $animal) {
            if ($animal['id'] == $id) {
                unset($animals[$key]);
                $this->saveAnimals(array_values($animals)); // array_values reindexa
                return true; // Retorna true según la rúbrica
            }
        }

        throw new Exception("El animal con ID {$id} no fue encontrado.");
    }

    public function reset(): void
    {
        $seeders = [
            [
                "id" => 1,
                "name" => "Milo",
                "species" => "Perro",
                "age" => 4
            ],
            [
                "id" => 2,
                "name" => "Luna",
                "species" => "Gato",
                "age" => 2
            ]
        ];

        $this->saveAnimals($seeders);
    }
}