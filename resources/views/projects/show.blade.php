<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">📝 Tâches Associées</h3>

                <!-- Formulaire d'ajout de tâche -->
                <div class="mb-6 bg-gray-100 dark:bg-gray-700 p-4 rounded">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200">➕ Ajouter une nouvelle tâche</h4>
                    <form action="{{ route('tasks.store') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <div class="mb-3">
                            <label for="name" class="block text-gray-700 dark:text-gray-300">Nom de la tâche</label>
                            <input type="text" id="name" name="title" class="w-full p-2 border rounded" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="block text-gray-700 dark:text-gray-300">Description</label>
                            <textarea id="description" name="description" class="w-full p-2 border rounded" rows="3" required></textarea>
                        </div>
                        <!-- Date de fin -->
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300">Date de Fin</label>
                            <input type="date" name="due_date" class="w-full p-2 border rounded" required>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="block text-gray-700 dark:text-gray-300">Assigner à</label>
                            <select id="user_id" name="members[]" class="w-full p-2 border rounded" multiple>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Ajouter</button>
                    </form>
                </div>

                <!-- Liste des tâches -->
                @if($project->tasks->count() > 0)
                <ul class="list-disc pl-5">
                    @foreach($project->tasks as $task)
                    <li class="mb-2 flex justify-between items-center">
                        <span class="font-semibold">{{ $task->title }}</span>
                        </span>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded">✏️ Modifier</a>
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