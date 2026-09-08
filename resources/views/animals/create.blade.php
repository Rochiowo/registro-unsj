@extends('layouts.app')

@section('content')
<main class="movies-page animals-page">
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
                    <h1>Animals Manager</h1>
                    <p>Manage your animal collection</p>
                </div>
            </div>
        </header>

        <section class="add-section">
            <div class="section-title">
            <h2>Add New Animal</h2>
            </div>

            @if ($errors->any())
                <div role="alert" class="animal-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('animals.store') }}" method="POST" class="movie-form">
                @csrf

                <div class="form-field">
                    <label for="name"><span>Name</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" placeholder="Enter animal name..." autocomplete="off">
                </div>

                <div class="form-field">
                    <label for="species"><span>Species</span></label>
                    <input id="species" name="species" type="text" value="{{ old('species') }}" required maxlength="100" placeholder="Enter species..." autocomplete="off">
                </div>

                <div class="form-actions-row">
                    <div class="form-field year-field">
                        <label for="age"><span>Age</span></label>
                        <input id="age" name="age" type="number" value="{{ old('age') }}" required min="0" max="200" placeholder="Years">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">Add Animal</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>
@endsection
