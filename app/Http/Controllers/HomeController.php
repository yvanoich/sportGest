<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Activity;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Vérification sur la connexion
        $user=$this->getConnect();

        // Récupération des activités de l'utilisateur connecté
        $activitys = Activity::with('user')->orderBy('created_at', 'desc')->get();

        // Retour de la vue avec les données récupéré plus haut
        return view('home', compact('user', 'activitys'));
    }
}
