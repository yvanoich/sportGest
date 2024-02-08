@extends('layouts.app')

@section('styles')
    <!-- Vos styles spécifiques pour cette vue -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/athlete.css') }}">
@endsection


@section('content')
<div class="container">
    <div class="athlete-informations">
        <div class="left">
            <div class="athlete-logo">
                <img src="{{ file_exists(public_path('images/profiles/' . $user->ident . '.jpg')) ? asset('images/profiles/' . $user->ident . '.jpg') : asset('images/profiles/icone_user.jpg') }}" alt="Image de profil">
                <br/>
                <label>{{ $user->name }}</label>
                @if($userConnect->ident!=$user->ident)
                    <form method="POST" action="{{ route('stats-profile-follow', ['ident' => $user->ident]) }}">
                        @csrf
                        
                        @if($isFollowed)
                            <button class="abo" type="submit">Se désabonner</button>
                        @else
                            <button class="not-abo" type="submit">S'abonner</button>
                        @endif
                    </form>
                @endif
            </div>
        </div>
        <div class="right">

        </div>
    </div>
    <div class="athlete-activitys">
        <div class="left">
            <label class="athlete-title">{{ __('Ativités') }}</label>
            @foreach ($activitys as $activity)
                <div class="bloc-activity">
                    <div class="activity-logo">
                        <img src="{{ file_exists(public_path('images/profiles/' . $activity->user->ident . '.jpg')) ? asset('images/profiles/' . $activity->user->ident . '.jpg') : asset('images/profiles/icone_user.jpg') }}" alt="Image de profil">
                    </div>
                    <div class="activity-right">
                        <div class="activity-util"><a href="{{ route('stats-profile-get', ['ident' => $activity->user->ident]) }}">{{ $activity->user->name }}</a></div>
                        <div class="activity-date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->date)->locale('fr_FR')->isoFormat('dddd D MMMM YYYY à HH:mm') }}</div>
                        <div class="activity-name"><a href="{{ route('activity-get', ['ident' => $activity->ident]) }}">{{ $activity->name }}</a></div>
                        @if($activity->description)
                            <div class="activity-description">{{ $activity->description }}</div>
                        @endif
                        <div class="informations">
                        <?php
                            $duration = \Carbon\CarbonInterval::seconds($activity->duration)->cascade();
                            $formattedDuration = $duration->hours > 0 ? $duration->format('%Hh %Imin %Ss') : $duration->format('%Imin %Ss');
                        ?>
                            <div class="activity-distance">{{ $activity->distance }} km</div>
                            <div class="activity-average-speed">{{ \Carbon\CarbonInterval::seconds($activity->duration / $activity->distance)->cascade()->format('%I:%S') }} / km</div>
                            <div class="activity-duration">{{ $formattedDuration }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="right">
            <label class="athlete-title">{{ __('Statistiques') }}</label>
            <div class="athlete-average">
                <div class="title">4 dernières semaines</div>
                <div class="group">
                    <div class="group-title">
                        <div>Activités / semaine</div>
                        <div>Distance / semaine</div>
                        <div>Durée / semaine</div>
                        <div>Dénivelé / semaine</div>
                    </div>
                    <div class="group-value">
                        <div>{{ $average["nbreActivity"] }}</div>
                        <div>{{ $average["distance"] }}</div>
                        <div>{{ $average["duration"] }}</div>
                        <div>{{ $average["height"] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
