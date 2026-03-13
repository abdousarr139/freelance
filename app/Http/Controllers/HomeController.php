<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Category;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // 6 dernières missions ouvertes
        $missions = Mission::with(['client', 'category'])
            ->ouvertes()
            ->latest()
            ->take(6)
            ->get();

        // Toutes les catégories
        $categories = Category::withCount('missions')->get();

        // Compteurs pour la page d'accueil
        $stats = [
            'missions'   => Mission::count(),
            'freelances' => User::where('role', 'freelance')->count(),
            'clients'    => User::where('role', 'client')->count(),
        ];

        return view('home', compact('missions', 'categories', 'stats'));
    }
}