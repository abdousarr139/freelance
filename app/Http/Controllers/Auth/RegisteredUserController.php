<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilFreelance;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Afficher le formulaire d'inscription
    public function create(): View
    {
        return view('auth.register');
    }

    // Traiter l'inscription
    public function store(Request $request): RedirectResponse
    {
        // Validation
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'     => ['required', 'in:client,freelance'],
            'country'  => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'country'  => $request->country,
        ]);

        // Si freelance → créer un profil vide automatiquement
        if ($user->role === 'freelance') {
            ProfilFreelance::create([
                'user_id'             => $user->id,
                'titre_professionnel' => 'Mon titre professionnel',
                'competences'         => [],
                'annees_experience'   => 0,
                'disponible'          => true,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        // Rediriger selon le rôle
        return redirect($this->redirectTo($user));
    }

    // Définir la redirection après inscription
    private function redirectTo(User $user): string
    {
        return match($user->role) {
            'client'   => route('client.dashboard'),
            'freelance'=> route('freelance.dashboard'),
            default    => route('home'),
        };
    }
}