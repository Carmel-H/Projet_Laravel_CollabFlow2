<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Le constructeur pour appliquer le middleware
    public function __construct()
    {
        $this->middleware('auth');
    }

    // La méthode qui gère la page d'accueil ou le tableau de bord
    public function index()
    {
        // Assurez-vous que vous récupérez les projets et les tâches assignées
        $projects = Project::all();  // Récupère tous les projets

        // Récupérer les tâches assignées à l'utilisateur connecté
        $tasks = Task::where('user_id', auth()->id())->get();

        // Passer les données des projets et des tâches à la vue
        return view('dashboard', compact('projects', 'tasks'));
    }
}
