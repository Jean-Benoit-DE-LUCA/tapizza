const tapizzaPage = {

    init: function() {

        tapizzaPage.clickIngredient();
        tapizzaPage.submitToOrder();
    },

    count: 0,

    clickIngredient: function() {

        const gridElems = document.getElementsByClassName('tapizza-ingredients-grid-elem');

        for (const each of gridElems) {

            if (each !== undefined) {

                each.addEventListener('click', tapizzaPage.handleClickIngredient);
            }
        }

    },

    handleClickIngredient: function(e) {

        const tapizzaListAddedDivDetails = document.getElementsByClassName('tapizza-list-added-div-details');

        for (const each of tapizzaListAddedDivDetails) {

            if (each.classList.contains('active')) {

                tapizzaPage.count++;
            }
        }

        if (tapizzaListAddedDivDetails.length == 0) {

            const divErrorListAddedPizza = document.getElementsByClassName('error-list-added-pizza')[0];
            
            divErrorListAddedPizza.classList.add('active');

            const pMessage = divErrorListAddedPizza.getElementsByClassName('error-list-added-pizza-p')[0];
            pMessage.textContent = 'Veuillez créer une pizza';

            setTimeout(() => {

                divErrorListAddedPizza.classList.remove('active');
            }, 1500);
        }

        if (tapizzaPage.count >= 1 || tapizzaListAddedDivDetails.length >= 1) {

            let flag = false;

            for (const each of tapizzaListAddedDivDetails) {

                if (each.classList.contains('active')) {
    
                    flag = true;
                    break;
                }
            }

            if (flag == false) {

                const divErrorListAddedPizza = document.getElementsByClassName('error-list-added-pizza')[0];
            
                divErrorListAddedPizza.classList.add('active');

                const pMessage = divErrorListAddedPizza.getElementsByClassName('error-list-added-pizza-p')[0];
                pMessage.textContent = 'Veuillez sélectionner une pizza';

                setTimeout(() => {

                    divErrorListAddedPizza.classList.remove('active');
                }, 1500);
            }

            if (flag) {

                const divDetails = document.getElementsByClassName('tapizza-list-added-div-details active')[0];
                
                const divDetailsUl = divDetails.getElementsByClassName('tapizza-list-added-div-details-ul')[0];

                const ingredientClicked = e.currentTarget.getElementsByClassName('grid-element-title')[0].textContent;

                const divDetailsUlLi = divDetailsUl.getElementsByClassName('tapizza-list-added-div-details-ul-li');

                /* APPEND ELEMENT */

                const liElemTaPizza = document.createElement('li');
                liElemTaPizza.setAttribute('class', 'tapizza-list-added-div-details-ul-li');
                
                const spanElemDash = document.createElement('span');
                spanElemDash.setAttribute('class', 'tapizza-list-added-div-details-ul-li-spandash');
                spanElemDash.textContent = '-';

                const spanElemTaPizza = document.createElement('span');
                spanElemTaPizza.setAttribute('class', 'tapizza-list-added-div-details-ul-li-ingredient');
                spanElemTaPizza.textContent = ingredientClicked;

                const buttonRemoveElem = document.createElement('button');
                buttonRemoveElem.setAttribute('class', 'new-order-box-button-plus tapizza-list-added-div-details-ul-li-buttonremove');
                buttonRemoveElem.textContent = 'x';

                /* REMOVE BUTTON LISTENER */

                buttonRemoveElem.addEventListener('click', tapizzaPage.handleClickRemoveIngredientTaPizza);

                /* --- */

                
                liElemTaPizza.appendChild(spanElemDash);
                liElemTaPizza.appendChild(spanElemTaPizza);
                liElemTaPizza.appendChild(buttonRemoveElem);

                divDetailsUl.appendChild(liElemTaPizza);

                if (divDetailsUlLi.length > 4) {

                    Array.from(divDetailsUlLi).slice(-1)[0].remove();
                }

                let countDetTaPizza = 0;
                Array.from(divDetailsUlLi).forEach( (elem) => {
                    
                    if (elem.textContent.replace('-', '').trim() == ingredientClicked) {

                        countDetTaPizza++;

                        if (countDetTaPizza > 1) {

                            elem.remove();
                        }
                    }
                });
                
            }
        }
        
    },

    handleClickRemoveIngredientTaPizza: function(e) {

        e.stopPropagation();
        e.currentTarget.parentElement.remove();
    },

    submitToOrder: function() {

        const submitOrderButton = document.getElementsByClassName('tapizza-ingredients-submit-pizza')[0];

        if (submitOrderButton !== undefined) {

            submitOrderButton.addEventListener('click', tapizzaPage.handleSubmitToOrder);
        }
        
    },

    handleSubmitToOrder: async function(e) {

        e.preventDefault();

        const ulTagTaPizza = e.currentTarget.parentElement.parentElement.getElementsByClassName('tapizza-list-added')[0];

        const ulTagTaPizzaLiElems = ulTagTaPizza.getElementsByClassName('tapizza-list-added-li');

        const cartBoxDetailsLi = document.getElementsByClassName('cart-box')[0].getElementsByClassName('cart-box-details')[0].getElementsByClassName('cart-box-details-ul')[0].getElementsByClassName('cart-box-details-li');

        Array.from(cartBoxDetailsLi).forEach( (elem) => {
            
            const spanTaPizzaTitle = elem.getElementsByClassName('cart-box-details-span-title')[0];
            if (spanTaPizzaTitle.textContent == 'PIZZA "TAPIZZA"') {

                elem.remove();
            }
        });
        
        let ingredientsByLi = {};

        Array.from(ulTagTaPizzaLiElems).forEach( (elem) => {

            ingredientsByLi[elem.getAttribute('pizzanumber')] = [];

            const liElemsEachLi = elem.getElementsByClassName('tapizza-list-added-div-details-ul')[0].getElementsByClassName('tapizza-list-added-div-details-ul-li-ingredient');
            
            for (let i = 0; i < liElemsEachLi.length; i++) {

                const pizzaNumber = liElemsEachLi[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute('pizzanumber');

                ingredientsByLi[pizzaNumber].push(liElemsEachLi[i].textContent);
            }

            const cartBoxDetails = document.getElementsByClassName('cart-box-details-ul')[0];

            cartDetails.createLiDetail(cartBoxDetails, 'PIZZA "TAPIZZA"', `${9 + liElemsEachLi.length + '.00€'}`, 1)

            
        });

        let objListCartYourPizza = {};

        objListCartYourPizza['ingredientsTaPizza'] = ingredientsByLi;

        //

        const cartBoxDetails = document.getElementsByClassName('cart-box-details-ul')[0];

        const arrayOfIngredients = [];
        Array.from(Object.keys(objListCartYourPizza['ingredientsTaPizza'])).forEach( (elem) => {

            arrayOfIngredients.push(objListCartYourPizza['ingredientsTaPizza'][elem]);
        
        });
        
        arrayOfIngredients.map( (elem) => {
            return elem.sort();
        });

        const arrayOfIngredientsEquals = {};
        arrayOfIngredientsEquals['ingredientsTaPizza'] = {};

        for (let i = 0; i < arrayOfIngredients.length; i++) {

            if (arrayOfIngredientsEquals['ingredientsTaPizza'][arrayOfIngredients[i]]) {

                arrayOfIngredientsEquals['ingredientsTaPizza'][arrayOfIngredients[i]] += 1;
            }

            else {

                arrayOfIngredientsEquals['ingredientsTaPizza'][arrayOfIngredients[i]] = 1;
            }
        }

        const newObjOrderTaPizza = {};
        newObjOrderTaPizza['ingredientsTaPizza'] = {};

        Object.keys(arrayOfIngredientsEquals['ingredientsTaPizza']).forEach( (elem, ind) => {

            newObjOrderTaPizza['ingredientsTaPizza'][ind] = {pizza: 'PIZZA "TAPIZZA"', price: `${9 + elem.split(',').length}`, quantity: arrayOfIngredientsEquals['ingredientsTaPizza'][elem], ingredients: elem.split(',')};

        });

        // CHECK IF EMPTIES INGREDIENTS AND API POST //

        let flagEmptyLi = false;

        Array.from(Object.keys(ingredientsByLi)).forEach( (elem) => {
            
            if (ingredientsByLi[elem].length == 0) {

                flagEmptyLi = true;
            }
        });

        if (flagEmptyLi) {

            e.preventDefault();
            
            const errorDiv = document.getElementsByClassName('error-list-added-pizza')[0];
            const errorDivP = errorDiv.getElementsByClassName('error-list-added-pizza-p')[0];

            errorDiv.classList.add('active');
            errorDivP.textContent = 'Impossible de commander une pizza sans ingrédients';

            setTimeout(() => {
                errorDiv.classList.remove('active');
            }, 1500);
        }

        else {

            const token = document.querySelector('input[name=_token]');

            const response = await fetch('/api/setcartyourpizza', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-Token': token.value
                },
                body: JSON.stringify({
                    objListCartYourPizza: newObjOrderTaPizza
                })
            });
    
            sessionStorage.setItem('objListCartYourPizza', JSON.stringify(newObjOrderTaPizza));
        }
    }


}