<x-layout>
    <x-slot:title>Detalle: {{ $animal['name'] }}</x-slot:title>

    <div class="max-w-md mx-auto">
        <a href="{{ route('animals.index') }}" class="text-sm text-indigo-600 hover:underline">&larr; Volver</a>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-4">
            <div class="flex justify-between items-center pb-3 border-b">
                <span class="font-mono text-xs text-slate-500">ID: #{{ $animal['id'] }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-semibold">Animal Registrado</span>
            </div>

            <div class="py-6 space-y-2">
                <h1 class="text-2xl font-bold text-slate-900">{{ $animal['name'] }}</h1>
                <p class="text-sm text-slate-600">Edad: <span class="font-semibold">{{ $animal['age'] }} años</span></p>
            </div>

            <div class="flex justify-between items-center pt-3 border-t">
                <a href="{{ route('animals.edit', $animal['id']) }}" class="text-sm text-indigo-600 font-medium hover:underline">Editar</a>
                <form action="{{ route('animals.destroy', $animal['id']) }}" method="POST" onsubmit="return confirm('¿Eliminar este animal?');">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="text-sm text-rose-600 font-medium hover:underline">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>