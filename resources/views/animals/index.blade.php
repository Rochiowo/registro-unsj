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

            @if (session('success'))
                <p role="status" class="animal-status">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                <div role="alert" class="animal-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="animal-form" action="{{ route('animals.store') }}" method="POST" class="movie-form">
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

        <section class="list-section animals-list-section">
            <div class="list-heading">
                <div class="section-title">
                    <h2>Animals List</h2>
                </div>

                <div class="list-tools">
                    <button type="button" id="sortAnimals" class="sort-btn" aria-label="Sort animals alphabetically" aria-pressed="false">
                        <span class="sort-label">Sort by:</span>
                        <span class="sort-icon" aria-hidden="true">A-Z</span>
                    </button>

                    <div class="search-box">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="2"/>
                            <path d="m16 16 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input id="animalSearch" type="search" placeholder="Search animals..." aria-label="Search animals">
                    </div>

                </div>
            </div>

            <div class="movies-table-wrapper">
                <table class="movies-table animals-table" id="animalsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Species</th>
                            <th>Age</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($animals as $animal)
                            <tr class="animal-row">
                                <td class="movie-title-cell animal-name-cell">{{ $animal['name'] }}</td>
                                <td>{{ $animal['species'] }}</td>
                                <td>{{ $animal['age'] }} years</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('animals.edit', $animal['id']) }}" class="action-btn edit-btn">Edit</a>
                                        <form action="{{ route('animals.destroy', $animal['id']) }}" method="POST" onsubmit="return confirm('¿Eliminar este animal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="movies-empty">
                                        <span class="empty-icon">🐾</span>
                                        <strong>No animals available.</strong>
                                        <span>Add a new animal to get started.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="animalSearchEmpty" class="search-empty" hidden>
                    No animals were found matching your search.
                </div>

                @php
                    $animalCount = is_countable($animals) ? count($animals) : 0;
                @endphp

                <div class="table-footer">
                    <span class="results-count">
                        Showing 1 to {{ min(5, $animalCount) }} of {{ $animalCount }} animals
                    </span>

                    <div class="pagination" aria-label="Pagination">
                        <button type="button" class="page-btn arrow" data-animal-page-direction="previous" aria-label="Previous page">‹</button>
                        <span id="animalPageButtons"></span>
                        <button type="button" class="page-btn arrow" data-animal-page-direction="next" aria-label="Next page">›</button>
                    </div>

                    <label class="per-page">
                        <select id="animalPerPage" aria-label="Animals per page">
                            <option value="5">5 per page</option>
                            <option value="10">10 per page</option>
                            <option value="25">25 per page</option>
                        </select>
                    </label>
                </div>
            </div>
        </section>

        <footer class="movies-footer">
            <div>
                <strong>Animals Manager</strong>
                <span>© {{ date('Y') }}</span>
            </div>
            <div>Keep your collection organized</div>
        </footer>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('animalSearch');
    const sortAnimals = document.getElementById('sortAnimals');
    const tableBody = document.querySelector('#animalsTable tbody');
    const empty = document.getElementById('animalSearchEmpty');
    const count = document.querySelector('.animals-page .results-count');
    const pageButtons = document.getElementById('animalPageButtons');
    const pageArrows = document.querySelectorAll('[data-animal-page-direction]');
    const perPage = document.getElementById('animalPerPage');
    let animalRows = Array.from(document.querySelectorAll('#animalsTable .animal-row'));
    let sortAscending = false;
    let currentPage = 1;

    if (!search || !sortAnimals || !tableBody || !empty || !count || !pageButtons || !perPage) return;

    function renderAnimals() {
        const term = search.value.trim().toLowerCase();
        const matchingRows = animalRows.filter(function (row) {
            return row.textContent.toLowerCase().includes(term);
        });
        const pageSize = Number(perPage.value);
        const totalPages = Math.max(1, Math.ceil(matchingRows.length / pageSize));
        currentPage = Math.min(currentPage, totalPages);
        const firstVisible = (currentPage - 1) * pageSize;
        const lastVisible = firstVisible + pageSize;

        animalRows.forEach(function (row) {
            row.style.display = 'none';
        });
        matchingRows.slice(firstVisible, lastVisible).forEach(function (row) {
            row.style.display = '';
        });

        empty.hidden = term === '' || matchingRows.length > 0;
        count.textContent = matchingRows.length === 0
            ? 'Showing 0 animals'
            : 'Showing ' + (firstVisible + 1) + ' to ' + Math.min(lastVisible, matchingRows.length) + ' of ' + matchingRows.length + ' animals';

        pageButtons.replaceChildren();
        for (let page = 1; page <= totalPages; page++) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'page-btn' + (page === currentPage ? ' active' : '');
            button.textContent = page;
            button.addEventListener('click', function () {
                currentPage = page;
                renderAnimals();
            });
            pageButtons.appendChild(button);
        }

        pageArrows.forEach(function (arrow) {
            arrow.disabled = arrow.dataset.animalPageDirection === 'previous'
                ? currentPage === 1
                : currentPage === totalPages;
        });
    }

    search.addEventListener('input', renderAnimals);
    perPage.addEventListener('change', function () {
        currentPage = 1;
        renderAnimals();
    });
    sortAnimals.addEventListener('click', function () {
        sortAscending = !sortAscending;
        animalRows.sort(function (firstRow, secondRow) {
            const firstName = firstRow.querySelector('.animal-name-cell').textContent.trim();
            const secondName = secondRow.querySelector('.animal-name-cell').textContent.trim();
            const comparison = firstName.localeCompare(secondName, undefined, { sensitivity: 'base' });

            return sortAscending ? comparison : -comparison;
        });

        animalRows.forEach(function (row) {
            tableBody.appendChild(row);
        });
        sortAnimals.setAttribute('aria-pressed', String(!sortAscending));
        sortAnimals.querySelector('.sort-icon').textContent = sortAscending ? 'A-Z' : 'Z-A';
        currentPage = 1;
        renderAnimals();
    });
    pageArrows.forEach(function (arrow) {
        arrow.addEventListener('click', function () {
            currentPage += arrow.dataset.animalPageDirection === 'previous' ? -1 : 1;
            renderAnimals();
        });
    });

    renderAnimals();
});
</script>
@endsection
