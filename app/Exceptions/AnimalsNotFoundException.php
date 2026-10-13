<?php

namespace App\Exceptions;

use Exception;

class AnimalsNotFoundException extends Exception
{
    //arma el mensaje de error cuando no encontramos un animal
    public static function forId(string $id): self
    {
        return new self("No existe animal con ID: {$id}");
    }
}