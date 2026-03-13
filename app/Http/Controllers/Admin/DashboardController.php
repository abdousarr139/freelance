<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mission;
use App\Models\Proposition;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_clients'      => User::where('role', 'client')->count(),
            'total_freelances'   => User::where('role', 'freelance')->count(),
            'total_missions'     => Mission::count(),
            'missions_ouvertes'  => Mission::where('statut', 'ouverte')->count(),
            'missions_en_cours'  => Mission::where('statut', 'en_cours')->count(),
            'total_propositions' => Proposition::count(),
        ];

        // Derniers inscrits
        $derniers_users = User::latest()->take(5)->get();

        // Dernières missions
        $dernieres_missions = Mission::with(['client', 'category'])
            ->latest()->take(5)->get();

        return view('admin.dashboard',
            compact('stats', 'derniers_users', 'dernieres_missions'));
    }
}