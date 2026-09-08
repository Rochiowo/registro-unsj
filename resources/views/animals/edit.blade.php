@extends('layouts.app')

@section('content')
<main class="movies-page animals-page edit-page">
    <div class="movies-shell">
        <header class="movies-header">
            <div class="brand">
                <div class="brand-icon" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none">
                        <path d="M5 9.5 25 5l2 4.5-20 4.5L5 9.5Z" stroke="currentColor" stroke-width="2"/>
                        <rect x="5" y="10" width="22" height="17" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M11 7.9 13 12M17 6.5l2 4.5M23 5.2l2 4.5" stroke="currentColor" stroke-width="2"/>
                        <path d="m15 17 5 3-5 3v-6Z" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <h1>Edit Animal</h1>
                    <p>Update your animal details</p>
                </div>
            </div>
        </header>

        <section class="add-section animal-form-section">
            <div class="section-title">
                <span class="section-icon animal-section-icon" aria-hidden="true">🐾</span>
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
                    <label for="name"><span class="animal-field-mark">●</span><span>Name</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $animal['name']) }}" required maxlength="255" placeholder="Enter animal name..." autocomplete="off">
                </div>

                <div class="form-field">
                    <label for="species"><span class="animal-field-mark">◇</span><span>Species</span></label>
                    <input id="species" name="species" type="text" value="{{ old('species', $animal['species']) }}" required maxlength="100" placeholder="Enter species..." autocomplete="off">
                </div>

                <div class="form-actions-row">
                    <div class="form-field year-field animal-age-field">
                        <label for="age"><span class="animal-field-mark">#</span><span>Age</span></label>
                        <input id="age" name="age" type="number" value="{{ old('age', $animal['age']) }}" required min="0" max="200" placeholder="Years">
                    </div>

                    <div class="form-buttons">
                        <a href="{{ route('animals.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary"><span class="btn-icon-text" aria-hidden="true">✓</span>Save Changes</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>
@endsection
