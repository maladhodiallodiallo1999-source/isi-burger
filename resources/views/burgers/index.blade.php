<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Burgers - ISI Burger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>🍔 Gestion des Burgers</h2>
    <a href="/burgers/create" class="btn btn-success mb-3">+ Ajouter un burger</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered bg-white">
        <thead class="table-danger">
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($burgers as $burger)
            <tr>
                <td>
                    @if($burger->image)
                        <img src="{{ asset('storage/'.$burger->image) }}" width="60">
                    @else
                        Aucune
                    @endif
                </td>
                <td>{{ $burger->nom }}</td>
                <td>{{ $burger->prix }} FCFA</td>
                <td>{{ $burger->stock }}</td>
                <td>
                    @if($burger->archive)
                        <span class="badge bg-secondary">Archivé</span>
                    @else
                        <span class="badge bg-success">Actif</span>
                    @endif
                </td>
                <td>
                    <a href="/burgers/edit/{{ $burger->id }}" class="btn btn-sm btn-warning">Modifier</a>

                    @if($burger->archive)
                        <a href="/burgers/desarchiver/{{ $burger->id }}" class="btn btn-sm btn-success">Désarchiver</a>
                    @else
                        <a href="/burgers/archiver/{{ $burger->id }}" class="btn btn-sm btn-secondary">Archiver</a>
                    @endif

                    <form method="POST" action="/burgers/{{ $burger->id }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
