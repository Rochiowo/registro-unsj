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

                <a href="{{ route('animals.create') }}" class="btn btn-primary animal-create-button">
                    Add Animal
                </a>
            </div>

            @if (session('success'))
                <p role="status" class="animal-status">{{ session('success') }}</p>
            @endif

            <div class="movies-table-wrapper">
                <table class="movies-table animals-table">
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
                            <tr>
                                <td class="movie-title-cell">{{ $animal['name'] }}</td>
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
@endsection
