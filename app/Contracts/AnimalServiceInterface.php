<?php

namespace App\Contracts;

interface AnimalServiceInterface
{
    public function all(): array;
    
    public function find(int|string $id): array;
    
    public function create(array $data): array;
    
    public function update(int|string $id, array $data): void;
    
    public function delete(int|string $id): bool;
    
    public function reset(): void;
}