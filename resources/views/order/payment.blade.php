@extends('layout/default')
@section('content')

<main class="main">

    <h2 class='main-home-title'>Paiement</h2>

    <div class="new-order-box">

        {{ Form::open(array('method' => 'POST', 'class' => 'new-order-form payment-form')) }}
            @csrf

            <label for="input-fullname-payment" class="label-input-fullname">Nom et prénom inscrits sur la carte</label>
            <input type="text" name="input-fullname-payment" class="input-fullname-payment" id="input-fullname-payment"/>

            <label for="input-card-number" class="label-input-card-number">Numéro de carte</label>
            <input type="text" name="input-card-number" class="input-card-number" id="input-card-number"/>
            
            <p class="expiration-text">Date d'expiration</p>

            <div class="wrap-month-card">
                <label for="select-month-card" class="label-select-month-card">Mois</label>
                <select name="select-month-card" class="select-month-card" id="select-month-card">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="wrap-year-card">
                <label for="select-year-card" class="label-select-year-card">Année</label>
                <select name="select-year-card" class="select-year-card" id="select-year-card">
                    @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        {{ Form::close() }}
    </div>
</main>