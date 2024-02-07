<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\Activity;
use App\Models\Followers;
use Carbon\Carbon;

class ProfileController extends Controller
{
    // Affiche le profile
    public function getProfile($ident){
        // Rechercher l'utilisateur par rapport a l'ident de la route
        $user = User::where('ident', $ident)->firstOrFail();

        // Vérifier si l'utilisateur est connecté
        $userConnect=$this->getConnect();

        // Récupération des activités de l'utilisateur selon l'ident
        $activitys = Activity::with('user')->where('util', '=', $user->ident)->orderBy('date', 'desc')->get();

        // Calcul des moyenne sur les 4 dernières semaine
        $average=[
            "distance"      => 0,
            "duration"      => 0,
            "height"        => 0,
            "nbreActivity"  => 0
        ];
        // Obtenir la date d'il y a 4 semaines
        $dateActuelle = Carbon::now();
        $date4Semaines = $dateActuelle->subWeeks(4);

        foreach($activitys as $activity){
            $dateActivity=Carbon::parse($activity->date);

            //si la date est entre ajd et il y a 4 semaines alors la compter dans les stats sinon arrêter la boucle
            if($date4Semaines->lt($dateActivity)){
                $average["nbreActivity"]++;
                $average["distance"]+=$activity->distance;
                $average["duration"]+=$activity->duration;
                $average["height"]+=($activity->height? $activity->height : 0);
            }
            else
                break;
        }
        
        // Diviser tous les champs par 4 avec arrondi (4 semaines)
        $average["distance"] = round($average["distance"] / 4, 1)." km";
        $average["duration"] = round($average["duration"] / 4);
        $average["height"] = round($average["height"] / 4)." m";
        $average["nbreActivity"] = round($average["nbreActivity"] / 4);
        

        // Convertir les secondes en heures et minutes
        $hours = floor($average["duration"] / 3600);
        $minutes = round(($average["duration"] % 3600) / 60);
        $average["duration"] = sprintf('%02dh %02dmin', $hours, $minutes);

        $isFollowed=Followers::where('util', '=', $userConnect->ident)->where('followed', '=', $user->ident)->exists();

        return view('profile', compact('activitys', 'user', 'average', 'userConnect', 'isFollowed'));
    }

    // Met à jour le profile
    public function setProfile(Request $request){
        // Vérifier si l'utilisateur est connecté
        $user=$this->getConnect();

        // Vérification du nom
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        // Ajout du nom
        $user->name=$request->input('name');

        // Si l'email à changé faire les vérifications
        if($user->email!=$request->input('email')){
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            // Ajout du nouvel email
            $user->email=$request->input('email');
        }

        // Si l'utilisateur veut modifier son mot de passe ajouter les vérification + la modification de celui-ci
        if($request->input('password')){
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            // Hash du mot de passe
            $user->password = Hash::make($request->input('password'));
        }

        // Mise à jour de l'utilisateur en base
        $user->save();

        if($request->hasFile('profile_image')){
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            $image = $request->file('profile_image');
            $imageName = $user->ident.'.jpg';
            $imagePath = public_path('images/profiles/'.$imageName);
            $image->move('images/profiles', $imageName);
        }       

        // Retourne la vue
        return view('settings', compact('user'))->with('success', 'Profil mis à jour avec succès');
    }

    // Affichage des statistiques du profile (public)
    public function getSettingsProfile(){
        $user=$this->getConnect();
        return view('settings', compact('user'));
    }

    // Perme de suivre un compte
    public function followProfil($ident){
        // Rechercher l'utilisateur par rapport a l'ident de la route
        $user = User::where('ident', $ident)->firstOrFail();

        // Vérifier si l'utilisateur est connecté
        $userConnect=$this->getConnect();

        // Si l'utilisateur est déjà abonner alors le supprimer sinon créer l'abonnement
        if(Followers::where('util', '=', $userConnect->ident)->where('followed', '=', $user->ident)->exists())
            Followers::where('util', '=', $userConnect->ident)->where('followed', '=', $user->ident)->delete();
        else{
            $newFollow=new Followers();
            $newFollow->util=$userConnect->ident;
            $newFollow->followed=$user->ident;
            $newFollow->save();
        }
        
        return $this->getProfile($ident);
    }
}
