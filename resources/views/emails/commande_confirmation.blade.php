<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:20px;">
<div style="max-width:600px; margin:auto; background:#fff; padding:30px; border-radius:8px;">

    <h2 style="color:#dc3545;">🍔 ISI Burger</h2>
    <p>Bonjour <strong>{{ $commande->user->name }}</strong>,</p>
    <p>Votre commande <strong>#{{ $commande->id }}</strong> a bien été reçue et est en cours de traitement.</p>

    <table width="100%" border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse; margin:20px 0;">
        <thead style="background:#dc3545; color:#fff;">
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
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>{{ $commande->total }} FCFA</strong></td>
            </tr>
        </tfoot>
    </table>

    <p>Merci pour votre commande !</p>
    <p style="color:#dc3545;"><strong>ISI Burger</strong></p>
</div>
</body>
</html>
