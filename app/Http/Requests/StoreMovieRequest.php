<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'director' => ['nullable', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1888', 'max:'.date('Y')],
        ];
    }
}
