<?php

namespace App\Exceptions;

use Exception;

class SpeciesNotFoundException extends Exception
{
    //arma el mensaje de error cuando no encontramos una especie
    public static function forId(string $id): self
    {
        return new self("No existe especie con ID: {$id}");
    }
}