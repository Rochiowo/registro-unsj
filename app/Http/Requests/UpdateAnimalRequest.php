<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, string>> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:100'],
            'age' => ['required', 'integer', 'min:0', 'max:200'],
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del animal es obligatorio.',
            'name.max' => 'El nombre del animal no puede superar los 255 caracteres.',
            'species.required' => 'La especie del animal es obligatoria.',
            'species.max' => 'La especie no puede superar los 100 caracteres.',
            'age.required' => 'La edad del animal es obligatoria.',
            'age.integer' => 'La edad debe ser un número entero.',
            'age.min' => 'La edad no puede ser negativa.',
            'age.max' => 'La edad no puede superar los 200 años.',
        ];
    }
}
