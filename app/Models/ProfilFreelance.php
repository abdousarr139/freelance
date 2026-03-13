<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilFreelance extends Model
{
    protected $fillable = [
        'user_id', 'titre_professionnel', 'competences',
        'portfolio_url', 'tarif_journalier',
        'annees_experience', 'note_moyenne', 'disponible'
    ];

    protected $casts = [
        // JSON stocké en BDD → automatiquement converti en array PHP
        'competences' => 'array',
        'disponible'  => 'boolean',
    ];

    // Le profil appartient à un user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}