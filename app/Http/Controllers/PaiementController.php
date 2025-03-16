<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Http\Request;
use PDF;
use DB;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with(['commande.user'])
                        ->orderBy('date_paiement', 'desc');

        if ($request->filled('date_debut')) {
            $query->whereDate('date_paiement', '>=', $request->date_debut);
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date_paiement', '<=', $request->date_fin);
        }

        $paiements = $query->paginate(15);

        return view('gestionnaire.paiements.index', compact('paiements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:especes'
        ]);

        DB::beginTransaction();
        try {
            $commande = Commande::findOrFail($validated['commande_id']);
            
            // Vérifier si la commande n'est pas déjà payée
            if ($commande->status === 'payee') {
                return back()->with('error', 'Cette commande a déjà été payée.');
            }

            // Vérifier si le montant correspond au total de la commande
            if ($validated['montant'] != $commande->total) {
                return back()->with('error', 'Le montant du paiement ne correspond pas au total de la commande.');
            }

            // Créer le paiement
            $paiement = Paiement::create([
                'commande_id' => $commande->id,
                'montant' => $validated['montant'],
                'mode_paiement' => $validated['mode_paiement'],
                'date_paiement' => now()
            ]);

            // Mettre à jour le statut de la commande
            $commande->update(['status' => 'payee']);

            DB::commit();

            // Générer et envoyer la facture
            $this->generateAndSendFacture($paiement);

            return back()->with('success', 'Paiement enregistré avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Une erreur est survenue lors de l\'enregistrement du paiement.');
        }
    }

    public function facture(Paiement $paiement)
    {
        $pdf = PDF::loadView('factures.paiement', [
            'paiement' => $paiement,
            'commande' => $paiement->commande
        ]);

        return $pdf->download('facture-' . $paiement->id . '.pdf');
    }

    private function generateAndSendFacture(Paiement $paiement)
    {
        $pdf = PDF::loadView('factures.paiement', [
            'paiement' => $paiement,
            'commande' => $paiement->commande
        ]);

        // Envoyer la facture par email au client
        $paiement->commande->user->notify(new FactureGeneree($paiement, $pdf));
    }
}
