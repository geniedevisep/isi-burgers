<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Burger;
use Illuminate\Http\Request;
use App\Notifications\NouvelleCommande;
use App\Notifications\CommandePrete;
use PDF;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommandeConfirmation;
use App\Mail\NouvelleCommandeMail;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::where('user_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('client.commandes.index', compact('commandes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'burgers' => 'required|array',
            'burgers.*.id' => 'required|exists:burgers,id',
            'burgers.*.quantite' => 'required|integer|min:1'
        ]);

        $commande = Commande::create([
            'user_id' => auth()->id(),
            'status' => 'en_attente',
            'total' => 0
        ]);

        $total = 0;
        foreach ($validated['burgers'] as $item) {
            $burger = Burger::findOrFail($item['id']);
            if ($burger->stock < $item['quantite']) {
                return back()->with('error', 'Stock insuffisant pour ' . $burger->nom);
            }
            
            $commande->burgers()->attach($burger->id, [
                'quantite' => $item['quantite'],
                'prix_unitaire' => $burger->prix
            ]);
            
            $burger->decrement('stock', $item['quantite']);
            $total += $burger->prix * $item['quantite'];
        }

        $commande->update(['total' => $total]);
        
        // Email de confirmation au client
        Mail::to($commande->user->email)->send(new CommandeConfirmation($commande));

        try {
            // Notification aux gestionnaires
            $gestionnaires = User::where('role', 'gestionnaire')->get();
            
            foreach ($gestionnaires as $gestionnaire) {
                Mail::to($gestionnaire->email)
                    ->send(new NouvelleCommandeMail($commande));
            }

            return redirect()->route('commandes.show', $commande->id)
                            ->with('success', 'Commande créée avec succès et notifications envoyées.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi du mail : ' . $e->getMessage());
            return redirect()->route('commandes.show', $commande->id)
                            ->with('success', 'Commande créée avec succès.')
                            ->with('warning', 'L\'envoi des notifications a échoué.');
        }
    }

    public function show($id)
    {
        $commande = Commande::findOrFail($id);
        $this->authorize('view', $commande);
        return view('commandes.show', compact('commande'));
    }

    public function gestionnaireIndex()
    {
        $commandes = Commande::orderBy('created_at', 'desc')
                            ->paginate(10);
        return view('gestionnaire.commandes.index', compact('commandes'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:en_attente,en_preparation,prete,payee'
        ]);

        $commande = Commande::findOrFail($id);
        $commande->status = $validated['status'];
        $commande->save();

        if ($validated['status'] === 'prete') {
            // Générer et envoyer la facture PDF
            $pdf = PDF::loadView('factures.commande', compact('commande'));
            $commande->user->notify(new CommandePrete($commande, $pdf));
        }

        return back()->with('success', 'Statut de la commande mis à jour');
    }

    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        
        // Remettre les stocks
        foreach ($commande->burgers as $burger) {
            $burger->increment('stock', $burger->pivot->quantite);
        }
        
        $commande->delete();
        return redirect()->route('gestionnaire.commandes.index')
                        ->with('success', 'Commande annulée avec succès');
    }
}
