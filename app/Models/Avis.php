<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $fillable = [
        'mission_id', 'auteur_id',
        'freelance_id', 'note', 'commentaire'
    ];

    // Avis sur une mission
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    // Avis écrit par (client)
    public function auteur()
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    // Avis reçu par (freelance)
    public function freelance()
    {
        return $this->belongsTo(User::class, 'freelance_id');
    }
}