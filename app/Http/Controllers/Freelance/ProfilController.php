<?php

namespace App\Http\Controllers\Freelance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // Formulaire d'édition du profil
    public function edit()
    {
        $user   = Auth::user();
        $profil = $user->profilFreelance;

        return view('freelance.profil.edit', compact('user', 'profil'));
    }

    // Mettre à jour le profil
    public function update(Request $request)
    {
        $request->validate([
            'titre_professionnel' => 'required|string|max:255',
            'competences'         => 'required|string',
            'portfolio_url'       => 'nullable|url',
            'tarif_journalier'    => 'nullable|numeric|min:0',
            'annees_experience'   => 'required|integer|min:0',
            'disponible'          => 'boolean',
            'bio'                 => 'nullable|string|max:1000',
            'phone'               => 'nullable|string|max:20',
            'avatar'              => 'nullable|image|max:1024',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Mettre à jour le user
        $user->update([
            'bio'     => $request->bio,
            'phone'   => $request->phone,
            'country' => $request->country,
        ]);

        // Upload avatar
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        // Compétences : "Laravel, Vue.js, MySQL" → array
        $competences = array_map('trim', explode(',', $request->competences));

        // Mettre à jour le profil freelance
        /** @var \App\Models\ProfilFreelance $profilFreelance */
        $profilFreelance = $user->profilFreelance;
        $profilFreelance->update([
            'titre_professionnel' => $request->titre_professionnel,
            'competences'         => $competences,
            'portfolio_url'       => $request->portfolio_url,
            'tarif_journalier'    => $request->tarif_journalier,
            'annees_experience'   => $request->annees_experience,
            'disponible'          => $request->boolean('disponible'),
        ]);

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}