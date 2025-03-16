<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with(['commande.user'])
            ->orderBy('date_paiement', 'desc')
            ->paginate(10);

        return view('gestionnaire.paiements.index', compact('paiements'));
    }

    public function store(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:especes'
        ]);

        DB::beginTransaction();
        try {
            // Vérifier si la commande n'est pas déjà payée
            if ($commande->status === 'paye') {
                return back()->with('error', 'Cette commande a déjà été payée.');
            }

            // Vérifier si la commande est prête
            if ($commande->status !== 'pret') {
                return back()->with('error', 'La commande doit être prête avant d\'être payée.');
            }

            // Vérifier si le montant correspond au total de la commande
            if ($validated['montant'] != $commande->total) {
                return back()->with('error', 'Le montant du paiement ne correspond pas au total de la commande.');
            }

            // Créer le paiement
            $paiement = new Paiement([
                'montant' => $validated['montant'],
                'mode_paiement' => $validated['mode_paiement'],
                'date_paiement' => now()
            ]);

            // Associer le paiement à la commande
            $commande->paiement()->save($paiement);

            // Mettre à jour le statut de la commande en utilisant DB::raw pour s'assurer que la valeur est correctement échappée
            $commande->status = DB::raw("'paye'");
            $commande->save();

            DB::commit();

            return back()->with('success', 'Paiement enregistré avec succès.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors du paiement de la commande #' . $commande->id . ': ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement du paiement : ' . $e->getMessage());
        }
    }
}