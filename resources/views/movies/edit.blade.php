@extends('layouts.app')

@section('content')
<main class="movies-page edit-page">
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
                    <h1>Edit Movie</h1>
                    <p>Update your movie details</p>
                </div>
            </div>
        </header>

        <section class="add-section">
            <div class="section-title">
                <h2>{{ $movie['title'] }}</h2>
            </div>

            @if ($errors->any())
                <div role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="movie-form" action="{{ route('movies.update', $movie['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-field">
                    <label for="title">
                        <span>Title</span>
                    </label>
                    <input id="title" name="title" type="text"
                           value="{{ old('title', $movie['title']) }}"
                           placeholder="Enter movie title..." autocomplete="off" required>
                </div>

                <div class="form-field">
                    <label for="director">
                        <span>Director</span>
                    </label>
                    <input id="director" name="director" type="text"
                           value="{{ old('director', $movie['director'] ?? '') }}"
                           placeholder="Enter director name..." autocomplete="off">
                </div>

                <div class="form-actions-row">
                    <div class="form-field year-field">
                        <label for="year">
                            <span>Year</span>
                        </label>
                        <input id="year" name="year" type="number"
                               value="{{ old('year', $movie['year'] ?? '') }}"
                               placeholder="YYYY" min="1888" max="{{ date('Y') }}" required>
                    </div>

                    <div class="form-buttons">
                        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>
@endsection
