<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeBurger extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'burger_id',
        'quantite',
        'prix_unitaire'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function burger()
    {
        return $this->belongsTo(Burger::class);
    }
}
