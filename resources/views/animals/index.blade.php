@extends('layouts.app')

@section('content')
<!-- Enlace a los estilos -->
@vite(['resources/css/app.css', 'resources/js/animals.js'])

<main class="animals-page">
    <div class="animals-shell">
        <header class="animals-header">
            <div class="brand">
                <div class="brand-icon" aria-hidden="true">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Administrador de Animales" class="animal-logo">
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

            <form id="animal-form" action="{{ route('animals.store') }}" method="POST" class="animal-form">
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
                    <div class="form-field animal-age-field">
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
                    <form action="{{ route('animals.reset') }}" method="POST" class="inline-block" style="margin-right: 10px;">
                        @csrf
                        <button type="submit" 
                                class="btn btn-primary" 
                                style="background-color: #dc2626; border-color: #dc2626;"
                                onclick="return confirm('¿Seguro que deseas resetear la lista con los datos semilla?')">
                            Resetear lista
                        </button>
                    </form>
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

            <div class="animals-table-wrapper">
                <table class="animals-table" id="animalsTable">
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
                                <td class="animal-name-cell">{{ $animal['name'] }}</td>
                                <td>{{ $animal['species'] }}</td>
                                <td>{{ $animal['age'] }} años</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('animals.edit', $animal['id']) }}" class="action-btn edit-btn"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="m4 16-.8 4.8L8 20l11-11-4-4L4 16Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                                <path d="m13.5 6.5 4 4" stroke="currentColor" stroke-width="2"/>
                                            </svg>Editar</a>
                                        <form action="{{ route('animals.destroy', $animal['id']) }}" method="POST" onsubmit="return confirm('¿Eliminar este animal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M6 7h12M9 7V4h6v3M8 10v7M12 10v7M16 10v7M7 7l1 13h8l1-13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="animals-empty">
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

        <footer class="animals-footer">
            <div>
                <strong>Administrador de Animales</strong>
                <span>© {{ date('Y') }}</span>
            </div>
            <div>Mantén tu colección organizada</div>
        </footer>
    </div>
</main>

<!-- Enlace al archivo de JavaScript -->
<script src="{{ asset('resources/js/animals.js') }}"></script>
@endsection