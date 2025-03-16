<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show()
    {
        return view('client.profil.show');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'telephone' => 'required|string',
            'adresse' => 'required|string',
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Profil mis à jour avec succès');
    }
} 