<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Vérification si l'utilisateur est connecté
    public function getConnect(){
        // Vérification de la connection
        if($user=Auth::user())
            return $user;

        // Redirige l'utilisateur si il n'est pas connecté
        return redirect('/login');
    }
}
