<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details table {
            width: 100%;
        }
        .invoice-details td {
            padding: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">ISI BURGER</div>
        <div>FACTURE</div>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td width="50%">
                    <strong>Facturé à :</strong><br>
                    {{ $commande->user->name }}<br>
                    {{ $commande->user->email }}
                </td>
                <td width="50%" style="text-align: right;">
                    <strong>Facture N° :</strong> {{ $commande->id }}<br>
                    <strong>Date :</strong> {{ $commande->created_at->format('d/m/Y') }}<br>
                    <strong>Statut :</strong> {{ $commande->status_fr }}
                </td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Produit</th>
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
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                <td><strong>{{ number_format($commande->total, 2) }} €</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>ISI BURGER - Le meilleur des burgers</p>
        <p>123 Rue de la Gastronomie, 75000 Paris</p>
        <p>Tél : 01 23 45 67 89 - Email : contact@isi-burger.com</p>
        <p>SIRET : 123 456 789 00012 - TVA : FR12 123 456 789</p>
    </div>
</body>
</html> 