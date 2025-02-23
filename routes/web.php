<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Mail;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/', function () {
    return view('auth.login'); // Page de connexion par défaut
});

// Dashboard
Route::get('/dashboard', function (Request $request) {
    // Récupérer les projets et les tâches assignées
    $projects = Project::where('user_id', $request->user()->id)->get();

    $acceptedProjectIds = ProjectMember::where('user_id', $request->user()->id)
        ->where('has_accepted', true)
        ->pluck('project_id'); // Récupère uniquement les IDs des projets acceptés

    $membershipProjects = Project::whereIn('id', $acceptedProjectIds)->get();

    // Fusionner les deux collections sans doublons
    $projects = $projects->merge($membershipProjects)->unique('id');

    $tasks = Task::where('user_id', Auth::id())->get();  // Récupérer les tâches assignées à l'utilisateur connecté

    // Retourner la vue avec les données
    return view('dashboard', compact('projects', 'tasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour les Projets
Route::resource('projects', ProjectController::class);

// Route pour créer un projet (accessible uniquement par l'admin)
Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

// Route pour afficher un projet spécifique
Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}/edit', [TaskController::class, 'update']);

// Route pour gérer les tâches assignées
Route::get('projects/{project}/tasks', [TaskController::class, 'indexe'])->name('tasks.index');

// Route pour assigner une tâche à un utilisateur
Route::post('projects/{project}/tasks/assign', [TaskController::class, 'assignTask'])->name('tasks.assign');

//Route pour les notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/{id}/project/{accept}', [NotificationController::class, 'acceptOrRejectProject'])->name('notifications.acceptOrRejectProject');
});

//Routes protégées pour les utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestion des projets
    Route::resource('projects', ProjectController::class);

    // Routes pour les administrateurs
    Route::middleware([])->group(function () {
        Route::post('/projects/invite/{id}', [ProjectController::class, 'inviteUser'])->name('projects.invite');
        Route::post('/tasks/{project}/assign', [TaskController::class, 'assignTask'])->name('tasks.assign');
    });

    // Routes accessibles aux membres
    Route::middleware([])->group(function () {
        Route::post('/projects/{project}/join', [ProjectController::class, 'join'])->name('projects.join');
        Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');
    });
});

Route::get('/test-email', function () {
    Mail::raw('Test de mail Laravel', function ($message) {
        $message->to('elfouego@gmail.com')->subject('Test Laravel');
    });

    return 'Email envoyé !';
});

require __DIR__ . '/auth.php';
