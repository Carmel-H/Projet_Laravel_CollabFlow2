<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le Projet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Champ Nom du Projet -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Nom du Projet</label>
                        <input type="text" name="name" value="{{ $project->name }}" class="w-full p-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" class="w-full p-2 border rounded" required>{{ $project->description }}</textarea>
                    </div>

                    <!-- Bouton de mise à jour -->
                    <div class="flex space-x-4">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">💾 Mettre à Jour</button>
                        <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">↩️ Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
