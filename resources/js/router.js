import { createRouter, createWebHistory } from "vue-router";

import Home from "./pages/Home.vue";
import Restaurant from "./pages/Restaurant.vue";
import Cart from "./pages/Cart.vue";
import Team from "./pages/Team.vue";
import Error404 from "./pages/Error404.vue";
import SuccessPayment from './pages/SuccessPayment.vue';

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: "active",
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    },
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/ristorante/:slug",
            name: "restaurant",
            component: Restaurant,
        },
        {
            path: "/carrello",
            name: "cart",
            component: Cart,
        },
        {
            path: "/team",
            name: "team",
            component: Team,
        },
        {
            path: "/pagamento/successo",
            name: "successPayment",
            component: SuccessPayment
        },
        {
            path: "/:pathMatch(.*)*",
            component: Error404,
            name: "404",
        },
    ],
});

export { router };
