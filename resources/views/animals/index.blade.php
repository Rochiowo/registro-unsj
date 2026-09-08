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

        <section class="list-section animals-list-section">
            <div class="list-heading">
                <div class="section-title">
                    <span class="section-icon animal-section-icon" aria-hidden="true">🐾</span>
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

                    <a href="{{ route('animals.create') }}" class="btn btn-primary animal-create-button">Add Animal</a>
                </div>
            </div>

            @if (session('success'))
                <p role="status" class="animal-status">{{ session('success') }}</p>
            @endif

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
    let animalRows = Array.from(document.querySelectorAll('#animalsTable .animal-row'));
    let sortAscending = false;

    if (!search || !sortAnimals || !tableBody || !empty) return;

    function renderAnimals() {
        const term = search.value.trim().toLowerCase();
        let visible = 0;

        animalRows.forEach(function (row) {
            const matches = row.textContent.toLowerCase().includes(term);

            row.style.display = matches ? '' : 'none';
            if (matches) visible++;
        });

        empty.hidden = term === '' || visible > 0;
    }

    search.addEventListener('input', renderAnimals);
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
        renderAnimals();
    });

    renderAnimals();
});
</script>
@endsection
