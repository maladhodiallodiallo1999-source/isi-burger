<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $commande->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-4" style="max-width:700px">

    <div class="no-print mb-3">
        <a href="/commandes/{{ $commande->id }}" class="btn btn-secondary">Retour</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimer</button>
    </div>

    <div class="card p-4">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-danger">🍔 ISI Burger</h2>
                <p class="mb-0">Restaurant ISI Burger</p>
                <p class="mb-0">Dakar, Sénégal</p>
            </div>
            <div class="text-end">
                <h4>FACTURE</h4>
                <p class="mb-0"><strong>#{{ $commande->id }}</strong></p>
                <p class="mb-0">{{ $commande->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <hr>

        <!-- Info client -->
        <div class="mb-4">
            <h6>Client :</h6>
            <p class="mb-0"><strong>{{ $commande->user->name }}</strong></p>
            <p class="mb-0">{{ $commande->user->email }}</p>
        </div>

        <!-- Tableau des burgers -->
        <table class="table table-bordered">
            <thead class="table-danger">
                <tr>
                    <th>Burger</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-end">Prix unitaire</th>
                    <th class="text-end">Sous-total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->burgers as $burger)
                <tr>
                    <td>{{ $burger->nom }}</td>
                    <td class="text-center">{{ $burger->pivot->quantite }}</td>
                    <td class="text-end">{{ $burger->pivot->prix_unitaire }} FCFA</td>
                    <td class="text-end">{{ $burger->pivot->quantite * $burger->pivot->prix_unitaire }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td class="text-end"><strong>{{ $commande->total }} FCFA</strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Statut paiement -->
        <div class="mt-3">
            @if($commande->paiement)
                <div class="alert alert-success">
                    ✅ Payée le {{ $commande->paiement->date_paiement->format('d/m/Y H:i') }}
                </div>
            @else
                <div class="alert alert-warning">
                    ⏳ En attente de paiement
                </div>
            @endif
        </div>

        <!-- Pied de page -->
        <div class="text-center mt-4 text-muted">
            <small>Merci pour votre commande chez ISI Burger 🍔</small>
        </div>
    </div>
</div>
</body>
</html>
