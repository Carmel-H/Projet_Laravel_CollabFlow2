<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données de connexion
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion avec les informations d'identification de l'utilisateur
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->filled('remember'))) {
            // Régénérer la session de l'utilisateur après la connexion
            $request->session()->regenerate();

            // Redirection vers la page d'accueil ou la page prévue
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Si l'authentification échoue, renvoyer l'utilisateur avec un message d'erreur
        return back()->withErrors([
            'email' => 'Les identifiants fournis sont incorrects.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
/**
     * Afficher la page pour demander un mot de passe oublié.
     */
    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }
/**
     * Envoyer un lien de réinitialisation de mot de passe par email.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        // Validation de l'email
        $request->validate(['email' => 'required|email']);

        // Envoi de l'email pour la réinitialisation du mot de passe
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        }

        return back()->withErrors(['email' => 'L\'email fourni n\'est pas enregistré.']);
    }

    /**
     * Afficher le formulaire pour réinitialiser le mot de passe avec le token.
     */
    public function resetPassword($token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Mettre à jour le mot de passe de l'utilisateur.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // Validation des entrées
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Tentative de réinitialisation du mot de passe
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Mise à jour du mot de passe
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Le mot de passe a été réinitialisé avec succès.');
        }
        return back()->withErrors(['email' => 'Les informations fournies sont incorrectes.']);
    }
}
