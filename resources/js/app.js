import Vue from 'vue';

import MenuManageTable from './modules/menu/MenuManageTable';
import CheckoutPage from './modules/checkoutpage/CheckoutPage';
import AddressSelect from './modules/checkoutpage/AddressSelect'
import PizzaModify from './modules/PizzaModify/PizzaModify';
import PizzaCustomize from './modules/PizzaModify/PizzaCustomize';
import Homepage from './modules/homepage/Homepage';
import OrderManageTable from'./modules/ordermanage/OrderManage';
import ShoppingCart from './modules/ordermanage/ShoppingCart';
import OrderHistory from './modules/ordermanage/OrderHistory';
import PaymentSuccess from './modules/checkoutpage/PaymentSuccess';
require('./bootstrap');
require('vue-multiselect/dist/vue-multiselect.min.css');

/// These are global components 

/// These are for the menus

const app = new Vue({
    el: '#app',
    components: {
        'menumanage-table': MenuManageTable,
        'checkoutpage': CheckoutPage,
        'homepage': Homepage,
        'address-select': AddressSelect,
        'order-manage': OrderManageTable,
        'pizza-customize': PizzaCustomize,
        'shopping-cart': ShoppingCart,
        'order-history': OrderHistory,
        'pizza-modify' : PizzaModify,
        'paymentsuccess': PaymentSuccess,
    }
});
