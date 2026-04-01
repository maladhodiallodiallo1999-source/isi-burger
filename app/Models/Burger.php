<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    protected $fillable = [
        'nom',
        'prix',
        'image',
        'description',
        'stock',
        'archive',
    ];
    
    // Un burger peut être dans plusieurs commandes
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_burger')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
}
