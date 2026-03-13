<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'expediteur_id', 'destinataire_id',
        'mission_id', 'contenu', 'lu'
    ];

    protected $casts = [
        'lu' => 'boolean',
    ];

    // Message envoyé par
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    // Message reçu par
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }

    // Message lié à une mission
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}