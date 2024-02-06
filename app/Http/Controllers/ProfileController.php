<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    // Affiche le profile
    public function getProfile(){
        $user=$this->getConnect();
        return view('profile', compact('user'));
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
        return view('profile', compact('user'))->with('success', 'Profil mis à jour avec succès');
    }
}
