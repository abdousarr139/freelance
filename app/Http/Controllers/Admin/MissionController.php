<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mission;

class MissionController extends Controller
{
    public function index()
    {
        $missions = Mission::with(['client', 'category'])
            ->latest()
            ->paginate(15);

        return view('admin.missions.index', compact('missions'));
    }

    public function destroy(Mission $mission)
    {
        $mission->delete();
        return back()->with('success', 'Mission supprimée.');
    }

    public function toggle(Mission $mission)
    {
        $newStatut = $mission->statut === 'annulee' ? 'ouverte' : 'annulee';
        $mission->update(['statut' => $newStatut]);

        return back()->with('success', 'Statut de la mission modifié.');
    }
}