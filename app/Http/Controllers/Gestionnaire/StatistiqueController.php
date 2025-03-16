<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Burger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Statistiques journalières
        $today = Carbon::today();
        $commandesEnCours = Commande::whereDate('created_at', $today)
            ->whereNotIn('status', ['payee', 'annulee'])
            ->count();

        $commandesValidees = Commande::whereDate('created_at', $today)
            ->where('status', 'payee')
            ->count();

        $recettesJour = Paiement::whereDate('date_paiement', $today)
            ->sum('montant');

        // Données pour le graphique des commandes par mois
        $commandesParMois = Commande::select(
            DB::raw('MONTH(created_at) as mois'),
            DB::raw('YEAR(created_at) as annee'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('mois', 'annee')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        // Données pour le graphique des produits par catégorie
        $produitsParCategorie = Burger::select(
            'categorie',
            DB::raw('MONTH(created_at) as mois'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('categorie', 'mois')
            ->orderBy('mois')
            ->get();

        return view('gestionnaire.statistiques.index', compact(
            'commandesEnCours',
            'commandesValidees',
            'recettesJour',
            'commandesParMois',
            'produitsParCategorie'
        ));
    }
} 