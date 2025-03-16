<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Burger;
use App\Models\CommandeBurger;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Commandes en cours (en attente + en préparation)
        $commandesEnCours = Commande::whereIn('status', ['en_attente', 'en_preparation'])->count();

        // Recettes du jour
        $recettesJour = Commande::whereDate('created_at', Carbon::today())
            ->where('status', 'paye')
            ->sum('total');

        // Burgers en rupture ou stock faible
        $burgersEnRupture = Burger::where('stock', '<=', 5)
            ->where('archived', false)
            ->get();

        // Commandes récentes
        $commandesRecentes = Commande::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Statistiques des ventes
        $statsVentes = Burger::where('archived', false)
            ->withCount(['commandes' => function($query) {
                $query->whereMonth('commandes.created_at', Carbon::now()->month);
            }])
            ->orderBy('commandes_count', 'desc')
            ->take(5)
            ->get();

        return view('gestionnaire.dashboard', compact(
            'commandesEnCours',
            'recettesJour',
            'burgersEnRupture',
            'commandesRecentes',
            'statsVentes'
        ));
    }
} 