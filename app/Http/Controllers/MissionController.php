<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    // Liste publique des missions
    public function index(Request $request)
    {
        $query = Mission::with(['client', 'category'])
            ->ouvertes()
            ->latest();

        // Filtre par catégorie
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filtre par type
        if ($request->type) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        // Recherche par mot-clé
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        $missions    = $query->paginate(9);
        $categories  = Category::all();

        return view('missions.index', compact('missions', 'categories'));
    }

    // Détail d'une mission
    public function show(Mission $mission)
    {
        $mission->load(['client', 'category', 'propositions.freelance']);

        // Vérifier si le freelance connecté a déjà proposé
        $dejaPropose = false;
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (Auth::check() && $user->isFreelance()) {
            $dejaPropose = $mission->propositions()
                ->where('freelance_id', Auth::id())
                ->exists();
        }

        return view('missions.show', compact('mission', 'dejaPropose'));
    }
}