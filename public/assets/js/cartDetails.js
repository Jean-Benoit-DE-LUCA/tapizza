const cartDetails = {

    init: function() {

        cartDetails.addToCart();
        cartDetails.cartClick();
        cartDetails.getObjStorage();
        cartDetails.addQuantity();
        cartDetails.removeQuantity();
    },

    cartClick: function() {

        const cart = document.getElementsByClassName('cart-box')[0];

        cart.addEventListener('click', cartDetails.handleCartClick);
    },

    handleCartClick: function() {

        const cartBoxDetails = document.getElementsByClassName('cart-box-details')[0];
        cartBoxDetails.classList.toggle('active');

    },

    addToCart: function() {
        
        const gridPropositionsButtons = document.getElementsByClassName('grid-propositions-button');

        Array.from(gridPropositionsButtons).forEach( (elem) => {
            
            elem.addEventListener('click', cartDetails.handleAddToCart);
        });
    },

    handleAddToCart: async function(e) {

        /* add +1 animation */

        const oneMoreBox = document.getElementsByClassName('one-more-box')[0];
        oneMoreBox.classList.add('active');

        setTimeout(() => {
            oneMoreBox.classList.remove('active');
        }, 1500);

        /*  */

        const titlePizza = e.currentTarget.parentElement.getElementsByClassName('grid-propositions-h2')[0].textContent.trim();
        const pricePizza = e.currentTarget.parentElement.getElementsByClassName('grid-propositions-p-price')[0].textContent.trim();

        const spansTitles = document.getElementsByClassName('cart-box-details-span-title');

        let flag = false;
        Array.from(spansTitles).forEach( (elem) => {
            
            
            if (elem.textContent.trim() == titlePizza) {

                flag = true;
                let quantity = Number(elem.parentElement.getElementsByClassName('cart-box-details-span-count')[0].textContent.replace(/[^0-9]*/, ''));
                quantity += 1;
                elem.parentElement.getElementsByClassName('cart-box-details-span-count')[0].textContent = "x" + quantity;
            }

            else {

                flag = false;
            }
        });

        if (!flag) {

            let flagTwo = false;
            Array.from(spansTitles).forEach( (elem) => {

                if (elem.textContent.trim() == titlePizza) {
                    flagTwo = true;
                }
                    
            });

            if (!flagTwo) {

                const cartBoxDetails = document.getElementsByClassName('cart-box')[0].getElementsByClassName('cart-box-details')[0].getElementsByClassName('cart-box-details-ul')[0];

                cartDetails.createLiDetail(cartBoxDetails, titlePizza, pricePizza, '1');
            }
        }

        const cartBoxDetailsLi = document.getElementsByClassName('cart-box')[0].getElementsByClassName('cart-box-details')[0].getElementsByClassName('cart-box-details-ul')[0].getElementsByClassName('cart-box-details-li');

        let objListCart = {};
        Array.from(cartBoxDetailsLi).forEach( (elem, ind) => {

            const pizzaArticle = elem.getElementsByClassName('cart-box-details-span-title')[0];

            const pricePizzaArticle = elem.getElementsByClassName('cart-box-details-span-price')[0];

            const quantityPizzaArticle = elem.getElementsByClassName('cart-box-details-span-count')[0];

            objListCart[ind] = {pizza: pizzaArticle.textContent, price: pricePizzaArticle.textContent.replace('€', '').trim(), quantity: quantityPizzaArticle.textContent.replace('x', '')};
        });

        const token = document.querySelector('input[name=_token]');

        try {

            const response = await fetch('/api/setcart', {
                method: 'POST',
                headers:{
                    'Content-type': 'application/json',
                    'X-CSRF-Token' : token.value
                },
                body: JSON.stringify({
                    objListCart: objListCart
                })
            });
        }

        catch (e) {

            console.log(e);
        }

        sessionStorage.setItem('objListCart', JSON.stringify(objListCart));

    },

    getObjStorage: async function() {

        if (sessionStorage.getItem('objListCart') !== null) {

            let objListCart = JSON.parse(sessionStorage.getItem('objListCart'));

            const cartBoxDetails = document.getElementsByClassName('cart-box-details-ul')[0];

            Array.from(Object.keys(objListCart)).forEach( (elem) => {

                if (objListCart[elem]['pizza'] !== 'PIZZA "TAPIZZA"') {

                    cartDetails.createLiDetail(cartBoxDetails, objListCart[elem]['pizza'], objListCart[elem]['price'] + '€', objListCart[elem]['quantity']);
                }
                
            });

            const token = document.querySelector('input[name=_token]');

            const response = await fetch('/api/setcart', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-Token': token.value
                },
                body: JSON.stringify({
                    objListCart: objListCart
                })
            });
        }

        if (sessionStorage.getItem('objListCartYourPizza') !== null) {

            let objListCartYourPizza = JSON.parse(sessionStorage.getItem('objListCartYourPizza'));

            const cartBoxDetails = document.getElementsByClassName('cart-box-details-ul')[0];

            //

            const arrayOfIngredients = [];
            let countArr = [];

            Array.from(Object.keys(objListCartYourPizza['ingredientsTaPizza'])).forEach( (elem) => {

                arrayOfIngredients.push(objListCartYourPizza['ingredientsTaPizza'][elem]);

                countArr.push([objListCartYourPizza['ingredientsTaPizza'][elem]['quantity'], objListCartYourPizza['ingredientsTaPizza'][elem]['price']]);
                
            });

            //

            for (let i = 0; i < countArr.length; i++) {

                for (let y = 0; y < countArr[i][0]; y++) {

                    cartDetails.createLiDetail(cartBoxDetails, 'PIZZA "TAPIZZA"', `${countArr[i][1]}.00€`, 1);
                }
            }

            //

            arrayOfIngredients.map( (elem) => {
                return elem['ingredients'].sort();
            });

            const newObjOrderTaPizza = {};
            newObjOrderTaPizza['ingredientsTaPizza'] = {};

            Object.keys(arrayOfIngredients).forEach( (elem, ind) => {
                
                newObjOrderTaPizza['ingredientsTaPizza'][ind] = {pizza: 'PIZZA "TAPIZZA"', price: `${9 + arrayOfIngredients[elem]['ingredients'].length}`, quantity: arrayOfIngredients[elem]['quantity'], ingredients: arrayOfIngredients[elem]['ingredients']};

            });

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
        }

    },

    addQuantity: function() {

        const newOrderBoxButtonPlus = document.getElementsByClassName('new-order-box-button-plus');

        for (const buttonPlus of newOrderBoxButtonPlus) {

            if (buttonPlus !== undefined) {

                buttonPlus.addEventListener('click', cartDetails.handleAddQuantity);
            }
        }

    },

    handleAddQuantity: async function(e) {

        e.preventDefault();

        if (e.currentTarget.parentElement.parentElement !== null) {

            const spanIngredients = e.currentTarget.parentElement.parentElement.parentElement.getElementsByClassName('new-order-box-span-tapizza-ingredients');

            let quantityArticle = Number(e.currentTarget.parentElement.parentElement.getElementsByClassName('new-order-box-span-quantity')[0].textContent.replace('x', ''));
    
            quantityArticle++;
    
            e.currentTarget.parentElement.parentElement.getElementsByClassName('new-order-box-span-quantity')[0].textContent = `x${quantityArticle}`;
    
            const titleLiPizza = e.currentTarget.parentElement.parentElement.parentElement.getElementsByClassName('new-order-box-span-title')[0].textContent;
    
            const getObjCart = JSON.parse(sessionStorage.getItem('objListCart'));
    
            if (getObjCart !== null) {
    
                const keysGetObjCart = Object.keys(getObjCart);
            
                for (const key of keysGetObjCart) {
        
                    if (getObjCart[key]['pizza'] == titleLiPizza) {
        
                        let quantity = Number(getObjCart[key]['quantity']);
                        quantity++;
        
                        getObjCart[key]['quantity'] = quantity.toString();
        
                        const token = document.querySelector('input[name=_token]');
                        
                        const response = await fetch('/api/setcart', {
                            method: 'POST',
                            headers: {
                                'Content-type': 'application/json',
                                'X-CSRF-Token': token.value
                            },
                            body: JSON.stringify({
                                objListCart: getObjCart
                            })
                        });
        
                        sessionStorage.setItem('objListCart', JSON.stringify(getObjCart));

                        payment.spanTotalPrice();
                        
                    }
        
                }
            }
    
            if (spanIngredients.length > 0) {
    
                const getObjTaPizza = JSON.parse(sessionStorage.getItem('objListCartYourPizza'));
            
                let newPizzaArrayIngredients = [];
                for (let i = 0; i < spanIngredients.length; i++) {
        
                    newPizzaArrayIngredients.push(spanIngredients[i].textContent.replace('-', '').trim());
                }
                
                let stringToNumbers = Object.keys(getObjTaPizza['ingredientsTaPizza']).map( (elem) => {
                    return parseInt(elem);
                });
        
                let maxKey = Math.max.apply(Math, stringToNumbers);
                maxKey++;
                
                for (const key of Object.keys(getObjTaPizza['ingredientsTaPizza'])) {
    
                    if (JSON.stringify(getObjTaPizza['ingredientsTaPizza'][key]['ingredients']) == JSON.stringify(newPizzaArrayIngredients)) {
    
                        let quantity = Number(getObjTaPizza['ingredientsTaPizza'][key]['quantity']);
                        quantity++;
                        getObjTaPizza['ingredientsTaPizza'][key]['quantity'] = quantity;
                        break;
                    }
                }
    
                const token = document.querySelector('input[name=_token]');
        
                const response = await fetch('/api/setcartyourpizza', {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                        'X-CSRF-Token': token.value
                    },
                    body: JSON.stringify({
                        objListCartYourPizza: getObjTaPizza
                    })
                });
    
                sessionStorage.setItem('objListCartYourPizza', JSON.stringify(getObjTaPizza));

                payment.spanTotalPrice();
                
            }
        }
        
    },

    removeQuantity: function() {

        const newOrderBoxButtonMinus = document.getElementsByClassName('new-order-box-button-minus');

        for (const buttonMinus of newOrderBoxButtonMinus) {

            if (buttonMinus !== undefined) {

                buttonMinus.addEventListener('click', cartDetails.handleRemoveQuantity);
            }
        }
    },

    handleRemoveQuantity: async function(e) {

        e.preventDefault();

        let quantityArticle = Number(e.currentTarget.parentElement.parentElement.getElementsByClassName('new-order-box-span-quantity')[0].textContent.replace('x', ''));

        if (quantityArticle == 1) {

            e.currentTarget.parentElement.parentElement.parentElement.remove();
        }

        else {

            quantityArticle--;
        }

        e.currentTarget.parentElement.parentElement.getElementsByClassName('new-order-box-span-quantity')[0].textContent = `x${quantityArticle}`;

        const spanIngredients = e.currentTarget.parentElement.parentElement.parentElement.getElementsByClassName('new-order-box-span-tapizza-ingredients');

        if (spanIngredients.length == 0) {

            const getObjCart = JSON.parse(sessionStorage.getItem('objListCart'));

            const pizzaTitle = e.currentTarget.parentElement.parentElement.parentElement.getElementsByClassName('new-order-box-span-title')[0].textContent;

            for (const key of Object.keys(getObjCart)) {

                if (getObjCart[key]['pizza'].trim() == pizzaTitle.trim()) {

                    let quantity = Number(getObjCart[key]['quantity']);
                    quantity--;
                    getObjCart[key]['quantity'] = quantity;

                    if (quantity !== 0) {

                        const token = document.querySelector('input[name=_token]');

                        const response = await fetch('/api/setcart', {
                            method: 'POST',
                            headers: {
                                'Content-type': 'application/json',
                                'X-CSRF-Token': token.value
                            },
                            body: JSON.stringify({
                                objListCart: getObjCart
                            })
                        });
                
                        sessionStorage.setItem('objListCart', JSON.stringify(getObjCart));

                        payment.spanTotalPrice();
                    }

                    if (quantity == 0) {

                        delete getObjCart[key];

                        if (Object.keys(getObjCart).length == 0) {

                            sessionStorage.removeItem('objListCart');
                        }

                        const token = document.querySelector('input[name=_token]');

                        const response = await fetch('/api/setcart', {

                            method: 'POST',
                            headers: {
                                'Content-type': 'application/json',
                                'X-CSRF-Token': token.value
                            },
                            body: JSON.stringify({
                                objListCart: getObjCart,
                                objListCartLength: Object.keys(getObjCart).length
                            })
                        });

                        sessionStorage.setItem('objListCart', JSON.stringify(getObjCart));

                        payment.spanTotalPrice();
                    }

                    break;
                }
            }
        }

        if (spanIngredients.length > 0) {

            const getObjTaPizza = JSON.parse(sessionStorage.getItem('objListCartYourPizza'));

            const arrayIngredientsRemoveQuantity = [];
            for (let i = 0; i < spanIngredients.length; i++) {

                arrayIngredientsRemoveQuantity.push(spanIngredients[i].textContent.replace('-', '').trim());
            }

            for (const key of Object.keys(getObjTaPizza['ingredientsTaPizza'])) {

                if (JSON.stringify(getObjTaPizza['ingredientsTaPizza'][key]['ingredients']) == JSON.stringify(arrayIngredientsRemoveQuantity)) {

                    getObjTaPizza['ingredientsTaPizza'][key]['quantity']--;

                    if (getObjTaPizza['ingredientsTaPizza'][key]['quantity'] == 0) {

                        delete getObjTaPizza['ingredientsTaPizza'][key];
                    }
                }
            }

            const token = document.querySelector('input[name=_token]');

            const response = await fetch('/api/setcartyourpizza', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-Token': token.value
                },
                body: JSON.stringify({
                    objListCartYourPizza: getObjTaPizza
                })
            })

            sessionStorage.setItem('objListCartYourPizza', JSON.stringify(getObjTaPizza));

            payment.spanTotalPrice();

        }

    },

    createLiDetail: function(ulElement, namePizza, pricePizza, quantityPizza) {

        const liElem = document.createElement('li');
        liElem.setAttribute('class', 'cart-box-details-li');

        const spanElemOne = document.createElement('span');
        spanElemOne.setAttribute('class', 'cart-box-details-span-title')
        spanElemOne.textContent = namePizza;

        const spanElemTwo = document.createElement('span');
        spanElemTwo.setAttribute('class', 'cart-box-details-span-price');
        spanElemTwo.textContent = pricePizza;

        const spanElemThree = document.createElement('span');
        spanElemThree.setAttribute('class', 'cart-box-details-span-count');
        spanElemThree.textContent = `x${quantityPizza}`;

        const spanElemFour = document.createElement('span');
        spanElemFour.setAttribute('class', 'cart-box-details-li-line');

        liElem.appendChild(spanElemOne);
        liElem.appendChild(spanElemTwo);
        liElem.appendChild(spanElemThree);
        liElem.appendChild(spanElemFour);

        ulElement.appendChild(liElem);
    }
}