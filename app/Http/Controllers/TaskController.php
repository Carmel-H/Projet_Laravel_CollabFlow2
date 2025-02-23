<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Afficher les tâches d'un projet (membre et admin).
     */
    public function index(Project $project)
    {
        /*if (!auth()->user()->can('view task')) {
            abort(403, 'Vous n’avez pas la permission de voir les tâches.');
        }*/

        $tasks = $project->tasks;
        $users = User::all(); // Récupérer tous les utilisateurs
        //dd($tasks);

        return view('tasks.index', compact('tasks', 'project', 'users'));
    }

    /**
     * Assigner une tâche à un utilisateur (réservé à l'admin).
     */
    public function assignTask(Request $request, Project $project)
    {
        if (!auth()->user()->can('assign task')) {
            abort(403, 'Vous n’avez pas la permission d’assigner une tâche.');
        }

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->project_id = $project->id;
        $task->user_id = $request->user_id;
        $task->save();

        return back()->with('success', 'Tâche assignée avec succès.');
    }

    /**
     * Stocker une nouvelle tâche.
     */

    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
        ]);

        $members = $request->post('members');

        // Création de la tâche
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'due_date' => $request->due_date,
            'user_id' => auth()->id(),
        ]);

        try {
            foreach ($members as $key => $user) {
                $user = User::where('id', $user)->first();

                $member = $task->task_members()->create([
                    'user_id' => $user->id,
                ]);
            }
        } catch (\Throwable $th) {
            // throw $th;
        }

        // Redirection avec message de succès
        return redirect()->route('projects.show', $request->project_id)
            ->with('success', 'Tâche ajoutée avec succès !');
    }

    public function edit(Task $task) {
        //dd($task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|in:done,progress,suspended',
        ]);

        $task->update($request->except(['_token']));

        return redirect()->route('projects.show', $request->project_id);
    }
}
    