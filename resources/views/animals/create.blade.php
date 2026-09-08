@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('animals.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">&larr; Volver a animales</a>
        <h1 class="mt-3 text-3xl font-bold text-gray-900">Nuevo animal</h1>
        <p class="mt-2 text-gray-600">Completa los datos del animal.</p>
    </div>

    @if ($errors->any())
        <div role="alert" class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
            <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('animals.store') }}" method="POST" class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ej. Luna">
        </div>

        <div>
            <label for="species" class="block text-sm font-semibold text-gray-700">Especie</label>
            <input id="species" name="species" type="text" value="{{ old('species') }}" required maxlength="100" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ej. Perro">
        </div>

        <div>
            <label for="age" class="block text-sm font-semibold text-gray-700">Edad</label>
            <input id="age" name="age" type="number" value="{{ old('age') }}" required min="0" max="200" class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Edad en años">
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('animals.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-3 font-semibold text-gray-700 hover:bg-gray-50">Cancelar</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white hover:bg-blue-700">Guardar animal</button>
        </div>
    </form>
</div>
@endsection
