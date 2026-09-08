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
                <h2>Add New Movie</h2>
            </div>

            @if (session('success'))
                <p role="status">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <div role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="movie-form" action="{{ route('movies.store') }}" method="POST">
                @csrf

                <div class="form-field">
                    <label for="title">
                        <span>Title</span>
                    </label>
                    <input id="title" name="title" type="text"
                           value="{{ old('title') }}"
                           placeholder="Enter movie title..." autocomplete="off">
                </div>

                <div class="form-field">
                    <label for="director">
                        <span>Director</span>
                    </label>
                    <input id="director" name="director" type="text"
                           value="{{ old('director') }}"
                           placeholder="Enter director name..." autocomplete="off">
                </div>

                <div class="form-actions-row">
                    <div class="form-field year-field">
                        <label for="year">

                            <span>Year</span>
                        </label>
                        <input id="year" name="year" type="number"
                               value="{{ old('year') }}"
                               placeholder="YYYY" min="1888" max="{{ date('Y') }}">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">
                            Add Movie
                        </button>
                    </div>
                </div>
            </form>
        </section>

        {{-- Movies list --}}
        <section class="list-section">
            <div class="list-heading">
                <div class="section-title">
                    <h2>Movies List</h2>
                </div>

                <div class="list-tools">
                    <button type="button" id="sortMovies" class="sort-btn" aria-label="Sort movies alphabetically" aria-pressed="false">
                        <span class="sort-label">Sort by:</span>
                        <span class="sort-icon" aria-hidden="true">A-Z</span>
                    </button>

                    <div class="search-box">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="2"/>
                            <path d="m16 16 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input id="movieSearch" type="search" placeholder="Search movies..." aria-label="Search movies">
                    </div>
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

                                                                                <form action="{{ route('movies.destroy', $movie['id']) }}" method="POST"
                                                                                            onsubmit="return confirm('¿Eliminar esta película?');">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="action-btn delete-btn">
                                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M6 7h12M9 7V4h6v3M8 10v7M12 10v7M16 10v7M7 7l1 13h8l1-13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Delete
                                            </button>
                                            </form>
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
                        <button type="button" class="page-btn arrow" data-page-direction="previous" aria-label="Previous page">‹</button>
                        <span id="pageButtons"></span>
                        <button type="button" class="page-btn arrow" data-page-direction="next" aria-label="Next page">›</button>
                    </div>

                    <label class="per-page">
                        <select id="perPage" aria-label="Movies per page">
                            <option value="5">5 per page</option>
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                        </select>
                    </label>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="movies-footer">
            <div>
                <strong>Movies Manager</strong>
                <span>© 2026</span>
            </div>
            <div>Keep your collection organized</div>
        </footer>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('movieSearch');
    const rows = document.querySelectorAll('#moviesTable .movie-row');
    const empty = document.getElementById('searchEmpty');
    const count = document.querySelector('.results-count');
    const pageButtons = document.getElementById('pageButtons');
    const pageArrows = document.querySelectorAll('[data-page-direction]');
    const perPage = document.getElementById('perPage');
    const sortMovies = document.getElementById('sortMovies');
    const tableBody = document.querySelector('#moviesTable tbody');
    let movieRows = Array.from(document.querySelectorAll('#moviesTable .movie-row'));
    let sortAscending = false;
    let currentPage = 1;

    if (!search || !pageButtons || !perPage || !sortMovies || !tableBody) return;

    function renderTable() {
        const term = search.value.trim().toLowerCase();
        const matchingRows = movieRows.filter(function (row) {
            return row.textContent.toLowerCase().includes(term);
        });
        const pageSize = Number(perPage.value);
        const totalPages = Math.max(1, Math.ceil(matchingRows.length / pageSize));
        currentPage = Math.min(currentPage, totalPages);
        const firstVisible = (currentPage - 1) * pageSize;
        const lastVisible = firstVisible + pageSize;

        movieRows.forEach(function (row) {
            row.style.display = 'none';
        });
        matchingRows.slice(firstVisible, lastVisible).forEach(function (row) {
            row.style.display = '';
        });

        empty.hidden = term === '' || matchingRows.length > 0;
        count.textContent = matchingRows.length === 0
            ? 'Showing 0 movies'
            : 'Showing ' + (firstVisible + 1) + ' to ' + Math.min(lastVisible, matchingRows.length) + ' of ' + matchingRows.length + ' movies';

        pageButtons.replaceChildren();
        for (let page = 1; page <= totalPages; page++) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'page-btn' + (page === currentPage ? ' active' : '');
            button.textContent = page;
            button.addEventListener('click', function () {
                currentPage = page;
                renderTable();
            });
            pageButtons.appendChild(button);
        }

        pageArrows.forEach(function (arrow) {
            arrow.disabled = arrow.dataset.pageDirection === 'previous'
                ? currentPage === 1
                : currentPage === totalPages;
        });

    }

    search.addEventListener('input', function () {
        currentPage = 1;
        renderTable();
    });
    perPage.addEventListener('change', function () {
        currentPage = 1;
        renderTable();
    });
    sortMovies.addEventListener('click', function () {
        sortAscending = !sortAscending;
        movieRows.sort(function (firstRow, secondRow) {
            const firstTitle = firstRow.querySelector('.movie-title-cell').textContent.trim();
            const secondTitle = secondRow.querySelector('.movie-title-cell').textContent.trim();
            const comparison = firstTitle.localeCompare(secondTitle, undefined, { sensitivity: 'base' });

            return sortAscending ? comparison : -comparison;
        });

        movieRows.forEach(function (row) {
            tableBody.appendChild(row);
        });
        sortMovies.setAttribute('aria-pressed', String(!sortAscending));
        sortMovies.querySelector('.sort-icon').textContent = sortAscending ? 'A-Z' : 'Z-A';
        currentPage = 1;
        renderTable();
    });
    pageArrows.forEach(function (arrow) {
        arrow.addEventListener('click', function () {
            currentPage += arrow.dataset.pageDirection === 'previous' ? -1 : 1;
            renderTable();
        });
    });

    renderTable();
});
</script>
@endsection
