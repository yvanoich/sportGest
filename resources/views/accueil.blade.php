<!-- Exemple d'utilisation d'un layout dans une vue -->
@extends('layouts.app')

@section('title', 'Page Exemple')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/exemple.css') }}">
@endsection

@section('content')
    <h1>Contenu de la page exemple</h1>
@endsection

@section('scripts')
    <script src="{{ asset('js/exemple.js') }}"></script>
@endsection