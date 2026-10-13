<?php

namespace App\Services;

class AnimalMockService implements AnimalServiceInterface
{
    protected string $sessionKey = 'animals_mock_data';

    protected array $defaultAnimals = [
        ['id' => '1', 'name' => 'Milo', 'age' => 5],
        ['id' => '2', 'name' => 'Luna', 'age' => 2],
        ['id' => '3', 'name' => 'Paco', 'age' => 12],
    ];

    public function __construct()
    {
        // Si la sesión no existe, inicializamos los datos predeterminados
        if (!session()->has($this->sessionKey)) {
            $this->reset();
        }
    }

    public function all(): array
    {
        return session()->get($this->sessionKey, []);
    }

    public function find(string $id): ?array
    {
        $items = $this->all();
        // collect() permite búsquedas expresivas en memoria; firstWhere devuelve null si no encuentra el ID
        return collect($items)->firstWhere('id', $id);
    }

    public function create(array $data): array
    {
        $items = $this->all();
        $newItem = array_merge($data, ['id' => (string) (count($items) + 1)]);
        $items[] = $newItem;
        
        session()->put($this->sessionKey, $items);
        return $newItem;
    }

    public function update(string $id, array $data): ?array
    {
        $items = $this->all();
        foreach ($items as $k => $item) {
            if ($item['id'] === $id) {
                $items[$k] = array_merge($item, $data, ['id' => $id]);
                session()->put($this->sessionKey, $items);
                return $items[$k];
            }
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $items = $this->all();
        // Filtramos eliminando el elemento que coincide con el ID
        $filtered = array_values(array_filter($items, fn($i) => $i['id'] !== $id));

        if (count($filtered) !== count($items)) {
            session()->put($this->sessionKey, $filtered);
            return true;
        }
        return false;
    }

    public function reset(): void
    {
        session()->put($this->sessionKey, $this->defaultAnimals);
    }
}