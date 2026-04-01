<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Mes Commandes</h2>
    <a href="/catalogue" class="btn btn-secondary mb-3">Retour au catalogue</a>

    <table class="table table-bordered bg-white">
        <thead class="table-danger">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
            <tr>
                <td>{{ $commande->id }}</td>
                <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $commande->total }} FCFA</td>
                <td>
                    @if($commande->statut == 'en_attente')
                        <span class="badge bg-warning text-dark">En attente</span>
                    @elseif($commande->statut == 'en_preparation')
                        <span class="badge bg-info">En préparation</span>
                    @elseif($commande->statut == 'prete')
                        <span class="badge bg-success">Prête</span>
                    @elseif($commande->statut == 'payee')
                        <span class="badge bg-primary">Payée</span>
                    @elseif($commande->statut == 'annulee')
                        <span class="badge bg-danger">Annulée</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
