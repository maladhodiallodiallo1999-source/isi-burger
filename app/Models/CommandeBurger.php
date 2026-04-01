<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeBurger extends Model
{
    protected $fillable = [
        'commande_id',
        'burger_id',
        'quantite',
        'prix_unitaire',
    ];
}
