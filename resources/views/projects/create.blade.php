<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer un Projet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf

                    <!-- Nom du Projet -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Nom du Projet</label>
                        <input type="text" name="name" class="w-full p-2 border rounded" required>
                    </div>

                    <!-- Description du Projet -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" class="w-full p-2 border rounded" required></textarea>
                    </div>

                    <!-- Date de début -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Date de Début</label>
                        <input type="date" name="start_date" class="w-full p-2 border rounded" required>
                    </div>

                    <!-- Date de fin -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Date de Fin</label>
                        <input type="date" name="end_date" class="w-full p-2 border rounded" required>
                    </div>

                    <!-- Statut du projet -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Statut</label>
                        <select name="status" class="w-full p-2 border rounded">
                            @foreach ($status as $key => $role )
                            <option value="{{ $key }}"> {{ $role }} </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- les membres du projet -->
                    <div class="mb-4">
                        <div class="flex items-center">
                            <label class="block text-gray-700 dark:text-gray-300 w-1/2">Les membres</label>
                            <div class="text-end w-1/2 ">
                                <button class="p-2 border-0 bg-gray-800 text-white" type="button" id="addProjectMemberBtn">Ajouter</button>
                            </div>
                        </div>
                        <div id="projectMembersArea">
                            <div class="flex items-center gap-2 my-2 projectMember w-full" id="firstProjectMember">
                                <div class="w-1/3">
                                    <select name="members[]" class="w-full p-2 mt-2 border rounded">
                                        @foreach ($possibleMembers as $user )
                                        <option value="{{ $user->id }}"> {{ $user->first_name }} {{ $user->last_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-[43%]">
                                    <select name="status[]" class="w-full p-2 mt-2 border rounded">
                                        <option value="0"> Membre </option>
                                        <option value="1"> Admin </option>
                                    </select>
                                </div>
                                <div class="w-auto">
                                    <button class="p-2 bg-[red] text-white rounded removeProjectMemberBtn" type="button">Rétirer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Créer</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>