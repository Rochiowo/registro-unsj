<?php

namespace App\Services;

use App\Exceptions\AnimalsNotFoundException;
use Illuminate\Support\Facades\DB;

class SQLAnimalsService implements AnimalServiceInterface
{
    //recupera todos los animales
    public function all(): array
    {
        $rows = DB::select('SELECT id, name, species, age FROM animals ORDER BY id ASC');

        //convierte la respuesta de la base de datos en una lista limpia de PHP
        $result = array_map(function ($row) {
            return (array) $row;
        }, $rows);

        return $result;
    }

    //busca un animal
    public function find(string $id): array
    {
        $row = DB::selectOne('SELECT id, name, species, age FROM animals WHERE id = ?', [$id]);

        if (!$row) {
            throw AnimalsNotFoundException::forId($id);
        }

        return (array) $row;
    }

    public function create(array $data): array
    {
        DB::insert('INSERT INTO animals (name, species, age) VALUES (?, ?, ?)', [
            $data['name'],
            $data['species'],
            $data['age']
        ]);
        //pregunta a SQLite: "¿Qué número de ID le acabas de asignar a lo que recién guardé?"
        $result = DB::selectOne('SELECT last_insert_rowid() AS id');
        $newId = (string) $result->id;

        //devuelve los datos completos de la especie que se acaba de crear
        return $this->find($newId);
    }

    public function update(string $id, array $data): array
    {
        //primero intenta buscarla: si no existe, salta la alarma y detiene el proceso aquí
        $this->find($id);

        DB::update('UPDATE animals SET name = ?, species = ?, age = ? WHERE id = ?', [
            $data['name'],
            $data['species'],
            $data['age'],
            $id
        ]);
        //devuelve el animal con sus datos ya modificados
        return $this->find($id);
    }

    public function delete(string $id): bool
    {
        //verifica que el animal exista antes de intentar borrarlo
        $this->find($id);

        $affected = DB::delete('DELETE FROM animals WHERE id = ?', [$id]);

        //devuelve true si se borró correctamente
        return $affected > 0;
    }

    //vacia la tabla
    public function reset(): void
    {
        DB::statement('DELETE FROM animals');
        //reinicia el contador de IDs para que la próxima especie vuelva a empezar desde el número 1
        DB::statement("DELETE FROM sqlite_sequence WHERE name = 'animals'");
    }
}