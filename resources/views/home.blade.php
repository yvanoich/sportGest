@extends('layouts.app')

@section('styles')
    <!-- Vos styles spécifiques pour cette vue -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
<div class="container home">
    @foreach ($activitys as $activity)
        <div class="bloc-activity">
            <div class="activity-util">{{ $activity->user->name }}</div>
            <div class="activity-date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->date)->locale('fr_FR')->format('d M Y à H:i') }}</div>
            <div class="activity-name"><a href="{{ route('activity-get', ['ident' => $activity->ident]) }}">{{ $activity->name }}</a></div>
            @if($activity->description)
                <div class="activity-description">{{ $activity->description }}</div>
            @endif
            <div class="informations">
            <?php
                $duration = \Carbon\CarbonInterval::seconds($activity->duration)->cascade();
                $formattedDuration = $duration->hours > 0 ? $duration->format('%H:%I:%S') : $duration->format('%I:%S');
            ?>
                <div class="activity-distance">{{ $activity->distance }} km</div>
                <div class="activity-average-speed">{{ \Carbon\CarbonInterval::seconds($activity->duration / $activity->distance)->cascade()->format('%I:%S') }} / km</div>
                <div class="activity-duration">{{ $formattedDuration }}</div>
            </div>
        </div>
    @endforeach
</div>
@endsection
