import Vue from 'vue'
import VueRouter from 'vue-router'
import OrderIndex from '../views/order/index.vue'
import ProductIndex from '../views/product/index.vue';
import DeliveryIndex from '../views/delivery/index.vue';
import PaymentIndex from '../views/payment/index.vue';

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'OrderIndex',
        component: OrderIndex
    },
    {
        path: '/product',
        name: 'ProductIndex',
        component: ProductIndex
    },
    {
        path: '/delivery',
        name: 'DeliveryIndex',
        component: DeliveryIndex
    },
    {
        path: '/payment',
        name: 'PaymentIndex',
        component: PaymentIndex
    },
]

const router = new VueRouter({
    mode: 'hash',
    routes
})

export default router
