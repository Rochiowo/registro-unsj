<?php

namespace App\Services;

interface AnimalServiceInterface
{
    //lista todas los animales
    public function all(): array;
    //busca un animal por su ID
    public function find(string $id): ?array;
    public function create(array $data): array;
    public function update(string $id, array $data): ?array;
    public function delete(string $id): bool;
    public function reset(): void;
}