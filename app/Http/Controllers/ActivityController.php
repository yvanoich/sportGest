<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function getActivity($ident = null){
        // Vérification de la connexion
        $this->getConnect();

        // Récupération de liste des sports
        $sports=Sport::all();

        // Récupération de l'activité si elle existe
        $activity=null;
        $date=null;
        $time=null;
        if($ident!=""){
            $activity=Activity::where('ident', '=', $ident)->firstOrFail();

            // Diviser la date et l'heure
            list($datePart, $timePart) = explode(' ', $activity->date);
            $date=$datePart;
            $time=date('H:i', strtotime($timePart));
        }

        return view('activity', compact("sports", 'activity', 'date', 'time'));
    }

    public function setActivity(Request $request, $ident = null){
        // Instancie une activité
        $activity=new Activity();
        if($ident!="")
            $activity=Activity::where('ident', '=', $ident)->firstOrFail();

        // Vérification des données obligatoire
        $request->validate([
            'name'      => ['required', 'string', 'max:100'],
            'distance'  => ['required', 'numeric', 'regex:/^\d{1,6}([.,]\d{1,2})?$/'],
            'duration'  => ['required', 'int'],
            'sport'     => ['required', 'exists:sport,ident'],
            'date'      => ['required', 'date'],
            'time'      => ['required', 'date_format:H:i']
        ]);

        // Ajout des informations obligatoire
        $activity->name=$request->input("name");
        $activity->distance=$request->input("distance");
        $activity->duration=$request->input("duration");
        $activity->sport=$request->input("sport");
        $activity->date=$request->input("date")." ".$request->input("time");

        // Vérification des données optionnel + ajout à l'activité
        if($request->input("height")){
            $request->validate([
                'height'    => ['required', 'int'],
            ]);

            // Ajout du dénivelé
            $activity->height=$request->input("height");
        }

        if($request->input("description")){
            $request->validate([
                'description'    => ['required', 'string', 'max:5000'],
            ]);

            // Ajout de la description
            $activity->description=$request->input("description");
        }

        // Enregistrement en base de l'activité
        $activity->save();

        return redirect('/dashboard');
    }
}
