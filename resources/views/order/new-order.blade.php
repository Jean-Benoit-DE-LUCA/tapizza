@extends('layout/default')
@section('content')

<main class='main'>
    
    <h2 class='main-home-title'>Passer commande</h2>

    <div class='error-no-items-new-order'>
    </div>

    <div class='new-order-box'>

        {{ Form::open(array('method' => 'POST', 'class' => 'new-order-form')) }}

            @csrf
            
            <ul class='new-order-box-ul'>
            @isset ($objListCart)

                @foreach ($objListCart as $key => $value)

                    @if ($value['pizza'] !== 'PIZZA "TAPIZZA"')

                        <li class='new-order-box-li'>
                            <span class='new-order-box-span-title'>{{ $value['pizza'] }}</span>
                            <div class='new-order-box-price-quantity-box'>
                                <span class='new-order-box-span-price'>{{ $value['price'] }}€</span>
                                <span class='new-order-box-span-quantity'>x{{ $value['quantity'] }}</span>

                                <div class='new-order-box-plus-minus-box'>
                                    <button class='new-order-box-button-minus'>-</button>
                                    <button class='new-order-box-button-plus'>+</button>
                                </div>

                            </div>
                            <span class='new-order-box-li-span-line'></span>
                        </li>
                        
                    @endif

                @endforeach

            @endisset

            @isset ($objListCartYourPizza)

                @foreach ($objListCartYourPizza['ingredientsTaPizza'] as $key => $value)

                    <li class='new-order-box-li'>
                        <span class='new-order-box-span-title'>{{ $value['pizza'] }}</span>

                        @foreach ($value['ingredients'] as $ingredient)
                            <span class='new-order-box-span-tapizza-ingredients'>{{ '-' . $ingredient }}</span>
                        @endforeach

                        <div class='new-order-box-price-quantity-box'>
                            <span class='new-order-box-span-price'>{{ $value['price'] }}.00€</span>
                            <span class='new-order-box-span-quantity'>x{{ $value['quantity'] }}</span>

                            <div class='new-order-box-plus-minus-box'>
                                <button class='new-order-box-button-minus'>-</button>
                                <button class='new-order-box-button-plus'>+</button>
                            </div>

                        </div>
                        <span class='new-order-box-li-span-line'></span>
                    </li>

                @endforeach

            @endisset

            </ul>

            <div class='wrap-new-order-total-price'>
                <span class='new-order-total-price-span'>Prix total:</span>
                <span class='new-order-total-price-span-price'></span>
            </div>


            <section class='section-address-user'>

                <label for='address-user-delivery-input' class='address-user-delivery-label'>Adresse de livraison</label>
                <input type='text' name='address-user-delivery-input' class='address-user-delivery-input' id='address-user-delivery-input' value='{{ $getUser[0]->address }}'/>

                <label for='address-phone-user-delivery-input' class='address-phone-user-delivery-label'>Téléphone</label>
                <input type='text' name='address-phone-user-delivery-input' class='address-phone-user-delivery-input' id='address-phone-user-delivery-input' value='{{ $getUser[0]->phone }}'/>

            </section>

            <aside class='date-delivery-box'>
                <label for='date-delivery-date-input' class='date-delivery-date-label'>Choisir une date</label>
                <input type='date' name='date-delivery-date-input' class='date-delivery-date-input' id='date-delivery-date-input' min='{{ $date }}'/>

                <label for='date-delivery-time-select' class='date-delivery-time-label'>Choisir une heure</label>
                <select name='date-delivery-time-select' class='date-delivery-time-select' id='date-delivery-time-select'>

                    {{--@php

                        $i = 18;
                        $hour = getdate()['hours'] + 2;

                        if ($hour >= $i) {

                            $i = $hour + 1;

                        }

                    @endphp

                    @for ($i; $i <= 22; $i++)

                        <option value='{{ $i }}h00'>{{ $i }}h00</option>

                        @if ($i . 'h30' !== '22h30')

                            <option value='{{ $i }}h30'>{{ $i }}h30</option>

                        @endif

                    @endfor--}}

                </select>
            </aside>

            <button type='submit' name='new-order-submit-button' class='new-order-submit-button' id='new-order-submit-button'>Paiement</button>

        {{ Form::close() }}
    </div>

</main>


@stop