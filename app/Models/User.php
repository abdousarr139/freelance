<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'avatar', 'bio', 'phone', 'country'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ---- Relations ----

    // Un client a plusieurs missions
    public function missions()
    {
        return $this->hasMany(Mission::class, 'client_id');
    }

    // Un freelance a un profil
    public function profilFreelance()
    {
        return $this->hasOne(ProfilFreelance::class);
    }

    // Un freelance a plusieurs propositions
    public function propositions()
    {
        return $this->hasMany(Proposition::class, 'freelance_id');
    }

    // Messages envoyés
    public function messagesEnvoyes()
    {
        return $this->hasMany(Message::class, 'expediteur_id');
    }

    // Messages reçus
    public function messagesRecus()
    {
        return $this->hasMany(Message::class, 'destinataire_id');
    }

    // Avis donnés (client)
    public function avisdonnes()
    {
        return $this->hasMany(Avis::class, 'auteur_id');
    }

    // Avis reçus (freelance)
    public function avisRecus()
    {
        return $this->hasMany(Avis::class, 'freelance_id');
    }

    // ---- Helpers rôles ----

    public function isClient()
    {
        return $this->role === 'client';
    }

    public function isFreelance()
    {
        return $this->role === 'freelance';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}