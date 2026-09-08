@extends('layouts.app')

@section('content')
<main class="movies-page animals-page">
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
                    <h1>Administrador de Animales</h1>
                    <p>Gestiona tu colección de animales</p>
                </div>
            </div>
        </header>

        <section class="add-section">
            <div class="section-title">
                <h2>Agregar Nuevo Animal</h2>
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
                    <label for="name"><span>Nombre</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" placeholder="Ingresa el nombre del animal..." autocomplete="off">
                </div>

                <div class="form-field">
                    <label for="species"><span>Especie</span></label>
                    <input id="species" name="species" type="text" value="{{ old('species') }}" required maxlength="100" placeholder="Ingresa la especie..." autocomplete="off">
                </div>

                <div class="form-actions-row">
                    <div class="form-field year-field">
                        <label for="age"><span>Edad</span></label>
                        <input id="age" name="age" type="number" value="{{ old('age') }}" required min="0" max="200" placeholder="Años">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">Agregar Animal</button>
                    </div>
                </div>
            </form>
        </section>

        <section class="list-section animals-list-section">
            <div class="list-heading">
                <div class="section-title">
                    <h2>Lista de Animales</h2>
                </div>

                <div class="list-tools">
                    <button type="button" id="sortAnimals" class="sort-btn" aria-label="Sort animals alphabetically" aria-pressed="false">
                        <span class="sort-label">Ordenar por:</span>
                        <span class="sort-icon" aria-hidden="true">A-Z</span>
                    </button>

                    <div class="search-box">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="2"/>
                            <path d="m16 16 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input id="animalSearch" type="search" placeholder="Buscar animales..." aria-label="Buscar animales">
                    </div>

                </div>
            </div>

            <div class="movies-table-wrapper">
                <table class="movies-table animals-table" id="animalsTable">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Especie</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($animals as $animal)
                            <tr class="animal-row">
                                <td class="movie-title-cell animal-name-cell">{{ $animal['name'] }}</td>
                                <td>{{ $animal['species'] }}</td>
                                <td>{{ $animal['age'] }} años</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('animals.edit', $animal['id']) }}" class="action-btn edit-btn">Editar</a>
                                        <form action="{{ route('animals.destroy', $animal['id']) }}" method="POST" onsubmit="return confirm('¿Eliminar este animal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="movies-empty">
                                        <span class="empty-icon">🐾</span>
                                        <strong>No hay animales disponibles.</strong>
                                        <span>Agrega un animal para comenzar.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="animalSearchEmpty" class="search-empty" hidden>
                    No se encontraron animales que coincidan con tu búsqueda.
                </div>

                @php
                    $animalCount = is_countable($animals) ? count($animals) : 0;
                @endphp

                <div class="table-footer">
                    <span class="results-count">
                        Mostrando 1 a {{ min(5, $animalCount) }} de {{ $animalCount }} animales
                    </span>

                    <div class="pagination" aria-label="Pagination">
                        <button type="button" class="page-btn arrow" data-animal-page-direction="previous" aria-label="Previous page">‹</button>
                        <span id="animalPageButtons"></span>
                        <button type="button" class="page-btn arrow" data-animal-page-direction="next" aria-label="Next page">›</button>
                    </div>

                    <label class="per-page">
                        <select id="animalPerPage" aria-label="Animales por página">
                            <option value="5">5 por página</option>
                            <option value="10">10 por página</option>
                            <option value="25">25 por página</option>
                        </select>
                    </label>
                </div>
            </div>
        </section>

        <footer class="movies-footer">
            <div>
                <strong>Administrador de Animales</strong>
                <span>© {{ date('Y') }}</span>
            </div>
            <div>Mantén tu colección organizada</div>
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
            ? 'Mostrando 0 animales'
            : 'Mostrando ' + (firstVisible + 1) + ' a ' + Math.min(lastVisible, matchingRows.length) + ' de ' + matchingRows.length + ' animales';

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
