<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        return view('client.profil.show', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['required', 'string', 'max:255'],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return back()->with('success', 'Profil mis à jour avec succès');
    }
} 