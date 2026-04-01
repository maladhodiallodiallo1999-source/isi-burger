<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    // Afficher le formulaire de paiement
    public function create($commandeId)
    {
        $commande = Commande::with('user', 'burgers')->findOrFail($commandeId);

        // Vérifier que la commande n'est pas déjà payée
        if ($commande->paiement) {
            return redirect('/commandes/' . $commandeId)->with('error', 'Cette commande est déjà payée.');
        }

        return view('paiements.create', compact('commande'));
    }

    // Enregistrer le paiement
    public function store(Request $request, $commandeId)
    {
        $commande = Commande::findOrFail($commandeId);

        // Vérifier que la commande n'est pas déjà payée
        if ($commande->paiement) {
            return redirect('/commandes/' . $commandeId)->with('error', 'Cette commande est déjà payée.');
        }

        Paiement::create([
            'commande_id'   => $commande->id,
            'montant'       => $commande->total,
            'date_paiement' => now(),
        ]);

        // Mettre le statut à payée
        $commande->update(['statut' => 'payee']);

        return redirect('/commandes/' . $commandeId)->with('success', 'Paiement enregistré avec succès !');
    }
}
