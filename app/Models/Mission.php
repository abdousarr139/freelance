<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = [
        'client_id', 'category_id', 'titre', 'description',
        'budget_min', 'budget_max', 'deadline',
        'statut', 'type_contrat', 'fichier_joint'
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    // ---- Relations ----

    // La mission appartient à un client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // La mission appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // La mission a plusieurs propositions
    public function propositions()
    {
        return $this->hasMany(Proposition::class);
    }

    // La mission a plusieurs messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // La mission a un avis
    public function avis()
    {
        return $this->hasOne(Avis::class);
    }

    // ---- Scopes ----

    // Récupérer uniquement les missions ouvertes
    public function scopeOuvertes($query)
    {
        return $query->where('statut', 'ouverte');
    }

    // Récupérer les missions par catégorie
    public function scopeParCategorie($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}