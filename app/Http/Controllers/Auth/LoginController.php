<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');  // Vue de connexion
    }

    public function login(Request $request)
    {
        // Validation des entrées
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tentative de connexion
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Connexion réussie
            return redirect()->intended('/dashboard');  // Rediriger vers le tableau de bord ou la page principale
        }

        // Connexion échouée
        return redirect()->back()->with('error', 'Email ou mot de passe invalide.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
