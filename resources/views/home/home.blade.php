@extends('layout/default')
@section('content')
<main class="main">

    @if (session()->has('error'))
        <div class="error-message-box error-message-box-auth">
            <p class="error-message-p">{{ session()->get('error') }}</p>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="error-message-box error-message-box-auth success-message-box">
            <p class="error-message-p">{{ session()->get('success') }}</p>
        </div>
    @endif

    <h2 class="main-home-title">Accueil</h2>
    <div class="main-first-img-box">
        <img class="main-first-img-img" src="{{ asset('/assets/images/pizza-dough.jpg') }}" />
    </div>
    <div class="main-first-text-box">
        <p class="main-first-text-p">
            Ici, pas de chichi, une petite faim? Grosse envie? Une pizza bien sur!
            Sur Tapizzamaison, c'est l'assurance d'avoir une pizza faite "maison".
            Des ingrédients de qualité, une pâte préparée avec amour par un passionné
            dont mon seul souhait et de vous satisfaire.
            Faites vous plaisir, et bonne dégustation!
            <span class="main-first-text-p-span">
                Jb, votre pizzaiolo.
            </span>
        </p>
    </div>
</main>
@stop
