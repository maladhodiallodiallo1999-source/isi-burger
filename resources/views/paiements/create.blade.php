<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement - ISI Burger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>💰 Enregistrer un Paiement</h2>
    <a href="/commandes/{{ $commande->id }}" class="btn btn-secondary mb-3">Retour</a>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>Client :</strong> {{ $commande->user->name }}</p>
            <p><strong>Commande #:</strong> {{ $commande->id }}</p>
            <p><strong>Total à payer :</strong>
                <span class="text-danger fw-bold">{{ $commande->total }} FCFA</span>
            </p>

            <form method="POST" action="/commandes/{{ $commande->id }}/paiement">
                @csrf
                <p>Paiement en espèces de <strong>{{ $commande->total }} FCFA</strong></p>
                <button type="submit" class="btn btn-success">
                    Confirmer le paiement
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
