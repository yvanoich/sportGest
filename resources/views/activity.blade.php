@extends('layouts.app')

@section('styles')
<!-- Vos styles spécifiques pour cette vue -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/activity.css') }}">
@endsection


@section('content')
<div class="container">
    <div class="container-middle">
        <div class="activity-informations">
            <div class="lyrics">
                <div class="logo">
                    <img src="{{ file_exists(public_path('images/profiles/' . $activity->user->ident . '.jpg')) ? asset('images/profiles/' . $activity->user->ident . '.jpg') : asset('images/profiles/icone_user.jpg') }}" alt="Image de profil">
                </div>
                <div class="lyric-informations">
                    <div class="activity-date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->date)->locale('fr_FR')->isoFormat('dddd D MMMM YYYY à HH:mm') }}</div>
                    <div class="activity-name">{{ $activity->name }}</div>
                    <div class="activity-description">{{ $activity->description }}</div>
                    @if($user->ident==$activity->util)
                    <div class="activity-description">{{ $activity->privateDescription }}</div>
                    <a class="activity-edit" href="{{ route('activity-edit', ['ident' => $activity->ident]) }}">Editer</a>
                    @endif
                </div>
            </div>
            <div class="numeric">
                <div class="activity-stats">
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
    </div>
</div>
@endsection