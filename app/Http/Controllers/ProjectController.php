<?php

namespace App\Http\Controllers;

use App\Mail\ProjectInvitation;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Assure que toutes les actions nécessitent une connexion
    }

    /**
     * Afficher tous les projets.
     */
    public function index(Request $request)
    {
        $projects = Project::where('user_id', $request->user()->id)->get();

        $acceptedProjectIds = ProjectMember::where('user_id', $request->user()->id)
            ->where('has_accepted', true)
            ->pluck('project_id'); // Récupère uniquement les IDs des projets acceptés

        $membershipProjects = Project::whereIn('id', $acceptedProjectIds)->get();

        // Fusionner les deux collections sans doublons
        $projects = $projects->merge($membershipProjects)->unique('id');
        return view('projects.index', compact('projects'));
    }

    /**
     * Afficher un projet spécifique.
     */
    public function show(Project $project)
    {
        $users = User::all(); // Récupérer tous les utilisateurs pour l'assignation des tâches

        return view('projects.show', compact('project', 'users'));
    }

    /**
     * Afficher la page de création d'un projet (réservé à l'admin).
     */
    public function create(Request $request)
    {
        //$this->authorize('create', Project::class);
        $status = [
            'pending' => 'En attente',
            'progress' => 'En cours',
            'done' => 'Terminé',
        ];

        $possibleMembers = User::where('id', '!=', $request->user()->id)->get();

        return view('projects.create', [
            'status' => $status,
            'possibleMembers' => $possibleMembers,
        ]);
    }

    /**
     * Enregistrer un projet (réservé à l'admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'start_date' => $request->post('start_date'),
            'end_date' => $request->post('end_date'),
        ]);

        $members = $request->post('members');
        $status = $request->post('status');

        try {
            foreach ($members as $key => $user) {
                $user = User::where('id', $user)->first();
                $memberStatus = $status[$key];
                $member = $project->project_members()->create([
                    'user_id' => $user->id,
                    'is_admin' => $memberStatus === '1' ? true : false,
                ]);

                $notif = $user->notifications()->create([
                    'project_id' => $project->id,
                    'title' => "Invitation au projet " . $project->name,
                    'type' => 'invitation',
                    'data' => ''
                ]);

                $role = $member->is_admin ? "administrateur" : 'membre';
                Mail::to($user->email)->send(new ProjectInvitation($project, $user, $role));
            }
        } catch (\Throwable $th) {
            // throw $th;
        }

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }

    /**
     * Modifier un projet.
     */
    public function edit(Project $project)
    {
        //$this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Mettre à jour un projet.
     */
    public function update(Request $request, Project $project)
    {
        //$this->authorize('update', $project);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Inviter un utilisateur dans un projet (réservé à l'admin).
     */
    public function inviteUser(Request $request, Project $project)
    {
        //$this->authorize('invite', $project);

        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $project->users()->attach($user->id);
            return back()->with('success', 'Utilisateur invité avec succès.');
        }

        return back()->with('error', 'Utilisateur introuvable.');
    }

    /**
     * Permettre à un membre de rejoindre un projet.
     */
    public function join(Project $project)
    {
        //$this->authorize('join', $project);

        // auth()->user()->projects()->attach($project->id);

        return back()->with('success', 'Vous avez rejoint le projet.');
    }
}
