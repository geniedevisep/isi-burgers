<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $paiement->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .info-block {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ISI BURGER</h1>
        <p>Facture #{{ $paiement->id }}</p>
    </div>

    <div class="info-block">
        <h3>Informations client</h3>
        <p>{{ $commande->user->name }}</p>
        <p>{{ $commande->user->email }}</p>
    </div>

    <div class="info-block">
        <h3>Détails de la commande #{{ $commande->id }}</h3>
        <p>Date de commande : {{ $commande->created_at->format('d/m/Y H:i') }}</p>
        <p>Date de paiement : {{ $paiement->date_paiement->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Article</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->burgers as $burger)
            <tr>
                <td>{{ $burger->nom }}</td>
                <td>{{ number_format($burger->pivot->prix_unitaire, 2) }} €</td>
                <td>{{ $burger->pivot->quantite }}</td>
                <td>{{ number_format($burger->pivot->prix_unitaire * $burger->pivot->quantite, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total : {{ number_format($paiement->montant, 2) }} €</p>
        <p>Mode de paiement : {{ ucfirst($paiement->mode_paiement) }}</p>
    </div>

    <div style="margin-top: 50px; text-align: center;">
        <p>Merci de votre confiance !</p>
    </div>
</body>
</html> 