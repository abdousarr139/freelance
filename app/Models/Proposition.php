<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposition extends Model
{
    protected $fillable = [
        'mission_id', 'freelance_id',
        'montant', 'delai_jours', 'message', 'statut'
    ];

    // La proposition appartient à une mission
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    // La proposition appartient à un freelance
    public function freelance()
    {
        return $this->belongsTo(User::class, 'freelance_id');
    }
}