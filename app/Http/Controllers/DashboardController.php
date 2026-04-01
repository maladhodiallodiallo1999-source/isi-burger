<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Commandes en cours du jour
        $commandesEnCours = Commande::whereDate('created_at', today())
            ->whereIn('statut', ['en_attente', 'en_preparation'])
            ->count();

        // Commandes validées du jour
        $commandesValidees = Commande::whereDate('created_at', today())
            ->where('statut', 'prete')
            ->count();

        // Recettes journalières
        $recettesJour = Paiement::whereDate('date_paiement', today())
            ->sum('montant');

        // Commandes par mois (pour Chart.js)
        $commandesParMois = Commande::select(
            DB::raw('EXTRACT(MONTH FROM created_at) as mois'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

        // Préparer les données pour Chart.js
        $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        $dataCommandes = array_fill(0, 12, 0);
        foreach ($commandesParMois as $item) {
            $dataCommandes[(int)$item->mois - 1] = $item->total;
        }

        return view('dashboard', compact(
            'commandesEnCours',
            'commandesValidees',
            'recettesJour',
            'mois',
            'dataCommandes'
        ));
    }
}
