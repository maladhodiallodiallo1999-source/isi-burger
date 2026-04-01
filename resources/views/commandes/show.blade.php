<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Détail de la Commande #{{ $commande->id }}</h2>
    <a href="/commandes" class="btn btn-secondary mb-3">Retour</a>
    <a href="/commandes/{{ $commande->id }}/facture" class="btn btn-primary mb-3">🧾 Voir la facture</a>

    <p><strong>Client :</strong> {{ $commande->user->name }}</p>
    <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Total :</strong> {{ $commande->total }} FCFA</p>
    <p><strong>Statut :</strong> {{ $commande->statut }}</p>

    <h5 class="mt-4">Burgers commandés :</h5>
    <table class="table table-bordered bg-white">
        <thead class="table-danger">
            <tr>
                <th>Burger</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->burgers as $burger)
            <tr>
                <td>{{ $burger->nom }}</td>
                <td>{{ $burger->pivot->quantite }}</td>
                <td>{{ $burger->pivot->prix_unitaire }} FCFA</td>
                <td>{{ $burger->pivot->quantite * $burger->pivot->prix_unitaire }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="mt-4">Changer le statut :</h5>
    <form method="POST" action="/commandes/{{ $commande->id }}/statut">
        @csrf
        <select name="statut" class="form-select w-25 d-inline">
            <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="en_preparation" {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
            <option value="prete" {{ $commande->statut == 'prete' ? 'selected' : '' }}>Prête</option>
            <option value="payee" {{ $commande->statut == 'payee' ? 'selected' : '' }}>Payée</option>
        </select>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
    <div class="mt-4">
    @if($commande->paiement)
        <div class="alert alert-success">
            ✅ Commande payée le {{ $commande->paiement->date_paiement->format('d/m/Y H:i') }}
            — Montant : {{ $commande->paiement->montant }} FCFA
        </div>
    @else
        <a href="/commandes/{{ $commande->id }}/paiement" class="btn btn-success">
            💰 Enregistrer le paiement
        </a>
    @endif
</div>
</div>
</body>
</html>
