<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use App\Mail\CommandePrete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;
use Carbon\Carbon;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['user', 'burgers'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('gestionnaire.commandes.index', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        $commande->load(['user', 'burgers']);
        return view('gestionnaire.commandes.show', compact('commande'));
    }

    public function updateStatus(Request $request, Commande $commande)
    {
        $request->validate([
            'status' => 'required|in:en_attente,en_preparation,pret,livre,annule'
        ]);

        $oldStatus = $commande->status;
        $newStatus = $request->status;

        // Vérifier les stocks avant de passer en préparation
        if ($newStatus === 'en_preparation') {
            foreach ($commande->burgers as $burger) {
                if ($burger->stock < $burger->pivot->quantite) {
                    return back()->with('error', "Stock insuffisant pour le burger {$burger->nom}");
                }
            }

            // Décrémenter les stocks
            foreach ($commande->burgers as $burger) {
                $burger->decrement('stock', $burger->pivot->quantite);
            }
        }

        // Mettre à jour le statut
        $commande->status = $newStatus;
        $commande->save();

        // Si la commande passe à "prêt", envoyer l'email avec la facture
        if ($newStatus === 'pret' && $oldStatus !== 'pret') {
            try {
                $pdf = PDF::loadView('pdf.facture', ['commande' => $commande]);
                Mail::to($commande->user->email)->send(new CommandePrete($commande, $pdf));
            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'envoi du mail : ' . $e->getMessage());
            }
        }

        // Si la commande est payée, créer un paiement
        if ($newStatus === 'payee' && $oldStatus !== 'payee') {
            Paiement::create([
                'commande_id' => $commande->id,
                'montant' => $commande->total,
                'date_paiement' => now(),
            ]);
        }

        return back()->with('success', 'Statut de la commande mis à jour avec succès');
    }

    public function cancel(Commande $commande)
    {
        if ($commande->status === 'en_preparation') {
            // Remettre les stocks
            foreach ($commande->burgers as $burger) {
                $burger->increment('stock', $burger->pivot->quantite);
            }
        }

        $commande->status = 'annulee';
        $commande->save();

        return back()->with('success', 'Commande annulée avec succès');
    }
} 