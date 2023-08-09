const menu = {

    init: function() {

        menu.toggleSlicePizza();
        menu.logoutAction();
    },

    toggleSlicePizza: function() {

        const divSlicePizza = document.getElementsByClassName("pizza-container")[0];
        divSlicePizza.addEventListener("click", menu.handleToggleSlicePizza);
    },

    handleToggleSlicePizza: function(e) {

        const main = document.getElementsByClassName("main")[0];

        if (main !== undefined) {

            main.classList.toggle("active");
        }

        e.currentTarget.classList.toggle("active");

        const cartBoxDetails = document.getElementsByClassName('cart-box')[0].getElementsByClassName('cart-box-details')[0];
        if (cartBoxDetails.classList.contains('active')) {

            cartBoxDetails.classList.remove('active');
        }
        
    },

    logoutAction: function() {

        const anchorLinks = document.getElementsByClassName('nav-ul-a');

        Array.from(anchorLinks).forEach( (elem) => {

            if (elem.textContent.trim() == 'Deconnexion') {

                elem.addEventListener('click', menu.handleLogoutAction);
            }
        });
    },

    handleLogoutAction: function(e) {

        sessionStorage.removeItem('objListCart');
        sessionStorage.removeItem('objListCartYourPizza');
    }
};