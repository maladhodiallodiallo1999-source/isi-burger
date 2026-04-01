<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - ISI Burger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🍔 Dashboard Gestionnaire</h2>
        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-danger">Se déconnecter</button>
        </form>
    </div>

    <!-- Liens rapides -->
    <div class="mb-4">
        <a href="/burgers" class="btn btn-warning me-2">🍔 Gérer les Burgers</a>
        <a href="/commandes" class="btn btn-primary">📋 Voir les Commandes</a>
    </div>

    <!-- Statistiques du jour -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h5>Commandes en cours</h5>
                    <h2>{{ $commandesEnCours }}</h2>
                    <p>Aujourd'hui</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h5>Commandes validées</h5>
                    <h2>{{ $commandesValidees }}</h2>
                    <p>Aujourd'hui</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h5>Recettes du jour</h5>
                    <h2>{{ number_format($recettesJour, 0, ',', ' ') }} FCFA</h2>
                    <p>Total paiements</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique commandes par mois -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>📊 Commandes par mois ({{ date('Y') }})</h5>
        </div>
        <div class="card-body">
            <canvas id="commandesChart" height="100"></canvas>
        </div>
    </div>

</div>

<script>
    const ctx = document.getElementById('commandesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($mois),
            datasets: [{
                label: 'Nombre de commandes',
                data: @json($dataCommandes),
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

</body>
</html>
