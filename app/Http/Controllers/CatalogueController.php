<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $query = Burger::where('archived', false);

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtre par prix
        if ($request->filled('prix')) {
            switch ($request->prix) {
                case 'asc':
                    $query->orderBy('prix', 'asc');
                    break;
                case 'desc':
                    $query->orderBy('prix', 'desc');
                    break;
            }
        }

        $burgers = $query->where('stock', '>', 0)
                        ->orderBy('nom')
                        ->paginate(12);

        return view('catalogue.index', compact('burgers'));
    }

    public function show(Burger $burger)
    {
        return view('catalogue.show', compact('burger'));
    }

    public function ajouterAuPanier(Request $request, Burger $burger)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1|max:' . $burger->stock
        ]);

        $panier = session()->get('panier', []);
        $quantite = $request->quantite;

        if (isset($panier[$burger->id])) {
            $panier[$burger->id]['quantite'] += $quantite;
        } else {
            $panier[$burger->id] = [
                'nom' => $burger->nom,
                'prix' => $burger->prix,
                'quantite' => $quantite,
                'image' => $burger->image
            ];
        }

        session()->put('panier', $panier);
        return back()->with('success', 'Burger ajouté au panier avec succès');
    }
} 