const addPizza = {

    init: function() {

        addPizza.clickAddPizzaButtonFunc();
        addPizza.getTaPizzaList();
    },

    countIndex: 0,

    clickAddPizzaButtonFunc: function() {

        const clickAddPizzaButton = document.getElementsByClassName('tapizza-ingredients-add-pizza')[0];

        if (clickAddPizzaButton !== undefined) {

            clickAddPizzaButton.addEventListener('click', addPizza.handleClickAddPizzaButtonFunc);
        }
        
    },

    handleClickAddPizzaButtonFunc: function(e) {

        const tapizzaListAddedDivDetails = document.getElementsByClassName('tapizza-list-added-div-details');

        for (const divDetail of tapizzaListAddedDivDetails) {

            divDetail.classList.remove('active');
        }

        addPizza.countIndex++;
        const ulTaPizza = document.getElementsByClassName('tapizza-list-added')[0];

        addPizza.createAddedPizza(ulTaPizza, addPizza.countIndex);
    },

    createAddedPizza: function(ulTag, index) {

        const liElem = document.createElement('li');
        liElem.setAttribute('class', 'tapizza-list-added-li');
        liElem.setAttribute('pizzaNumber', index);

            const spanElem = document.createElement('span');
            spanElem.setAttribute('class', 'tapizza-list-added-pizza-span');
            spanElem.textContent = 'Pizza "Tapizza"';

            const divElem = document.createElement('div');
            divElem.setAttribute('class', 'tapizza-list-added-wrap-buttons');

                const buttonEditElem = document.createElement('button');
                buttonEditElem.setAttribute('class', 'tapizza-list-added-edit-button');

                    const imgButtonEditElem = document.createElement('img');
                    imgButtonEditElem.setAttribute('class', 'tapizza-list-added-edit-button-img');
                    imgButtonEditElem.setAttribute('src', '/assets/images/edit-button.svg')

                    const divEditElem = document.createElement('div');
                    divEditElem.setAttribute('class', 'tapizza-list-added-div-details active');

                        const ulIngredients = document.createElement('ul');
                        ulIngredients.setAttribute('class', 'tapizza-list-added-div-details-ul');

                const buttonRemoveElem = document.createElement('button');
                buttonRemoveElem.setAttribute('class', 'tapizza-list-added-remove-button');
                buttonRemoveElem.textContent = 'x';


        /* APPEND ELEMENTS */

        divEditElem.appendChild(ulIngredients);

        buttonEditElem.appendChild(imgButtonEditElem);
        buttonEditElem.appendChild(divEditElem);

        divElem.appendChild(buttonEditElem);
        divElem.appendChild(buttonRemoveElem);

        liElem.appendChild(spanElem);
        liElem.appendChild(divElem);

        ulTag.appendChild(liElem);

        /* LISTENER REMOVE */

        buttonRemoveElem.addEventListener('click', addPizza.handleClickRemovePizza);

        /* LISTENER EDIT */

        buttonEditElem.addEventListener('click', addPizza.handleClickEditPizza);

    },

    handleClickRemovePizza: function(e) {

        e.currentTarget.parentElement.parentElement.remove();

        const tapizzaListUl = document.getElementsByClassName('tapizza-list-added')[0];
        
        if (tapizzaListUl.getElementsByClassName('tapizza-list-added-li').length == 0) {

            tapizzaPage.count = 0;
        }
    },

    handleClickEditPizza: function(e) {

        const tapizzaListAddedDivDetails = document.getElementsByClassName('tapizza-list-added-div-details');

        for (const divDetail of tapizzaListAddedDivDetails) {

            if (divDetail.parentElement !== e.currentTarget) {

                divDetail.classList.remove('active');
            }
            
        }

        e.currentTarget.getElementsByClassName('tapizza-list-added-div-details')[0].classList.toggle('active');
    },

    getTaPizzaList: function() {

        const getObjListCartYourPizza = JSON.parse(sessionStorage.getItem('objListCartYourPizza'));

        const ulTag = document.getElementsByClassName('tapizza-list-added')[0];

        if (ulTag !== undefined) {

            if (getObjListCartYourPizza !== null) {

                const arrayIngredients = [];

                Array.from(Object.keys(getObjListCartYourPizza['ingredientsTaPizza'])).forEach( (elem) => {

                    for(let i = 0; i < getObjListCartYourPizza['ingredientsTaPizza'][elem]['quantity']; i++) {

                        addPizza.countIndex++;
                        addPizza.createAddedPizza(ulTag, addPizza.countIndex);
                    }

                    for (let y = 0; y < getObjListCartYourPizza['ingredientsTaPizza'][elem]['quantity']; y++) {

                        arrayIngredients.push(getObjListCartYourPizza['ingredientsTaPizza'][elem]['ingredients']);
                    }
                });
        
                const tapizzaListAddedLi = document.getElementsByClassName('tapizza-list-added-li');
        
                Array.from(tapizzaListAddedLi).forEach( (elem, ind) => {
        
                    const tapizzaListAddedDivDetailsUl = document.getElementsByClassName('tapizza-list-added-div-details-ul');

                    for (let i = 0; i < arrayIngredients[ind].length; i++) {
        
                        const liElemTaPizza = document.createElement('li');
                        liElemTaPizza.setAttribute('class', 'tapizza-list-added-div-details-ul-li');
            
                        const spanElemDash = document.createElement('span');
                        spanElemDash.setAttribute('class', 'tapizza-list-added-div-details-ul-li-spandash');
                        spanElemDash.textContent = '-';
        
                        const spanElemTaPizza = document.createElement('span');
                        spanElemTaPizza.setAttribute('class', 'tapizza-list-added-div-details-ul-li-ingredient');
                        spanElemTaPizza.textContent = arrayIngredients[ind][i];
        
                        const buttonRemoveElem = document.createElement('button');
                        buttonRemoveElem.setAttribute('class', 'new-order-box-button-plus tapizza-list-added-div-details-ul-li-buttonremove');
                        buttonRemoveElem.textContent = 'x';
        
                        buttonRemoveElem.addEventListener('click', tapizzaPage.handleClickRemoveIngredientTaPizza);
        
                        liElemTaPizza.appendChild(spanElemDash);
                        liElemTaPizza.appendChild(spanElemTaPizza);
                        liElemTaPizza.appendChild(buttonRemoveElem);
        
                        tapizzaListAddedDivDetailsUl[ind].appendChild(liElemTaPizza);
                    };
                });
            }
        }
    },
}