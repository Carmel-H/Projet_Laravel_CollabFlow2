<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des Projets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">📌 Vos Projets</h3>

                <!-- Bouton pour créer un projet -->
                <div class="mb-4">
                    <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                        ➕ Créer un Projet
                    </a>
                </div>

                <!-- Liste des projets -->
                @if($projects->count() > 0)
                    <ul class="list-disc pl-5">
                        @foreach($projects as $project)
                            <li class="mb-2 flex justify-between items-center">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:underline">
                                    {{ $project->name }}
                                </a>
                                <a href="{{ route('projects.edit', $project->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">✏️ Modifier</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Aucun projet trouvé.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
