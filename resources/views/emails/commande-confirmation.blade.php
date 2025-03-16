<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; }
        .details { background: #f8f9fa; padding: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Merci pour votre commande !</h1>
        </div>

        <p>Bonjour {{ $commande->user->name }},</p>

        <p>Nous avons bien reçu votre commande n°{{ $commande->id }}.</p>

        <div class="details">
            <h3>Récapitulatif :</h3>
            <ul>
                @foreach($commande->burgers as $burger)
                    <li>{{ $burger->pivot->quantite }}x {{ $burger->nom }}</li>
                @endforeach
            </ul>
            <p><strong>Total : </strong>{{ number_format($commande->total, 2) }} €</p>
        </div>

        <p>Nous vous informerons dès que votre commande sera prête !</p>

        <div class="footer">
            <p>ISI BURGER - Le meilleur des burgers</p>
        </div>
    </div>
</body>
</html> 