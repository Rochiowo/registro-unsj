<?php

namespace App\Services;

interface SpeciesServiceInterface
{
    //lista todas las especies
    public function all(): array;
    //busca una especie por su ID
    public function find(string $id): array;
    public function create(array $data): array;
    public function update(string $id, array $data): array;
    public function delete(string $id): bool;
    public function reset(): void;
}