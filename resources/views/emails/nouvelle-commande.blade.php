@component('mail::message')
# Nouvelle Commande #{{ $commande->id }}

Une nouvelle commande a été passée par {{ $commande->user->name }}.

**Détails de la commande :**

@component('mail::table')
| Burger | Quantité | Prix unitaire | Total |
|:-------|:---------|:--------------|:------|
@foreach($commande->burgers as $burger)
| {{ $burger->nom }} | {{ $burger->pivot->quantite }} | {{ number_format($burger->pivot->prix_unitaire, 2) }}€ | {{ number_format($burger->pivot->prix_unitaire * $burger->pivot->quantite, 2) }}€ |
@endforeach
@endcomponent

**Total de la commande :** {{ number_format($commande->total, 2) }}€

@component('mail::button', ['url' => route('gestionnaire.commandes.show', $commande->id)])
Voir les détails de la commande
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent 