@extends('layouts.app')

@section('content')
<main class="movies-page">
    <div class="movies-shell">

        {{-- Header --}}
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
                    <h1>Movies Manager</h1>
                    <p>Manage your movie collection</p>
                </div>
            </div>
        </header>

        {{-- Add New Movie --}}
        <section class="add-section">
            <div class="section-title">
                <span class="section-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="4" y="4" width="16" height="16" rx="2.5" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <h2>Add New Movie</h2>
            </div>

            @if (Route::has('movies.store'))
                <form class="movie-form" action="{{ route('movies.store') }}" method="POST">
                    @csrf
            @else
                <form class="movie-form" action="#" method="POST" onsubmit="return false;">
            @endif

                <div class="form-field">
                    <label for="title">
                        <span class="field-icon">▣</span>
                        <span>Title</span>
                    </label>
                    <input id="title" name="title" type="text"
                           value="{{ old('title') }}"
                           placeholder="Enter movie title..." autocomplete="off">
                </div>

                <div class="form-field">
                    <label for="director">
                        <span class="field-icon">♙</span>
                        <span>Director</span>
                    </label>
                    <input id="director" name="director" type="text"
                           value="{{ old('director') }}"
                           placeholder="Enter director name..." autocomplete="off">
                </div>

                <div class="form-actions-row">
                    <div class="form-field year-field">
                        <label for="year">
                            <span class="field-icon">▣</span>
                            <span>Year</span>
                        </label>
                        <input id="year" name="year" type="number"
                               value="{{ old('year') }}"
                               placeholder="YYYY" min="1888" max="{{ date('Y') }}">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-secondary">
                            <span class="btn-icon">＋</span>
                            Add Movie
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="btn-icon">▣</span>
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </section>

        {{-- Movies list --}}
        <section class="list-section">
            <div class="list-heading">
                <div class="section-title">
                    <span class="section-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 5.5 19 3l1.5 4.5-14 2.5L5 5.5Z" stroke="currentColor" stroke-width="1.8"/>
                            <rect x="4" y="8" width="16" height="12" rx="2" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M9 5 10 9M14 4l1 4M15 12l4 2.5-4 2.5v-5Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <h2>Movies List</h2>
                </div>

                <div class="search-box">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="2"/>
                        <path d="m16 16 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input id="movieSearch" type="search" placeholder="Search movies..." aria-label="Search movies">
                </div>
            </div>

            <div class="movies-table-wrapper">
                <table class="movies-table" id="moviesTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Director</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movies as $movie)
                            <tr class="movie-row">
                                <td class="movie-title-cell">{{ $movie['title'] }}</td>
                                <td>{{ $movie['director'] ?? '—' }}</td>
                                <td>{{ $movie['year'] ?? '—' }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('movies.edit', $movie['id']) }}" class="action-btn edit-btn">
                                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="m4 16-.8 4.8L8 20l11-11-4-4L4 16Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                                <path d="m13.5 6.5 4 4" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                            Edit
                                        </a>

                                        @if (Route::has('movies.destroy'))
                                            <form action="{{ route('movies.destroy', $movie['id']) }}" method="POST"
                                                  onsubmit="return confirm('¿Eliminar esta película?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete-btn">
                                        @else
                                            <button type="button" class="action-btn delete-btn"
                                                    onclick="alert('Configura la ruta movies.destroy para habilitar la eliminación.');">
                                        @endif
                                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M6 7h12M9 7V4h6v3M8 10v7M12 10v7M16 10v7M7 7l1 13h8l1-13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Delete
                                            </button>
                                        @if (Route::has('movies.destroy'))
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="movies-empty">
                                        <span class="empty-icon">🎬</span>
                                        <strong>No hay películas disponibles.</strong>
                                        <span>Agrega una nueva película para comenzar.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="searchEmpty" class="search-empty" hidden>
                    No se encontraron películas que coincidan con tu búsqueda.
                </div>

                {{-- Pagination visual --}}
                @php
                    $movieCount = is_countable($movies) ? count($movies) : 0;
                @endphp

                <div class="table-footer">
                    <span class="results-count">
                        Showing 1 to {{ min(5, $movieCount) }} of {{ $movieCount }} movies
                    </span>

                    <div class="pagination" aria-label="Pagination">
                        <button type="button" class="page-btn arrow" disabled>‹</button>
                        <button type="button" class="page-btn active">1</button>
                        <button type="button" class="page-btn">2</button>
                        <button type="button" class="page-btn">3</button>
                        <button type="button" class="page-btn arrow">›</button>
                    </div>

                    <button type="button" class="per-page">
                        5 per page
                        <span>⌄</span>
                    </button>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="movies-footer">
            <div>
                <span class="footer-icon">▣</span>
                <strong>Movies Manager</strong>
                <span>© 2024</span>
            </div>
            <div>Keep your collection organized 🎬</div>
        </footer>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('movieSearch');
    const rows = document.querySelectorAll('#moviesTable .movie-row');
    const empty = document.getElementById('searchEmpty');

    if (!search) return;

    search.addEventListener('input', function () {
        const term = this.value.trim().toLowerCase();
        let visible = 0;

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            const show = text.includes(term);

            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        empty.hidden = term === '' || visible > 0;
    });
});
</script>
@endsection

