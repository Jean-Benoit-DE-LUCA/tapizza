@extends('layout/default')
@section('content')
<section class="section-propositions main">
    <h2 class="section-propositions-title">Propositions du chef</h2>
    <div class="section-propositions-first-div-img propositions">
        <img class="section-propositions-first-img" src="{{ asset('/assets/images/propositions-chef.png') }}" />
    </div>
    <div class="section-propositions-div">

    @foreach ($getProposals as $pizza)
            <div class="grid-propositions">
                <img class="grid-propositions-img" src="{{ asset($pizza->image_path) }}" />
                <h2 class="grid-propositions-h2">{{ $pizza->title }}</h2>
                <p class="grid-propositions-p">{{ $pizza->description }}</p>
                <span class="grid-propositions-p-price">{{ $pizza->price }}€</span>
                <button class="grid-propositions-button" type="button" name="grid-propositions-{{ $pizza->id }}">Ajouter à la commande</button>
            </div>
    @endforeach

    </div>
</section>
@endsection
