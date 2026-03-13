<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FreelanceController extends Controller
{
    // Liste publique des freelances
    public function index(Request $request)
    {
        $query = User::with('profilFreelance')
            ->where('role', 'freelance')
            ->whereHas('profilFreelance');

        // Recherche par nom ou titre
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhereHas('profilFreelance', function($q2) use ($request) {
                      $q2->where('titre_professionnel', 'like', '%'.$request->search.'%');
                  });
            });
        }

        // Filtre disponible seulement
        if ($request->disponible) {
            $query->whereHas('profilFreelance', function($q) {
                $q->where('disponible', true);
            });
        }

        $freelances = $query->paginate(9);

        return view('freelances.index', compact('freelances'));
    }

    // Profil public d'un freelance
    public function show(User $user)
    {
        abort_if(!$user->isFreelance(), 404);
        $user->load(['profilFreelance', 'avisRecus.auteur']);

        return view('freelances.show', compact('user'));
    }
}