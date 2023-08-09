const app = {

    init: function() {

        payment.init();
        tapizzaPage.init();
        addPizza.init();
        order.init();
        cartDetails.init();
        menu.init();
    },
};

window.addEventListener("DOMContentLoaded", app.init);