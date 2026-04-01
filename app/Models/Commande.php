<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'user_id',
        'statut',
        'total',
    ];

    // Une commande appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une commande a plusieurs burgers
    public function burgers()
    {
        return $this->belongsToMany(Burger::class, 'commande_burger')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
    // Une commande a un paiement
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
