<?php

namespace App\Http\Controllers\Freelance;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropositionController extends Controller
{
    // Liste des propositions du freelance
    public function index()
    {
        $propositions = Proposition::with(['mission.category', 'mission.client'])
            ->where('freelance_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('freelance.propositions.index', compact('propositions'));
    }

    // Soumettre une proposition
    public function store(Request $request, Mission $mission)
    {
        // Vérifier que la mission est ouverte
        abort_if($mission->statut !== 'ouverte', 403, 'Cette mission est fermée.');

        // Vérifier que le freelance n'a pas déjà proposé
        $dejaPropose = $mission->propositions()
            ->where('freelance_id', Auth::id())
            ->exists();

        abort_if($dejaPropose, 403, 'Vous avez déjà soumis une proposition.');

        $request->validate([
            'montant'     => 'required|numeric|min:1',
            'delai_jours' => 'required|integer|min:1',
            'message'     => 'required|string|min:30',
        ]);

        Proposition::create([
            'mission_id'   => $mission->id,
            'freelance_id' => Auth::id(),
            'montant'      => $request->montant,
            'delai_jours'  => $request->delai_jours,
            'message'      => $request->message,
            'statut'       => 'en_attente',
        ]);

        return redirect()->route('missions.show', $mission)
            ->with('success', 'Proposition envoyée avec succès !');
    }

    // Supprimer une proposition
    public function destroy(Proposition $proposition)
    {
        abort_if($proposition->freelance_id !== Auth::id(), 403);
        abort_if($proposition->statut !== 'en_attente', 403,
            'Impossible de supprimer une proposition traitée.');

        $proposition->delete();

        return back()->with('success', 'Proposition supprimée.');
    }
}