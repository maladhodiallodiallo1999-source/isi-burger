<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Burger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Modifier le Burger</h2>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="/burgers/{{ $burger->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $burger->nom }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prix (FCFA)</label>
            <input type="number" name="prix" class="form-control" value="{{ $burger->prix }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $burger->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $burger->stock }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Image actuelle</label><br>
            @if($burger->image)
                <img src="{{ asset('storage/'.$burger->image) }}" width="80" class="mb-2"><br>
            @endif
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-warning">Mettre à jour</button>
        <a href="/burgers" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
