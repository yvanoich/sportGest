@extends('layouts.app')

@section('styles')
<!-- Vos styles spécifiques pour cette vue -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
<div class="container home">
    @foreach ($activitys as $activity)
    <div class="bloc-activity">
        <div class="activity-logo">
            <img src="{{ file_exists(public_path('images/profiles/' . $activity->user->ident . '.jpg')) ? asset('images/profiles/' . $activity->user->ident . '.jpg') : asset('images/profiles/icone_user.jpg') }}" alt="Image de profil">
            <br />
            <img class="img-sport" src="{{ asset('images/sport/' . $activity->sport . '.png') }}">
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
@endsection