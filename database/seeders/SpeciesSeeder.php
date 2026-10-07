<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesSeeder extends Seeder
{
public function run(): void
    {
        //creamos una lista de nombres en memoria
        $species = [
            'Canino','Felino','Ave','Reptil','Roedor','Pez','Anfibio','Equino','Hurón','Insecto',
        ];
        //recorremos la lista elemento por elemento
        foreach ($species as $name) {
            //ejecutamos una orden de guardado,'?' hueco seguro sin riesgos de hackeo
            DB::insert('INSERT INTO species (name) VALUES (?)', [$name]);
        }
    }
}
