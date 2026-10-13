<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalSeeder extends Seeder
{
public function run(): void
    {
        //creamos una lista de nombres en memoria
        $animals = [
            ['name' => 'Milo', 'species' => 'Perro', 'age' => 5],
            ['name' => 'Luna', 'species' => 'Gato', 'age' => 3],
            ['name' => 'Max', 'species' => 'Perro', 'age' => 2],
            ['name' => 'Bella', 'species' => 'Gato', 'age' => 4],
            ['name' => 'Rocky', 'species' => 'Perro', 'age' => 6],
            ['name' => 'Lucy', 'species' => 'Gato', 'age' => 1],
            ['name' => 'Charlie', 'species' => 'Perro', 'age' => 7],
            ['name' => 'Daisy', 'species' => 'Gato', 'age' => 2],
            ['name' => 'Buddy', 'species' => 'Perro', 'age' => 3],
            ['name' => 'Lily', 'species' => 'Gato', 'age' => 5],
        ];
        //recorremos la lista elemento por elemento
        foreach ($animals as $animal) {
            //ejecutamos una orden de guardado,'?' hueco seguro sin riesgos de hackeo
            DB::insert('INSERT INTO animals (name, species, age) VALUES (?, ?, ?)', [
                $animal['name'],
                $animal['species'],
                $animal['age']
            ]);
        }

        DB::insert(
            'INSERT INTO animals (name, species, age) VALUES (?, ?, ?)',
            ['Simba', 'León', 4]
        );
        DB::table('animals')->insert([
            ['name' => 'Nala', 'species' => 'León', 'age' => 3],
        ]);
    }
}
