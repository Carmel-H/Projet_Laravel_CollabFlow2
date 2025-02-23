<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>

        <!-- Barre de navigation -->
        <nav class="mt-4 border-b">
    <ul class="flex space-x-6">
        <li>
            <a href="{{ route('dashboard') }}" class="pb-2 border-b-2 border-blue-500 text-blue-600 font-semibold">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('projects.index') }}" class="pb-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-500">
                Projets
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.index', ['project' => $projects->first()->id ?? 1]) }}" class="pb-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-500">
                Tâches
            </a>
        </li>
        <li>
            <a href="{{ route('notifications.index') }}" class="pb-2 text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-500">
                Notifications
            </a>
        </li>
    </ul>
</nav>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Section des Projets -->
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
                            <li class="mb-2">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:underline">
                                    {{ $project->name }}
                                </a>

                                <!-- Bouton pour gérer les tâches du projet -->
                                <div class="mt-2">
                                    <a href="{{ route('tasks.index', $project->id) }}" class="px-4 py-2 bg-green-500 text-white rounded">
                                        📋 Gérer les Tâches
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Aucun projet trouvé.</p>
                @endif

                <hr class="my-6 border-gray-600">

                <!-- Section des Tâches -->
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">📝 Vos Tâches</h3>

                <!-- Vérification pour éviter l'erreur d'affichage -->
                @if(isset($tasks) && $tasks->count() > 0)
                    <ul class="list-disc pl-5">
                        @foreach($tasks as $task)
                            <li class="mb-2">
                                <span class="font-semibold">{{ $task->title }}</span> - 
                                <span class="text-gray-400">{{ $task->description }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Aucune tâche assignée.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
