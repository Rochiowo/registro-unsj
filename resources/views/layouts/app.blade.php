<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'MovieApp') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-100 font-sans text-gray-900 antialiased">
        <nav class="bg-gray-900 text-white shadow">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="text-2xl font-bold">MovieApp</a>
            </div>
        </nav>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        <footer class="mt-auto bg-gray-900 py-6 text-center text-sm text-gray-300">
            &copy; {{ date('Y') }} MovieApp. Todos los derechos reservados.
        </footer>
    </body>
</html>
