@extends('layouts.app')

@section('content')
<main class="movies-page animals-page">
    <div class="movies-shell">
        <header class="movies-header">
            <div class="brand">
                <span class="section-icon animal-section-icon" aria-hidden="true">🐾</span>
                <div>
                    <h1>Animals Manager</h1>
                    <p>Manage your animal collection</p>
                </div>
            </div>
        </header>

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

                    <a href="#animal-form" class="btn btn-primary animal-create-button">Add Animal</a>
                </div>
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

            <form id="animal-form" action="{{ route('animals.store') }}" method="POST" class="movie-form animal-form">
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
