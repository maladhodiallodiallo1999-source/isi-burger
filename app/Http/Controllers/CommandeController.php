<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\CommandeConfirmation;
use App\Mail\CommandePrete;
use Illuminate\Support\Facades\Mail;



class CommandeController extends Controller
{
    // Client : voir le catalogue et passer commande
    public function catalogue()
    {
        $burgers = Burger::where('archive', false)->where('stock', '>', 0)->get();
        return view('catalogue', compact('burgers'));
    }

    // Client : passer une commande
    public function store(Request $request)
    {
        $request->validate([
            'burgers'   => 'required|array',
            'quantites' => 'required|array',
        ]);

        $total = 0;
        $items = [];

        foreach ($request->burgers as $index => $burgerId) {
            $burger   = Burger::findOrFail($burgerId);
            $quantite = $request->quantites[$index];
            $total   += $burger->prix * $quantite;

            $items[] = [
                'burger'   => $burger,
                'quantite' => $quantite,
            ];
        }

        $commande = Commande::create([
            'user_id' => Auth::id(),
            'statut'  => 'en_attente',
            'total'   => $total,
        ]);

        foreach ($items as $item) {
            $commande->burgers()->attach($item['burger']->id, [
                'quantite'      => $item['quantite'],
                'prix_unitaire' => $item['burger']->prix,
            ]);

            // Réduire le stock
            $item['burger']->decrement('stock', $item['quantite']);
        }
        // Envoyer email de confirmation au client
        Mail::to($commande->user->email)->send(new CommandeConfirmation($commande->load('burgers')));

        return redirect('/mes-commandes');
    }

    // Client : voir ses commandes
    public function mesCommandes()
    {
        $commandes = Commande::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('commandes.mes_commandes', compact('commandes'));
    }

    // Gestionnaire : voir toutes les commandes
    public function index()
    {
        $commandes = Commande::with('user')->orderBy('created_at', 'desc')->get();
        return view('commandes.index', compact('commandes'));
    }

    // Gestionnaire : voir détail d'une commande
    public function show($id)
    {
        $commande = Commande::with('user', 'burgers')->findOrFail($id);
        return view('commandes.show', compact('commande'));
    }

    // Gestionnaire : changer le statut
    public function updateStatut(Request $request, $id)
    {
        $commande = Commande::with('user', 'burgers')->findOrFail($id);
        $commande->update(['statut' => $request->statut]);

        // Envoyer email quand la commande est prête
        if ($request->statut === 'prete') {
            Mail::to($commande->user->email)->send(new CommandePrete($commande));
        }

        return redirect('/commandes/' . $id);
    }

    // Gestionnaire : annuler une commande
    public function annuler($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->update(['statut' => 'annulee']);
        return redirect('/commandes');
    }

    // Voir la facture d'une commande
    public function facture($id)
    {
        $commande = Commande::with('user', 'burgers', 'paiement')->findOrFail($id);
        return view('commandes.facture', compact('commande'));
    }
}
