@extends('layout/default')
@section('content')

<main class='main'>
    
    <div class='error-list-added-pizza'>
        <p class='error-list-added-pizza-p'>
            
        </p>
    </div>
    
    <h2 class='main-home-title'>Ta pizza</h2>

    <div class="wrap-tapizza-text">
        <div class="section-propositions-first-div-img">
            <img class="section-propositions-first-img" src="{{ asset('/assets/images/tomato.jpg') }}" />
        </div>

        <p class='main-first-text-p'>

            Le concept est simple, tu confectionnes toi-même "tapizza" !
            On choisit jusqu'à 4 ingrédients au choix parmi ceux disponibles et votre pizzaiolo se fera un plaisir de préparer votre pizza favorite.
            Régalez-vous !
        </p>
    </div>

    <div class="wrap-tapizza-text reverse">
        <div class='tapizza-list'>
            <h3 class='tapizza-list-title'>Mes pizzas "Tapizza"</h3>
            <ul class='tapizza-list-added'>
                
            </ul>
            <div class='tapizza-ingredients-add-pizza-wrap'>
                <button class='tapizza-ingredients-add-pizza' name='tapizza-ingredients-add-pizza'>Créer pizza</button>
                <button class='tapizza-ingredients-submit-pizza' name='tapizza-ingredients-submit-pizza'>Valider</button>
            </div>
        </div>

        <p class='main-first-text-p second'>
            Retrouvez la liste de vos compositions dans la rubrique Mes pizzas "Tapizza", vous pouvez éditer vos différents choix directement ici. Une fois vos compositions prêtes, pensez à bien cliquer sur le bouton Valider afin d'enregistrer votre commande.
        </p>
    </div>

    <section class='tapizza-ingredients-choose-list'>

        <h3 class='tapizza-ingredients-choose-list-sauce-title'>Choisis "Tasauce"</h3>

        <div class="wrap-tapizza-sauce">
            <div class='tapizza-ingredients-sauce-grid'>

                @foreach($sauces as $sauce)

                    <div class='tapizza-ingredients-sauce-grid-element tapizza-ingredients-grid-elem'>
                        <div class='grid-element-img-box'>
                            <img class='grid-element-img-box-img' src='{{ asset( $sauce->sauce_image_path ) }}' />
                        </div>
                        <h4 class='grid-element-title'>{{ $sauce->name_sauce }}</h4>
                    </div>

                @endforeach

            </div>
        </div>

        <h3 class='tapizza-ingredients-choose-list-cheeses-title'>Choisis "Tesfromages"</h3>

        <div class='tapizza-ingredients-ingredients-grid'>
        <script type='text/javascript'>

            let cheeseArray = <?php echo json_encode($cheeses); ?>;
            
            let countRows = 0;
            for (let i = 0; i < Object.keys(cheeseArray).length; i += 2) {

                countRows++;
            }

            let countRowsThreeCols = 0;
            for (let i = 0; i < Object.keys(cheeseArray).length; i += 3) {

                countRowsThreeCols++;
            }

            document.documentElement.style.setProperty('--templateRows', countRows);
            document.documentElement.style.setProperty('--templateRowsThreeCols', countRowsThreeCols);

        </script>

            @foreach ($cheeses as $cheese)

                <div class='tapizza-ingredients-sauce-grid-element tapizza-ingredients-grid-elem'>
                    <div class='grid-element-img-box'>
                        <img class='grid-element-img-box-img' src='{{ asset( $cheese->cheese_path ) }}' />
                    </div>
                    <h4 class='grid-element-title'>{{ $cheese->cheese_name }}</h4>
                </div>


            @endforeach

        </div>

    </section>


</main>



@endsection