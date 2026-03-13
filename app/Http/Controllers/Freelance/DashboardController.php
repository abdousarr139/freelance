<?php

namespace App\Http\Controllers\Freelance;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\Proposition;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Propositions du freelance
        $propositions = Proposition::with(['mission.category', 'mission.client'])
            ->where('freelance_id', $user->id)
            ->latest()
            ->get();

        // Missions disponibles récentes
        $missionsDisponibles = Mission::with(['category', 'client'])
            ->ouvertes()
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_propositions'   => $propositions->count(),
            'propositions_attente' => $propositions->where('statut', 'en_attente')->count(),
            'propositions_acceptees' => $propositions->where('statut', 'acceptee')->count(),
            'propositions_refusees'  => $propositions->where('statut', 'refusee')->count(),
        ];

        return view('freelance.dashboard',
            compact('propositions', 'missionsDisponibles', 'stats'));
    }
}