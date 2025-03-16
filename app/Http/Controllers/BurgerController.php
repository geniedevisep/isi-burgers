<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    public function index()
    {
        $burgers = Burger::where('stock', '>', 0)
                        ->orderBy('nom')
                        ->paginate(12);
        
        return view('catalogue.index', compact('burgers'));
    }

    public function show(Burger $burger)
    {
        if ($burger->stock <= 0) {
            abort(404);
        }
        
        return view('catalogue.show', compact('burger'));
    }

    public function filter(Request $request)
    {
        $query = Burger::where('stock', '>', 0);

        if ($request->has('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->has('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        if ($request->has('libelle')) {
            $query->where('nom', 'like', '%' . $request->libelle . '%');
        }

        $burgers = $query->orderBy('nom')->paginate(12);
        
        if ($request->ajax()) {
            return view('catalogue.partials.burger-list', compact('burgers'));
        }

        return view('catalogue.index', compact('burgers'));
    }

    public function create()
    {
        return view('gestionnaire.burgers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0',
            'categorie' => 'required|string|max:255'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
            $validated['image'] = $imagePath;
        }

        Burger::create($validated);

        return redirect()->route('gestionnaire.burgers.index')
                        ->with('success', 'Burger ajouté avec succès');
    }

    public function edit($id)
    {
        $burger = Burger::findOrFail($id);
        return view('gestionnaire.burgers.edit', compact('burger'));
    }

    public function update(Request $request, $id)
    {
        $burger = Burger::findOrFail($id);
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
            $validated['image'] = $imagePath;
        }

        $burger->update($validated);

        return redirect()->route('gestionnaire.burgers.index')
                        ->with('success', 'Burger mis à jour avec succès');
    }

    public function destroy($id)
    {
        $burger = Burger::findOrFail($id);
        $burger->archived = true;
        $burger->save();

        return redirect()->route('gestionnaire.burgers.index')
                        ->with('success', 'Burger archivé avec succès');
    }
}
