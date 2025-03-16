<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prix',
        'description',
        'image',
        'stock',
        'categorie',
        'archived'
    ];

    public function commandeBurgers()
    {
        return $this->hasMany(CommandeBurger::class);
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_burgers')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
}
