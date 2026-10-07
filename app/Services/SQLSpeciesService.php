<?php

namespace App\Services;

use App\Exceptions\SpeciesNotFoundException;
use Illuminate\Support\Facades\DB;

class SQLSpeciesService implements SpeciesServiceInterface
{
    //recupera todas las especies
    public function all(): array
    {
        $rows = DB::select('SELECT id, name FROM species ORDER BY id ASC');

        //convierte la respuesta de la base de datos en una lista limpia de PHP
        return array_map(function ($row) {
            return (array) $row;
        }, $rows);
    }

    //busca una especie
    public function find(string $id): array
    {
        $row = DB::selectOne('SELECT id, name FROM species WHERE id = ?', [$id]);

        if (!$row) {
            throw SpeciesNotFoundException::forId($id);
        }

        return (array) $row;
    }

    public function create(array $data): array
    {
        DB::insert('INSERT INTO species (name) VALUES (?)', [
            $data['name']
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

        DB::update('UPDATE species SET name = ? WHERE id = ?', [
            $data['name'],
            $id
        ]);
        //devuelve la especie con su nombre ya modificado
        return $this->find($id);
    }

    public function delete(string $id): bool
    {
        //verifica que la especie exista antes de intentar borrarla
        $this->find($id);

        $affected = DB::delete('DELETE FROM species WHERE id = ?', [$id]);

        //devuelve true si se borró correctamente
        return $affected > 0;
    }

    //vacia la tabla
    public function reset(): void
    {
        DB::statement('DELETE FROM species');
        //reinicia el contador de IDs para que la próxima especie vuelva a empezar desde el número 1
        DB::statement("DELETE FROM sqlite_sequence WHERE name = 'species'");
    }
}