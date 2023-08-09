<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
    <title>Tapizzamaison</title>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-left">
                <a href="/" class="anchor-header-home">
                    <h1 class="header-title">
                        <span>Ta</span>
                        <span>Pizza</span>
                        <span>Maison</span>
                    </h1>
                </a>
            </div>
            <div class="header-right">
                <div class="pizza-container">
                    <img class="pizza-img" src="{{ asset('/assets/images/pizza-slice.png') }}" />
                    <div class="wrap-nav">
                        <nav class="nav">
                            <ul class="nav-ul">
                                <a class="nav-ul-a" href="/">
                                    <li>Accueil</li>
                                </a>
                                <a class="nav-ul-a" href="/propositions">
                                    <li>Propositions</li>
                                </a>
                                <a class="nav-ul-a" href="/tapizza">
                                    <li>Ta pizza</li>
                                </a>
                                <a class="nav-ul-a" href="/inscription">
                                    <li>Inscription</li>
                                </a>
                                
                                    @if (session()->has('userId'))
                                        <a class="nav-ul-a" href="/deconnexion">
                                            <li>Deconnexion</li>
                                        </a>
                                    @else 
                                        <a class="nav-ul-a" href="/connexion">
                                            <li>Connexion</li>
                                        </a>
                                    @endif
                                
                                <a class="nav-ul-a" href="/contact">
                                    <li>Contact</li>
                                </a>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            @if (session()->has('userId'))

                <div class="profile-box">
                    <a href="/profile">
                        <div class="profile-box-wrap-img">
                            <img class="profile-box-img" src="{{ asset('/assets/images/profile.svg') }}" />
                        </div>
                    </a>
                </div>

            @endif

            <div class="cart-box">
                <div class="cart-box-wrap-img">
                    <img class="cart-box-img" src="{{ asset('/assets/images/cart.svg') }}" />
                </div>
                <div class="cart-box-details">
                    <h3 class="cart-box-details-title">Ma commande</h3>
                    <ul class="cart-box-details-ul">

                        {{ Form::open(array('method' => 'POST', 'class' => 'cart-box-details-form')) }}
                            @csrf
                        {{ Form::close() }}
                        
                    </ul>
                    <a class="anchor-order" href="/commande">
                        <button class="anchor-order-button">Passer commande</button>
                    </a>
                </div>
                <div class="one-more-box">
                    +1
                </div>
            </div>

        </header>