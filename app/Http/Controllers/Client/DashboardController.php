<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Commande;

class DashboardController extends Controller
{
    public function index()
    {
        $dernieresCommandes = Commande::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('client.dashboard', compact('dernieresCommandes'));
    }
} 