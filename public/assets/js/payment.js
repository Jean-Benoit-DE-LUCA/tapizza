const payment = {

    init: function() {

        payment.clickDate();
        payment.spanTotalPrice();
        payment.setInputHiddenPrice();
        payment.setHiddenPrice();
        payment.clickPayment();
    },

    clickDate: function() {

        const dateDelivery = document.getElementsByClassName('date-delivery-date-input')[0];

        if (dateDelivery !== undefined) {

            dateDelivery.addEventListener('change', payment.handleClickDate);
        }
    },

    handleClickDate: function(e) {

        const date = new Date();
        const selectDate = document.getElementsByClassName('date-delivery-time-select')[0];

        let index = 18;
        let currentTime = `${date.getHours()}:${date.getMinutes()}`;
        let currentHour = Number(date.getHours());

        if (e.currentTarget.value < date.toISOString().split('T')[0]) {

            selectDate.innerText = null;
        }

        else if (e.currentTarget.value == date.toISOString().split('T')[0]) {

            selectDate.innerText = null;

            if (currentHour >= index) {

                index = currentHour + 1;
            }

            for (let i = index; i <= 22; i++) {

                const optionElem = document.createElement('option');
                optionElem.value = `${i}h00`;
                optionElem.textContent = `${i}h00`;

                const optionHalfElem = document.createElement('option');
                optionHalfElem.value = `${i}h30`;
                optionHalfElem.textContent = `${i}h30`;

                selectDate.appendChild(optionElem);
                if (optionHalfElem.textContent !== '22h30') {

                    selectDate.appendChild(optionHalfElem);
                }
            }
        }

        else if (e.currentTarget.value > date.toISOString().split('T')[0]) {

            selectDate.innerText = null;

            for (let i = index; i <= 22; i++) {

                const optionElem = document.createElement('option');
                optionElem.value = `${i}h00`;
                optionElem.textContent = `${i}h00`;

                const optionHalfElem = document.createElement('option');
                optionHalfElem.value = `${i}h30`;
                optionHalfElem.textContent = `${i}h30`;

                selectDate.appendChild(optionElem);
                if (optionHalfElem.textContent !== '22h30') {

                    selectDate.appendChild(optionHalfElem);
                }
            }
        }
    },

    spanTotalPrice: function() {

        const spanTotalPrice_ = document.getElementsByClassName('new-order-total-price-span-price')[0];
        
        if (spanTotalPrice_ !== undefined) {

            spanTotalPrice_.textContent = payment.setHiddenPrice() + '€';
        }
    },

    setInputHiddenPrice: function() {

        const newOrderForm = document.getElementsByClassName('new-order-form')[0];

        if (newOrderForm !== undefined) {

            const inputElem = document.createElement('input');
            inputElem.setAttribute('type', 'hidden');
            inputElem.setAttribute('name', 'input-hidden-total-price');
            inputElem.setAttribute('class', 'input-hidden-total-price');
            inputElem.setAttribute('id', 'input-hidden-total-price');
            inputElem.value = payment.setHiddenPrice();
    
            newOrderForm.appendChild(inputElem);
        }
    },

    setHiddenPrice: function() {

        let countPrice = 0;
        const objListCart = JSON.parse(sessionStorage.getItem('objListCart'));
        
        if (objListCart !== null) {

            for (const key of Object.keys(objListCart)) {

                countPrice += Number(objListCart[key]['price']) * Number(objListCart[key]['quantity']);
            }
        }

        const objListCartYourPizza = JSON.parse(sessionStorage.getItem('objListCartYourPizza'));

        if (objListCartYourPizza !== null) {

            for (const key of Object.keys(objListCartYourPizza['ingredientsTaPizza'])) {

                countPrice += Number(objListCartYourPizza['ingredientsTaPizza'][key]['price']) * Number(objListCartYourPizza['ingredientsTaPizza'][key]['quantity']);
            }
        }

        const inputHiddenPrice = document.getElementsByClassName('input-hidden-total-price')[0];
        
        if (inputHiddenPrice !== undefined) {

            inputHiddenPrice.value = countPrice;
        }
        
        return countPrice;
    },

    clickPayment: function() {

        const paymentButton = document.getElementsByClassName('new-order-submit-button')[0];

        if (paymentButton !== undefined) {

            paymentButton.addEventListener('click', payment.handleClickPayment);
        }
    },

    handleClickPayment: async function(e) {

        // GET PIZZAS DETAILS //
        
        const ulBox = document.getElementsByClassName('new-order-box-ul')[0];
        
        const liPizza = ulBox.getElementsByClassName('new-order-box-li');

        if (liPizza.length == 0) {

            e.preventDefault();
            const divErrorNewOrder = document.getElementsByClassName('error-no-items-new-order')[0];
            divErrorNewOrder.textContent = 'Impossible de passer une commande sans article';
            divErrorNewOrder.classList.add('active');

            setTimeout(() => {
                divErrorNewOrder.classList.remove('active');
            }, 1500);
        }

        const objOrder = {};

        for (let i = 0; i < liPizza.length; i++) {

            if (liPizza[i].getElementsByClassName('new-order-box-span-tapizza-ingredients').length == 0) {

                const objPizza = {
                    pizza: liPizza[i].getElementsByClassName('new-order-box-span-title')[0].textContent,
                    price: liPizza[i].getElementsByClassName('new-order-box-span-price')[0].textContent.replace('€', ''),
                    quantity: liPizza[i].getElementsByClassName('new-order-box-span-quantity')[0].textContent.replace('x', '')
                };

                Object.defineProperty(objOrder, i, {
                    value: objPizza,
                    enumerable: true
                });
            }

            else {

                const arrayIngredients = [];

                const ingredientsByPizza = liPizza[i].getElementsByClassName('new-order-box-span-tapizza-ingredients');

                for (let y = 0; y < ingredientsByPizza.length; y++) {

                    arrayIngredients.push(ingredientsByPizza[y].textContent.replace('-', ''));
                }

                const objPizza = {
                    pizza: liPizza[i].getElementsByClassName('new-order-box-span-title')[0].textContent,
                    price: liPizza[i].getElementsByClassName('new-order-box-span-price')[0].textContent.replace('€', ''),
                    quantity: liPizza[i].getElementsByClassName('new-order-box-span-quantity')[0].textContent.replace('x', ''),
                    ingredients: arrayIngredients
                };
                
                Object.defineProperty(objOrder, i, {
                    value: objPizza,
                    enumerable: true
                })
            }
        }

        // ADD TOTAL PRICE //

        let count = 0;

        for (let i = 0; i < Object.keys(objOrder).length; i++) {

            count += Number(objOrder[i]['price']) * Number(objOrder[i]['quantity']);
        }

        Object.assign(objOrder, {totalPrice: count});

        // GET ADDRESS, PHONE, TIME DETAILS //

        const userAddress = document.getElementsByClassName('address-user-delivery-input')[0];
        const userPhone = document.getElementsByClassName('address-phone-user-delivery-input')[0];
        const dateDelivery = document.getElementsByClassName('date-delivery-date-input')[0];
        const timeDelivery = document.getElementsByClassName('date-delivery-time-select')[0];
        let date = new Date();
        
        if (userAddress.value.length == 0) {

            e.preventDefault();
            userAddress.focus();
            userAddress.placeholder = 'Entrez une adresse';
        }

        else if (userPhone.value.length == 0) {

            e.preventDefault();
            userPhone.focus();
            userPhone.placeholder = 'Entrez un numéro';
        }

        else if (dateDelivery.value.length == 0 || dateDelivery.value < date.toISOString().split('T')[0] || timeDelivery.value.length == 0) {

            e.preventDefault();
            const labelDateDelivery = document.getElementsByClassName('date-delivery-date-label')[0];
            labelDateDelivery.classList.add('error');
        }

        else {

            const objData = {};

            Object.defineProperties(objData, {
                'userAddress': {
                    value: userAddress.value,
                    enumerable: true
                },
                'userPhone': {
                    value: userPhone.value,
                    enumerable: true
                },
                'dateDelivery': {
                    value: dateDelivery.value,
                    enumerable: true
                },
                'timeDelivery': {
                    value: timeDelivery.value,
                    enumerable: true
                }
            })

            Object.defineProperty(objOrder, 'userData', {
                value: objData,
                enumerable: true
            });

        }

        // ADD DATE ORDER //

        const currentDateTime = new Date();
        const formatCurrentDateTime = `${currentDateTime.getFullYear()}-${currentDateTime.getMonth()+1}-${currentDateTime.getDate()} ${currentDateTime.getHours()}:${currentDateTime.getMinutes()}:${currentDateTime.getSeconds()}`;
        
        Object.defineProperty(objOrder, 'dateTime', {
            value: formatCurrentDateTime,
            enumerable: true
        });

        // SET HIDDEN TOTAL PRICE //

        const newOrderForm = document.getElementsByClassName('new-order-form')[0];

        const inputElem = document.createElement('input');
        inputElem.setAttribute('type', 'hidden');
        inputElem.setAttribute('name', 'input-hidden-total-price');
        inputElem.setAttribute('class', 'input-hidden-total-price');
        inputElem.setAttribute('id', 'input-hidden-total-price');
        inputElem.value = count;

        newOrderForm.appendChild(inputElem);

        // API POST OBJECT //

        if (objOrder.hasOwnProperty('userData')) {

            const token = document.querySelector('input[name=_token]');
        
            const response = await fetch('/api/setorder', {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',
                    'X-CSRF-Token': token.value
                },
                body: JSON.stringify({
                    objOrder: objOrder
                })
            });
        }
    }
};