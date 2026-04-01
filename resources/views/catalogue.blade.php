<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue - ISI Burger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>🍔 Catalogue des Burgers</h2>

    <form method="POST" action="/logout" class="mb-3">
        @csrf
        <button class="btn btn-danger">Se déconnecter</button>
    </form>

    <a href="/mes-commandes" class="btn btn-primary mb-3">Mes commandes</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/commandes">
        @csrf
        <div class="row">
            @foreach($burgers as $burger)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if($burger->image)
                        <img src="{{ asset('storage/'.$burger->image) }}" class="card-img-top" height="150" style="object-fit:cover">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $burger->nom }}</h5>
                        <p class="card-text">{{ $burger->description }}</p>
                        <p class="text-danger fw-bold">{{ $burger->prix }} FCFA</p>
                        <p>Stock : {{ $burger->stock }}</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="burgers[]" value="{{ $burger->id }}" id="burger{{ $burger->id }}">
                            <label class="form-check-label" for="burger{{ $burger->id }}">Commander</label>
                        </div>
                        <input type="number" name="quantites[]" value="1" min="1" max="{{ $burger->stock }}" class="form-control mt-2">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-success mt-3">Passer la commande</button>
    </form>
</div>
</body>
</html>
