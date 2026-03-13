<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\Proposition;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Missions du client
        $missions = Mission::with(['category', 'propositions'])
            ->where('client_id', $user->id)
            ->latest()
            ->get();

        // Statistiques
        $stats = [
            'total_missions'     => $missions->count(),
            'missions_ouvertes'  => $missions->where('statut', 'ouverte')->count(),
            'missions_en_cours'  => $missions->where('statut', 'en_cours')->count(),
            'missions_terminees' => $missions->where('statut', 'terminee')->count(),
            'total_propositions' => Proposition::whereIn('mission_id', $missions->pluck('id'))->count(),
        ];

        return view('client.dashboard', compact('missions', 'stats'));
    }
}