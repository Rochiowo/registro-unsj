<?php

class Persona
{
    public $nombre;
    public $apellido;
    public $dni;

    public function __construct($nombre, $apellido, $dni)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
    }
}

$persona1 = new Persona("Juan", "Pérez", "12345678A");
$persona2 = new Persona("María", "Gómez", "87654321B");
$persona3 = new Persona("Carlos", "López", "56789012C");
$personas = [$persona1, $persona2, $persona3];


// crear una funcion que haga busqueda secuencial por DNI
function buscarPorDNI($array, $dni)
{
    foreach ($array as $persona) {
        if ($persona->dni === $dni) {
            return $persona;
        }
    }
    return null;
}


// crear una funcion que haga un busqueda binaria por DNI
function buscarBinarioPorDNI($array, $dni)
{
    usort($array, function ($a, $b) {
        return strcmp($a->dni, $b->dni);
    });

    $inferior = 0;
    $superior = count($array) - 1;

    while ($inferior <= $superior) {
        $mid = intval(($inferior + $superior) / 2);
        if ($array[$mid]->dni === $dni) {
            return $array[$mid];
        } elseif ($array[$mid]->dni < $dni) {
            $inferior = $mid + 1;
        } else {
            $superior = $mid - 1;
        }
    }
    return null;
}


// crear una funcion que haga busqueda secuencial por nombre



$nombreABuscar = "87654321B";
$personaEncontrada = buscarPorDNI($personas, $nombreABuscar);

if ($personaEncontrada) {
    echo "Persona encontrada: " . $personaEncontrada->nombre . " " . $personaEncontrada->apellido . " (DNI: " . $personaEncontrada->dni . ")\n";
} else {
    echo "Persona no encontrada\n";
}
