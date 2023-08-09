const order = {

    init: function() {

        order.anchorOrderFunc();
    },

    anchorOrderFunc: function() {

        const anchorOrder = document.getElementsByClassName('anchor-order')[0];
        anchorOrder.addEventListener('click', order.handleAnchorOrderFunc);
    },

    handleAnchorOrderFunc: async function(e) {

        const token = document.querySelector('input[name=_token]');

        const objListCart = JSON.parse(sessionStorage.getItem('objListCart'));

        if (objListCart !== null) {

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

        const objListCartYourPizza = JSON.parse(sessionStorage.getItem('objListCartYourPizza'));

        const cartBoxDetails = document.getElementsByClassName('cart-box-details-ul')[0];

        if (objListCartYourPizza !== null) {

            const arrayOfIngredients = [];
            Array.from(Object.keys(objListCartYourPizza['ingredientsTaPizza'])).forEach( (elem) => {
    
                arrayOfIngredients.push(objListCartYourPizza['ingredientsTaPizza'][elem]);        
            });
            
            arrayOfIngredients.map( (elem) => {
                return elem['ingredients'].sort();
            });
    
            const newObjOrderList = {};
            newObjOrderList['ingredientsTaPizza'] = {};

            for (const key of Object.keys(arrayOfIngredients)) {

                newObjOrderList['ingredientsTaPizza'][key] = arrayOfIngredients[key];
            }
    
            const responseYourPizza = await fetch('/api/setcartyourpizza', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-Token': token.value
                },
                body: JSON.stringify({
                    objListCartYourPizza: newObjOrderList
                })
            });
        }
    },
}