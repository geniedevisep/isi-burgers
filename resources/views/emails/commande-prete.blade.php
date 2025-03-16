<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Votre commande est prête !</h1>
        </div>

        <p>Bonjour {{ $commande->user->name }},</p>

        <p>Nous sommes heureux de vous informer que votre commande n°{{ $commande->id }} est maintenant prête !</p>

        <div class="details">
            <h3>Récapitulatif de votre commande :</h3>
            <ul>
                @foreach($commande->burgers as $burger)
                    <li>{{ $burger->pivot->quantite }}x {{ $burger->nom }}</li>
                @endforeach
            </ul>
            <p><strong>Total : </strong>{{ number_format($commande->total, 2) }} €</p>
        </div>

        <p>Vous trouverez votre facture en pièce jointe de cet email.</p>

        <p>Nous vous remercions de votre confiance et espérons vous revoir bientôt !</p>

        <div class="footer">
            <p>ISI BURGER - Le meilleur des burgers</p>
            <p>Pour toute question, contactez-nous à contact@isi-burger.com</p>
        </div>
    </div>
</body>
</html> 