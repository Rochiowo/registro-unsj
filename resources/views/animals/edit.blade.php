@extends('layouts.app')

@section('content')
<main class="movies-page animals-page edit-page">
    <div class="movies-shell">
        <header class="movies-header">
            <div class="brand">
                <div class="brand-icon" aria-hidden="true">
                    <svg class="animal-logo" viewBox="0 0 48 48" fill="none">
                        <path d="M24 42c-8.2 0-14-4.8-14-11.5 0-5.8 4.1-8.8 8.6-8.8 2.1 0 3.9.8 5.4 2.1 1.5-1.3 3.3-2.1 5.4-2.1 4.5 0 8.6 3 8.6 8.8C38 37.2 32.2 42 24 42Z" fill="currentColor"/>
                        <ellipse cx="14" cy="14" rx="5" ry="6" fill="currentColor"/>
                        <ellipse cx="25" cy="9" rx="5" ry="6" fill="currentColor"/>
                        <ellipse cx="36" cy="14" rx="5" ry="6" fill="currentColor"/>
                        <path d="M24 25c-1.8 2.2-3.2 4-3.2 6.1a3.2 3.2 0 0 0 6.4 0c0-2.1-1.4-3.9-3.2-6.1Z" fill="#ecfdf5"/>
                    </svg>
                </div>
                <div>
                    <h1>Editar Animal</h1>
                    <p>Actualiza los datos de tu animal</p>
                </div>
            </div>
        </header>

        <section class="add-section animal-form-section">
            <div class="section-title">
                <h2>{{ $animal['name'] }}</h2>
            </div>

            @if ($errors->any())
                <div role="alert" class="animal-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('animals.update', $animal['id']) }}" method="POST" class="movie-form animal-form">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label for="name"><span>Nombre</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $animal['name']) }}" required maxlength="255" placeholder="Ingresa el nombre del animal..." autocomplete="off">
                </div>

                <div class="form-field">
                    <label for="species"><span>Especie</span></label>
                    <input id="species" name="species" type="text" value="{{ old('species', $animal['species']) }}" required maxlength="100" placeholder="Ingresa la especie..." autocomplete="off">
                </div>

                <div class="form-actions-row">
                    <div class="form-field year-field animal-age-field">
                        <label for="age"><span>Edad</span></label>
                        <input id="age" name="age" type="number" value="{{ old('age', $animal['age']) }}" required min="0" max="200" placeholder="Años">
                    </div>

                    <div class="form-buttons">
                        <a href="{{ route('animals.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>
@endsection
