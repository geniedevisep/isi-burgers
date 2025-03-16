<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status'
    ];

    // Définir les statuts possibles
    const STATUTS = [
        'en_attente',
        'en_preparation',
        'pret',
        'livre',
        'annule',
        'paye'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function burgers()
    {
        return $this->belongsToMany(Burger::class, 'commande_burgers')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'en_attente' => 'En attente',
            'en_preparation' => 'En préparation',
            'pret' => 'Prêt',
            'livre' => 'Livré',
            'annule' => 'Annulé',
            'paye' => 'Payé'
        ][$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return [
            'en_attente' => 'warning',
            'en_preparation' => 'info',
            'pret' => 'success',
            'livre' => 'secondary',
            'annule' => 'danger',
            'paye' => 'primary'
        ][$this->status] ?? 'primary';
    }
}
