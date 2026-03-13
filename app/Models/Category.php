<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nom', 'slug', 'icone', 'type'
    ];

    // Une catégorie a plusieurs missions
    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}