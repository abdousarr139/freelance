<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('profilFreelance')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // Supprimer un utilisateur
    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 403, 'Impossible de supprimer un admin.');
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }

    // Activer / Désactiver (via colonne banned si vous l'ajoutez plus tard)
    public function toggle(User $user)
    {
        // Pour l'instant on change le rôle en 'banni'
        $user->update([
            'role' => $user->role === 'banni' ? 'client' : 'banni'
        ]);

        return back()->with('success', 'Statut utilisateur modifié.');
    }
}