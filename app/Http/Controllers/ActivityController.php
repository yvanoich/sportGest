<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Activity;
use Symfony\Component\VarDumper\VarDumper;

class ActivityController extends Controller
{
    // Affiche l'aperçu d'une activité
    public function getActivity($ident)
    {

        // Vérification de la connexion
        $user = $this->getConnect();

        // Récupère l'activité sélectionné
        $activity = Activity::where('ident', '=', $ident)->firstOrFail();

        // Retour de la vue
        return view('activity', compact('user', 'activity'));
    }

    // Affiche le formulaire de création/modification d'une activité
    public function editActivity($ident = null)
    {

        // Vérification de la connexion
        $user = $this->getConnect();

        // Récupération de l'activité si elle existe
        $activity = null;
        $date = null;
        $time = null;
        $hours = null;
        $minutes = null;
        $secondes = null;
        if ($ident) {
            // Récupère l'activité sélectionné
            $activity = Activity::where('ident', '=', $ident)->firstOrFail();

            // Si l'ativité n'est pas celle de l'utilisateur connecté retourne sur l'aperçu avec une erreur
            if ($activity->util != $user->ident)
                return redirect('/get/activity/' . $ident)->withErrors(['error' => 'Vous n\'avez pas accès a cette page.']);

            // Diviser la date et l'heure
            list($datePart, $timePart) = explode(' ', $activity->date);
            $date = $datePart;
            $time = date('H:i', strtotime($timePart));

            // Récupère les données heures, minutes, secondes
            $hours = floor($activity->duration / 3600);
            $minutes = floor(($activity->duration % 3600) / 60);
            $secondes = $activity->duration % 60;
        }

        // Récupération de liste des sports
        $sports = Sport::all();

        // Retourne la vue
        return view('editActivity', compact("sports", 'activity', 'date', 'time', 'hours', 'minutes', 'secondes'));
    }

    // Créée / modifie l'activité
    public function setActivity(Request $request, $ident = null)
    {

        // Vérification de la connexion
        $user = $this->getConnect();

        // Instancie une activité
        $activity = new Activity();
        if ($ident)
            $activity = Activity::where('ident', '=', $ident)->firstOrFail();
        else
            $activity->util = $user->ident;

        // Vérification des données
        $request->validate([
            'name'                  => ['required', 'string', 'max:100'],
            'distance'              => ['required', 'numeric', 'regex:/^\d{1,6}([.,]\d{1,2})?$/'],
            'sport'                 => ['required', 'exists:sport,ident'],
            'date'                  => ['required', 'date'],
            'time'                  => ['required', 'date_format:H:i'],
            'height'                => ['nullable', 'integer'],
            'description'           => ['nullable', 'string', 'max:5000'],
            'private-description'   => ['nullable', 'string', 'max:2000'],
        ]);

        // Vérification sur la durée
        $request->validate([
            'hours'   => ['nullable', 'integer'],
            'minutes' => ['nullable', 'integer'],
            'secondes' => ['nullable', 'integer'],
        ], [
            'required' => 'Au moins un champ (heures, minutes, secondes) doit être renseigné.',
            'integer'  => 'Les champs doivent être des entiers.',
        ]);

        // Calcul de la durée de l'activité
        $hours = $request->input('hours', 0);
        $minutes = $request->input('minutes', 0);
        $secondes = $request->input('secondes', 0);
        $duration = ($hours * 3600) + ($minutes * 60) + $secondes;


        // Ajout des informations
        $activity->name = $request->input("name");
        $activity->distance = $request->input("distance");
        $activity->duration = $duration;
        $activity->sport = $request->input("sport");
        $activity->date = $request->input("date") . " " . $request->input("time");
        $activity->height = ($request->input("height") && $request->input("height") != "" ? $request->input("height") : null);
        $activity->description = ($request->input("description") && $request->input("description") != "" ? $request->input("description") : null);
        $activity->privateDescription = ($request->input("private-description") && $request->input("private-description") != "" ? $request->input("private-description") : null);

        // Enregistrement en base de l'activité
        $activity->save();

        // Si l'activité existe déjà retourner sur son aperçu
        return redirect('/get/activity/' . $activity->ident);
    }
}
