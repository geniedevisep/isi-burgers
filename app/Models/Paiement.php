<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'montant',
        'date_paiement',
        'mode_paiement'
    ];

    protected $dates = [
        'date_paiement'
    ];

    // Désactiver les timestamps si vous ne les utilisez pas
    public $timestamps = false;

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
