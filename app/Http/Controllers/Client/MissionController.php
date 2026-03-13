<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\Category;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    // Liste des missions du client
    public function index()
    {
        $missions = Mission::with(['category', 'propositions'])
            ->where('client_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('client.missions.index', compact('missions'));
    }

    // Formulaire de création
    public function create()
    {
        $categories = Category::all();
        return view('client.missions.create', compact('categories'));
    }

    // Enregistrer la mission
    public function store(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required|string|min:50',
            'budget_min'   => 'required|numeric|min:1',
            'budget_max'   => 'required|numeric|gte:budget_min',
            'deadline'     => 'required|date|after:today',
            'type_contrat' => 'required|in:fixe,horaire',
            'fichier_joint'=> 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->all();
        $data['client_id'] = Auth::id();

        // Upload fichier joint
        if ($request->hasFile('fichier_joint')) {
            $data['fichier_joint'] = $request->file('fichier_joint')
                ->store('missions', 'public');
        }

        Mission::create($data);

        return redirect()->route('client.missions.index')
            ->with('success', 'Mission publiée avec succès !');
    }

    // Formulaire d'édition
    public function edit(Mission $mission)
    {
        abort_if($mission->client_id !== Auth::id(), 403);
        $categories = Category::all();
        return view('client.missions.edit', compact('mission', 'categories'));
    }

    // Mettre à jour
    public function update(Request $request, Mission $mission)
    {
        abort_if($mission->client_id !== Auth::id(), 403);

        $request->validate([
            'titre'        => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required|string|min:50',
            'budget_min'   => 'required|numeric|min:1',
            'budget_max'   => 'required|numeric|gte:budget_min',
            'deadline'     => 'required|date',
            'type_contrat' => 'required|in:fixe,horaire',
        ]);

        $mission->update($request->except('fichier_joint'));

        return redirect()->route('client.missions.index')
            ->with('success', 'Mission mise à jour !');
    }

    // Supprimer
    public function destroy(Mission $mission)
    {
        abort_if($mission->client_id !== Auth::id(), 403);
        $mission->delete();

        return redirect()->route('client.missions.index')
            ->with('success', 'Mission supprimée.');
    }

    // Voir les propositions d'une mission
    public function propositions(Mission $mission)
    {
        abort_if($mission->client_id !== Auth::id(), 403);
        $mission->load('propositions.freelance.profilFreelance');

        return view('client.missions.propositions', compact('mission'));
    }

    // Accepter une proposition
    public function accepterProposition(Proposition $proposition)
    {
        abort_if($proposition->mission->client_id !== Auth::id(), 403);

        // Accepter cette proposition
        $proposition->update(['statut' => 'acceptee']);

        // Refuser toutes les autres
        $proposition->mission->propositions()
            ->where('id', '!=', $proposition->id)
            ->update(['statut' => 'refusee']);

        // Mettre la mission en cours
        $proposition->mission->update(['statut' => 'en_cours']);

        return back()->with('success', 'Proposition acceptée ! La mission est maintenant en cours.');
    }

    // Refuser une proposition
    public function refuserProposition(Proposition $proposition)
    {
        abort_if($proposition->mission->client_id !== Auth::id(), 403);
        $proposition->update(['statut' => 'refusee']);

        return back()->with('success', 'Proposition refusée.');
    }
}